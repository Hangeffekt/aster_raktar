<?php

namespace App\Http\Controllers;

use App\Models\InventoryAdjustment;
use App\Models\Brand;
use App\Models\Catalog;
use App\Models\Transaction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class InventoryAdjustmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $dFromInput = $request->input('date-from') ?? Carbon::now()->format('Y-m-d');
        $dFrom = Carbon::parse($dFromInput)->startOfDay()->toDateTimeString();
        $dToInput = $request->input('date-to') ?? Carbon::now()->format('Y-m-d');
        $dTo = Carbon::parse($dToInput)->endOfDay()->toDateTimeString();
        $Adjustments = DB::table('inventory_adjustments as ia')
                    ->leftJoin('users as u', 'ia.approves', '=', 'u.id')
                    ->selectRaw('u.name, ia.id, ia.status, ia.uuid, ia.created_at, ia.updated_at')
                    ->whereBetween("ia.created_at", [$dFrom, $dTo])
                    ->paginate(20);
        
        return view('InventoryAdjustment/inventoryadjustments', compact('Adjustments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("InventoryAdjustment/creteinventoryadjustments", [
            'AdjustmentTypes' => DB::table('adjustment_types')->get()
        ]);
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $InventoryAdjustment = InventoryAdjustment::create();
        return redirect("/inventory-adjustments/".$InventoryAdjustment->uuid."/edit")->with("success", "Successfull created!");
    }

    /**
     * Display the specified resource.
     */
    public function show(InventoryAdjustment $inventoryAdjustment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InventoryAdjustment $inventoryAdjustment)
    {
        $Adjustment = DB::table('inventory_adjustments as ia')
            ->where('ia.id', '=', $inventoryAdjustment->id)
            ->selectRaw('ia.id, ia.status, ia.uuid, ia.created_at, ia.updated_at')
            ->first();

        $Transactions = Transaction::where('inner_table_id', $Adjustment->uuid)
            ->where('type', 'ADJUSTMENT')
            ->with(['product.brand', 'product.catalog'])
            ->paginate(20);

        $Brands = Brand::get();
        $Catalogs = Catalog::get();

        return view('InventoryAdjustment/editinventoryadjustment', compact('Transactions', 'Adjustment', 'Brands', 'Catalogs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InventoryAdjustment $inventoryAdjustment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InventoryAdjustment $inventoryAdjustment)
    {
        //
    }
}
