<?php

namespace App\Http\Controllers;

use App\Models\Transfer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Suplier;
use App\Models\Catalog;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TransferController extends Controller
{
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
                    ->selectRaw('s.suplier_name, t.status, t.uuid, t.created_at, t.updated_at')
                    ->whereBetween("t.created_at", [$dFrom, $dTo]) 
                    ->paginate(20);

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
            'suplier_id' => 'required'
        ]);
        
        $transfer = Transfer::create($validated);

        return redirect("/transfer/".$transfer->uuid."/edit")->with("success", "Sikeres felvétel!");
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
        ->where('t.transfer_id', '=', $transfer->transfer_id)
        ->select('t.transfer_id', 't.uuid', 't.status', 't.created_at', 't.updated_at')
        ->first();

        $Transactions = Transaction::where('inner_table_id', $transfer->uuid)
            ->where('type', 'TRANSFER')
            ->with(['product.brand', 'product.catalog'])
            ->paginate();

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
                    
                    $fifoPrices[$key]['qty'] = 0;
                    $saleQty -= $takeAmount;
                }
            }

            if ($saleQty > 0) {
                // Itt kezelheted a hibát (pl. hibaüzenet, vagy a maradékot beírod az aktuális legfrissebb áron)
            }
        
        }

        Transfer::where('transfer_id', $transfer->transfer_id)->update(['status' => 'COMPLETED']);
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
