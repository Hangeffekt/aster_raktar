<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Brand;
use App\Models\Catalog;
use App\Models\SaleStatus;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $d = Carbon::now()->format('Y-m-d');
        $Sales = Sale::whereDate("created_at", "=", $d)->limit(500)->paginate();
        $Brands = Brand::get();
        $Catalogs = Catalog::get();
        $SaleStatuses = SaleStatus::get();
        $Today = Transaction::whereDate('created_at', $d)
                            ->where('type', 'OUT')
                            ->selectRaw('SUM(sale_price * qty) as total_sum')
                            ->first()
                            ->total_sum;
        $Groups = DB::table('transactions')
                ->selectRaw('inner_table_id, SUM(sale_price * qty * -1) as total_sum')
                ->whereDate('created_at', $d)
                ->where('type', 'OUT')
                ->groupBy('inner_table_id')
                ->get();
        
        $Cashes= DB::table('sales as s')
                ->join('transactions as t', 's.sale_id', '=', 't.inner_table_id')
                ->select(
                    's.payment_status', 
                    DB::raw('SUM(t.sale_price * t.qty) as total_calculated_sum')
                )
                ->whereDate('t.created_at', $d)
                ->where('t.type', 'OUT')
                ->groupBy('s.payment_status')
                ->get();

        return view('sales', compact('Sales', 'Brands', 'Catalogs', 'Groups', 'SaleStatuses', 'Today', 'Cashes'));
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
        $Sale = Sale::create();
        return redirect("/sales/".$Sale->sale_id."/edit")->with("success", "Sikeres felvétel!");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function show(Sale $sale)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function edit(Sale $sale)
    {
        $Sale = DB::table('sales as s')
        ->join('sale_statuses as st', 'st.sale_status_id', '=', 's.payment_status')
        ->where('s.sale_id', '=', $sale->sale_id)
        ->select('st.sale_status_name', 's.sale_id', 's.customer_code', 's.sale_status', 's.created_at', 's.updated_at')
        ->first();

        $Transactions = Transaction::where('inner_table_id', $sale->sale_id)
            ->with(['product.brand', 'product.catalog'])
            ->paginate();

        $Brands = Brand::get();
        $Catalogs = Catalog::get();
        $SaleStatus = SaleStatus::get();
        
        return view('editsale', compact('Transactions', 'Sale', 'Brands', 'Catalogs', 'SaleStatus'));
    }

    /**
     * Update the specified resource in storage.
     * Close sale.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sale $sale)
    {
        $FinishTransactions = Transaction::where('inner_table_id', $sale->sale_id)
            ->where('type', 'OUT')
            ->get();
        
        foreach($FinishTransactions as $FinishTransaction){
            $transactions = Transaction::where('product_id', $FinishTransaction->product_id)
                ->where('created_at', '>=', function ($query) use ($FinishTransaction)
                {
                    $query->selectRaw("COALESCE(MAX(created_at), '1970-01-01 00:00:00')")
                        ->from('transactions')
                        ->where('type', 'SETTLE')
                        ->where('product_id', $FinishTransaction->product_id);
                })
                ->where('status', '!=', 'PENDING')
                ->select('id', 'type', 'qty', 'sale_price', 'net_price')
                ->orderBy('created_at', 'DESC')
                ->get();

            $currentStock = 0;
            foreach ($transactions as $t) {
                $currentStock += $t->qty;
            }
            
            $incomingShipments = $transactions->whereIn('type', ['SETTLE', 'IN']);

            $remainingToFind = $currentStock;
            $fifoPrices = [];

            foreach ($incomingShipments as $shipment) {
                if ($remainingToFind <= 0) break;

                $takenFromThis = min($shipment->qty, $remainingToFind);
                
                $fifoPrices[] = [
                    'id' => $shipment->id,
                    'qty' => $takenFromThis,
                    'net_price' => $shipment->net_price,
                    'sale_price' => $shipment->sale_price
                ];

                $remainingToFind -= $takenFromThis;
            }

            $saleQty = $FinishTransaction->qty * -1;
            
            foreach ($fifoPrices as $key => $batch) {
                if ($saleQty <= 0)
                    break;

                if ($batch['qty'] <= 0)
                    continue;

                if ($batch['qty'] >= $saleQty) {
                    // 1. ESET: Ez a szállítmány teljesen fedezi a hiányzó mennyiséget
                    
                    // Mentés az adatbázisba ($saleQty darabszámmal és a $batch['net_price'] árral)
                    // DB::table('transactions')->insert([... 'qty' => $saleQty, 'net_price' => $batch['net_price'] ...]);
                    Transaction::where('id', $FinishTransaction->id)->update(['status' => 'COMPLETED', 'net_price' => $fifoPrices[$key]['net_price']]);
                    
                    // Levonjuk a tömbből is, ha később még kellene a frissített készlet
                    $fifoPrices[$key]['qty'] -= $saleQty; 
                    
                    $saleQty = 0; // Mindent eladtunk, a következő körben a break kiléptet
                } else {
                    // 2. ESET: Ez a szállítmány nem elég, az egészet kiürítjük, és megyünk a következőre
                    $takeAmount = $batch['qty']; // Amennyi van benne (pl. 2 db, miközben 3-at akartunk)
                    
                    // Mentés az adatbázisba ($takeAmount darabszámmal és a $batch['net_price'] árral)
                    // DB::table('transactions')->insert([... 'qty' => $takeAmount, 'net_price' => $batch['net_price'] ...]);
                    Transaction::where('id', $FinishTransaction->id)->update(['net_price' => $fifoPrices[$key]['net_price']]);
                    
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
        
        }

        Sale::where('sale_id', $sale->sale_id)->update(['payment_status' => $request->payment_status, 'sale_status' => 'CLOSED']);
        return redirect()->back()->with("success", "Sikeres mentés!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sale $sale)
    {
        $deleteSale = Transaction::findOrFail($sale->sale_id);
        $deleteSale->delete();
        
        return redirect("/sales")->with("success", "Sikeres törlés!");
    }

    public function history(Request $request)
    {
        $d = date('Y-m-d', strtotime($request->date));
        $Sales = Sale::whereDate("created_at", "=", $d)->limit(500)->paginate();
        $Brands = Brand::get();
        $Catalogs = Catalog::get();
        $SaleStatuses = SaleStatus::get();
        $Today = Transaction::whereDate('created_at', $d)
                            ->where('type', 'OUT')
                            ->selectRaw('SUM(sale_price * qty) as total_sum')
                            ->first()
                            ->total_sum;
        $Groups = DB::table('transactions')
                ->selectRaw('inner_table_id, SUM(sale_price * qty) as total_sum')
                ->whereDate('created_at', $d)
                ->where('type', 'OUT')
                ->groupBy('inner_table_id')
                ->get();
        $Cashes= DB::table('sales as s')
                ->join('transactions as t', 's.sale_id', '=', 't.inner_table_id')
                ->select(
                    's.payment_status', 
                    DB::raw('SUM(t.sale_price * t.qty) as total_calculated_sum')
                )
                ->whereDate('t.created_at', $d)
                ->where('t.type', 'OUT')
                ->groupBy('s.payment_status')
                ->get();

        return view('/sales', compact('Sales', 'Brands', 'Catalogs', 'SaleStatuses', 'Today', 'Groups', 'Cashes'));
    }
}
