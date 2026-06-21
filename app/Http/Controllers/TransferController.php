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
    public function index()
    {
        $d = Carbon::now()->format('Y-m-d');
        $Transfers = Transfer::whereDate("created_at", "=", $d)->limit(500)->paginate();
        $Brands = Brand::get();
        $Catalogs = Catalog::get();

        $Groups = DB::table('transactions')
                ->selectRaw('inner_table_id, SUM(sale_price * qty * -1) as total_sum')
                ->whereDate('created_at', $d)
                ->where('type', 'OUT')
                ->groupBy('inner_table_id')
                ->get();

        return view('Transfer/transfer', compact('Transfers', 'Groups', 'Brands', 'Catalogs'));
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
        //
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
