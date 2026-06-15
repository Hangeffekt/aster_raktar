<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Brand;
use App\Models\Catalog;
use App\Models\Sale;
use App\Models\SaleStatus;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Monolog\LogRecord;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cartItems = Cart::where('user_id', 1)->paginate(50);
        $Brands = Brand::get();
        $Catalogs = Catalog::get();
        $SaleStatus = SaleStatus::get();

        return view('cart', compact('cartItems', 'Brands', 'Catalogs', 'SaleStatus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'inner_table_id' => 'required|numeric',
            'product_id' => 'required|numeric',
            'qty' => 'required|numeric',
            'sale_price' => 'required|numeric'
        ]);
        
        Transaction::create(['inner_table_id' => $validated['inner_table_id'],
                                        'qty' => $validated['qty'] * -1,
                                        'sale_price' => $validated['sale_price'],
                                        'product_id' => $validated['product_id'],
                                        'type' => 'OUT']);
        return redirect("/sales/".$validated['inner_table_id']."/edit")->with("success", "Sikeres felvétel!");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show(Cart $cart)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function edit(Cart $cart)
    {
        $cartItems = Transaction::where('type', 'OUT')->where('inner_table_id', $cart)->paginate(50);

        return view('cart', compact('cartItems'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaction  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $cart)
    {
        $validated = $request->validate([
            'sale_price' => 'required|numeric',
            'qty' => 'required|numeric'
        ]);
        Transaction::where("id", $cart->id)->update(['qty' => $validated['qty'] * -1,
                                            'sale_price' => $validated['sale_price'],]);

        return redirect("/sales/".$cart->inner_table_id."/edit")->with("success", "Sikeres módosítás!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaction  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $cart)
    {
        $deleteCart = Transaction::findOrFail($cart->id);
        $deleteCart->delete();
        
        return redirect("/sales/".$cart->inner_table_id."/edit")->with("success", "Sikeres törlés!");
    }

    public function closeCart(Request $request)
    {
        $transactions = Transaction::where('product_id', 9)
            ->where('created_at', '>=', function ($query)
             {
                $query->selectRaw("COALESCE(MAX(created_at), '1970-01-01 00:00:00')")
                    ->from('transactions')
                    ->where('type', 'SETTLE')
                    ->where('product_id', 9);
            })
            ->where('status', '!=', 'PENDING')
            ->select('id', 'type', 'qty', 'sale_price', 'net_price')
            ->orderBy('created_at', 'ASC')
            ->get();

        $currentStock = 0;
        foreach ($transactions as $t) {
            if ($t->type == 'OUT') {
                $currentStock -= abs($t->qty);
            } else {
                $currentStock += $t->qty;
            }
        }
        
        $incomingShipments = $transactions->whereIn('type', ['SETTLE', 'IN'])->sortBy('created_at');

        $remainingToFind = $currentStock;
        $fifoPrices = [];

        foreach ($incomingShipments as $shipment) {
            if ($remainingToFind <= 0) break;

            $takenFromThis = min($shipment->qty, $remainingToFind);
            
            $fifoPrices[] = [
                'qty' => $takenFromThis,
                'net_price' => $shipment->net_price,
                'sale_price' => $shipment->sale_price
            ];

            $remainingToFind -= $takenFromThis;
        }

        $saleQty = 5;

        foreach ($fifoPrices as $key => $batch) {
            if ($saleQty <= 0)
                break;

            if ($batch['qty'] <= 0)
                continue;

            if ($batch['qty'] >= $saleQty) {
                // 1. ESET: Ez a szállítmány teljesen fedezi a hiányzó mennyiséget
                
                // Mentés az adatbázisba ($saleQty darabszámmal és a $batch['net_price'] árral)
                // DB::table('transactions')->insert([... 'qty' => $saleQty, 'net_price' => $batch['net_price'] ...]);
                
                // Levonjuk a tömbből is, ha később még kellene a frissített készlet
                $fifoPrices[$key]['qty'] -= $saleQty; 
                
                $saleQty = 0; // Mindent eladtunk, a következő körben a break kiléptet
            } else {
                // 2. ESET: Ez a szállítmány nem elég, az egészet kiürítjük, és megyünk a következőre
                $takeAmount = $batch['qty']; // Amennyi van benne (pl. 2 db, miközben 3-at akartunk)
                
                // Mentés az adatbázisba ($takeAmount darabszámmal és a $batch['net_price'] árral)
                // DB::table('transactions')->insert([... 'qty' => $takeAmount, 'net_price' => $batch['net_price'] ...]);
                
                $fifoPrices[$key]['qty'] = 0; // Kiürítettük a szállítmányt
                $saleQty -= $takeAmount; // Csökkentjük a még eladandó mennyiséget (marad 1 db)
            }
        }

        // BIZTONSÁGI ELLENŐRZÉS: 
        // Ha a ciklus lefutott, de a $saleQty még mindig nagyobb, mint 0, 
        // az azt jelenti, hogy több árut akartál eladni, mint amennyi valójában raktáron volt (negatív készlet).
        if ($saleQty > 0) {
            // Itt kezelheted a hibát (pl. hibaüzenet, vagy a maradékot beírod az aktuális legfrissebb áron)
        }
        dd($saleQty);
        return redirect("/sale")->with("success", "Sikeres rögzítés!");
    }
}
