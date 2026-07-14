<?php

namespace App\Http\Controllers;

use App\Models\InventoryAdjustment;
use App\Models\Brand;
use App\Models\Catalog;
use App\Models\SystemAlert;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Http\Requests\InventoryAdjustmentPostRequest;

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
                    ->leftJoin('adjustment_types as at', 'ia.adjustment_type', '=', 'at.id')
                    ->selectRaw('at.adjustment_type, u.name, ia.id, ia.status, ia.uuid, ia.created_at, ia.updated_at')
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
    public function store(InventoryAdjustmentPostRequest $request)
    {
        $InventoryAdjustment = InventoryAdjustment::create(['adjustment_type' => $request->adjustmentId]);
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
            ->leftJoin('adjustment_types as at', 'ia.adjustment_type', '=', 'at.id')
            ->where('ia.id', '=', $inventoryAdjustment->id)
            ->selectRaw('at.adjustment_type, ia.id, ia.status, ia.uuid, ia.created_at, ia.updated_at')
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
        $validated = $request->validate([
            'closeNote' => 'required',
        ]);

        $FinishInventoryAdjustment = Transaction::where('inner_table_id', $inventoryAdjustment->uuid)
            ->where('type', 'ADJUSTMENT')
            ->get();

        foreach($FinishInventoryAdjustment as $FinishTransaction){
            Transaction::where('id', $FinishTransaction->id)->update(['status' => 'COMPLETED']);

            if(currentStock($FinishTransaction->product_id) < 0)
                SystemAlert::create([
                    'level' => 'error',
                    'message' => 'negativ stock',
                    'product_uuid' => $FinishTransaction->id,
                    'trigger_by' => Auth::id()
            ]);

            if($FinishTransaction->net_price == null)
                SystemAlert::create([
                    'level' => 'error',
                    'message' => 'null net price',
                    'product_uuid' => $FinishTransaction->id,
                    'trigger_by' => Auth::id()
            ]);
        }

        InventoryAdjustment::where('id', $inventoryAdjustment->id)->update([
            'status' => 'COMPLETED',
            'approves' => Auth::id(),
        ]);

        return redirect()->back()->with("success", "Successful save!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InventoryAdjustment $inventoryAdjustment)
    {
        //
    }
}
