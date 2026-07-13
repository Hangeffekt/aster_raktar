<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Brand;
use App\Models\Catalog;
use App\Models\PaymentType;
use App\Models\Transaction;
use App\Models\SystemAlert;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Illuminate\Support\Facades\Auth;

class SaleController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(PermissionMiddleware::using('show sales'), only: ['index','show']),
            new Middleware(PermissionMiddleware::using('show sales'), except: ['create','store','edit','update','destroy']),
            new Middleware(PermissionMiddleware::using('create sale'), only: ['store']),
            new Middleware(PermissionMiddleware::using('create sale'), except: ['create','index','show','edit','update','destroy']),
            new Middleware(PermissionMiddleware::using('edit sale'), only: ['edit','update']),
            new Middleware(PermissionMiddleware::using('edit sale'), except: ['index','show','create','store','destroy']),
            new Middleware(PermissionMiddleware::using('delete sale'), only: ['destroy']),
            new Middleware(PermissionMiddleware::using('delete sale'), except: ['index','create','show','store','edit','update']),
        ];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $d = Carbon::now()->format('Y-m-d');
        $dFromInput = $request->input('date-from') ?? Carbon::now()->format('Y-m-d');
        $dFrom = Carbon::parse($dFromInput)->startOfDay()->toDateTimeString();
        $dToInput = $request->input('date-to') ?? Carbon::now()->format('Y-m-d');
        $dTo = Carbon::parse($dToInput)->endOfDay()->toDateTimeString();
        $Sales = DB::table('sales as s')
                ->selectRaw('u.name, s.uuid, s.sale_status, t.payment_type, s.created_at, s.updated_at')
                ->join('payment_types as t', 't.payment_id', '=', 's.payment_type')
                ->leftJoin('users as u', 's.approves', '=', 'u.id')
                ->whereBetween("s.created_at", [$dFrom, $dTo])
                ->orderBy('s.created_at', 'asc')
                ->paginate(20);
                
        $Today = Transaction::whereDate('created_at', $d)
                            ->where('type', 'OUT')
                            ->selectRaw('SUM(sale_price * qty) as total_sum')
                            ->first()
                            ->total_sum;
        $Groups = DB::table('transactions')
                ->selectRaw('inner_table_id, SUM(sale_price * qty * -1) as total_sum')
                ->whereBetween("created_at", [$dFrom, $dTo])
                ->where('type', 'OUT')
                ->groupBy('inner_table_id')
                ->get();
        
        $Cashes= DB::table('sales as s')
                ->join('transactions as t', 's.sale_id', '=', 't.inner_table_id')
                ->select(
                    's.payment_type', 
                    DB::raw('SUM(t.sale_price * t.qty) as total_calculated_sum')
                )
                ->whereDate('t.created_at', $d)
                ->where('t.type', 'OUT')
                ->groupBy('s.payment_type')
                ->get();
        $PaymentTypes = PaymentType::get();

        return view('Sale/sales', compact('Sales', 'Groups', 'Today', 'Cashes', 'PaymentTypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        return redirect("/sales/".$Sale->uuid."/edit")->with("success", "Successfull created!");
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
            ->join('payment_types as st', 'st.payment_id', '=', 's.payment_type')
            ->where('s.sale_id', '=', $sale->sale_id)
            ->select('st.payment_type', 's.uuid', 's.sale_id', 's.customer_code', 's.sale_status', 's.created_at', 's.updated_at')
            ->first();

        $Transactions = Transaction::where('inner_table_id', $sale->uuid)
            ->where('type', 'OUT')
            ->with(['product.brand', 'product.catalog'])
            ->paginate(20);

        $Brands = Brand::get();
        $Catalogs = Catalog::get();
        $SaleStatus = PaymentType::get();

        return view('Sale/editsale', compact('Transactions', 'Sale', 'Brands', 'Catalogs', 'SaleStatus'));
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
        $validated = $request->validate([
            'closeNote' => 'required',
            'payment_type' => 'required|uuid|exists:payment_types,uuid',
        ]);

        $FinishTransactions = Transaction::where('inner_table_id', $sale->uuid)
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
                ->select('id', 'type', 'qty', 'sale_price', 'net_price', 'created_at')
                ->orderBy('created_at', 'ASC')
                ->get();

                $currentStock = 0;
                foreach ($transactions as $t) {
                    $currentStock += $t->qty;
            }
            
            $incomingShipments = $transactions->whereIn('type', ['SETTLE', 'IN', 'STORNO'])->sortByDesc('created_at');

            $remainingToFind = $currentStock;
            $fifoPrices = [];

            foreach ($incomingShipments as $shipment) {
                if ($remainingToFind <= 0) break;

                $takenFromThis = min($shipment->qty, $remainingToFind);
                
                $fifoPrices[] = [
                    'id' => $shipment->id,
                    'qty' => $takenFromThis,
                    'net_price' => $shipment->net_price,
                ];

                $remainingToFind -= $takenFromThis;
            }
            
            $saleQty = $FinishTransaction->qty * -1;
            $last_price = 0;
            
            foreach ($fifoPrices as $key => $batch) {
                if ($saleQty <= 0)
                    break;

                if ($batch['qty'] <= 0)
                    continue;

                if ($batch['qty'] >= $saleQty) {
                    
                    Transaction::where('id', $FinishTransaction->id)->update(['status' => 'COMPLETED', 'net_price' => $fifoPrices[$key]['net_price'], 'reference' => $fifoPrices[$key]['id']]);
                    
                    $fifoPrices[$key]['qty'] -= $saleQty; 
                    
                    $saleQty = 0;
                } else {
                    $takeAmount = $batch['qty'];

                    Transaction::where('id', $FinishTransaction->id)->update(['net_price' => $fifoPrices[$key]['net_price']]);
                    $last_price = $fifoPrices[$key]['net_price'];
                    
                    
                    $fifoPrices[$key]['qty'] = 0;
                    $saleQty -= $takeAmount;
                }
            }

            if ($saleQty > 0) {
                Transaction::where('id', $FinishTransaction->id)->update(['net_price' => $last_price, 'status' => 'COMPLETED']);

                SystemAlert::create([
                    'level' => 'error',
                    'message' => 'negativ stock',
                    'product_uuid' => $FinishTransaction->id,
                    'trigger_by' => Auth::id()
                ]);
            }
        
        }

        $payment_id = PaymentType::where('uuid', $request->payment_type)->first();
        Sale::where('sale_id', $sale->sale_id)->update(['payment_type' => $payment_id->payment_id, 'sale_status' => 'COMPLETED', 'approves' => Auth::id()]);
        return redirect()->back()->with("success", "Successful save!");
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
        
        return redirect("/sales")->with("success", "Successful delete!");
    }
}
