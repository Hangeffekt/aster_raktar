<?php

namespace App\Http\Controllers;

use App\Models\Transfer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Suplier;
use App\Models\Catalog;
use App\Models\Transaction;
use App\Models\SystemAlert;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Illuminate\Support\Facades\Auth;

class TransferController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(PermissionMiddleware::using('show transfers'), only: ['index','show']),
            new Middleware(PermissionMiddleware::using('show transfers'), except: ['create','store','edit','update','destroy']),
            new Middleware(PermissionMiddleware::using('create transfer'), only: ['store']),
            new Middleware(PermissionMiddleware::using('create transfer'), except: ['create','index','show','edit','update','destroy']),
            new Middleware(PermissionMiddleware::using('edit transfer'), only: ['edit','update']),
            new Middleware(PermissionMiddleware::using('edit transfer'), except: ['index','show','create','store','destroy']),
            new Middleware(PermissionMiddleware::using('delete transfer'), only: ['destroy']),
            new Middleware(PermissionMiddleware::using('delete transfer'), except: ['index','create','show','store','edit','update']),
        ];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $dFromInput = $request->input('date-from') ?? Carbon::now()->format('Y-m-d');
        $dFrom = Carbon::parse($dFromInput)->startOfDay()->toDateTimeString();
        $dToInput = $request->input('date-to') ?? Carbon::now()->format('Y-m-d');
        $dTo = Carbon::parse($dToInput)->endOfDay()->toDateTimeString();
        $Transfers = DB::table('transfers as t')
                    ->join('supliers as s', 's.suplier_id', '=', 't.suplier_id')
                    ->leftJoin('users as u', 't.approves', '=', 'u.id')
                    ->selectRaw('u.name, s.suplier_name, t.status, t.uuid, t.created_at, t.updated_at')
                    ->whereBetween("t.created_at", [$dFrom, $dTo]) 
                    ->paginate(10);

        $Groups = DB::table('transactions')
                ->selectRaw('inner_table_id, SUM(sale_price * qty * -1) as total_sum')
                ->whereBetween("created_at", [$dFrom, $dTo])
                ->where('type', 'OUT')
                ->groupBy('inner_table_id')
                ->get();

        return view('Transfer/transfer', compact('Transfers', 'Groups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("Transfer/createtransfer", [
            'Supliers' => Suplier::get()
        ]);
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
            'suplier_id' => 'required|uuid|exists:supliers,uuid'
        ]);
        
        $suplierId = Suplier::where('uuid', $validated['suplier_id'])->first();
        $transfer = Transfer::create(['suplier_id' => $suplierId->suplier_id]);

        return redirect("/transfer/".$transfer->uuid."/edit")->with("success", "Successfull created!");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transfer  $transfer
     * @return \Illuminate\Http\Response
     */
    public function show(Transfer $transfer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transfer  $transfer
     * @return \Illuminate\Http\Response
     */
    public function edit(Transfer $transfer)
    {
        $Transfer = DB::table('transfers as t')
            ->join('supliers as s', 's.suplier_id', '=', 't.suplier_id')
            ->where('t.transfer_id', '=', $transfer->transfer_id)
            ->select('s.suplier_name','t.transfer_id', 't.uuid', 't.status', 't.created_at', 't.updated_at')
            ->first();

        $Transactions = Transaction::where('inner_table_id', $transfer->uuid)
            ->where('type', 'TRANSFER')
            ->with(['product.brand', 'product.catalog'])
            ->paginate(10);

        $Brands = Brand::get();
        $Catalogs = Catalog::get();

        return view('Transfer/edittransfer', compact('Transactions', 'Transfer', 'Brands', 'Catalogs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transfer  $transfer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transfer $transfer)
    {
        $FinishTransactions = Transaction::where('inner_table_id', $transfer->uuid)
            ->where('type', 'TRANSFER')
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

        Transfer::where('transfer_id', $transfer->transfer_id)->update(['status' => 'COMPLETED', 'approves' => Auth::id()]);
        return redirect()->back()->with("success", "Successful save!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transfer  $transfer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transfer $transfer)
    {
        Transaction::where('inner_table_id', $transfer->uuid)->delete();
        Transfer::findOrFail($transfer->transfer_id)->delete();

        return redirect("/transfer/")->with("success", "Succesfull delete!");
    }
}
