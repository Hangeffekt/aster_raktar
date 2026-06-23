<?php

namespace App\Http\Controllers;

use App\Models\Arrival;
use App\Models\Suplier;
use App\Models\ArrivalItem;
use App\Models\Brand;
use App\Models\Catalog;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ArrivalController extends Controller
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
        $days7 = Carbon::now()->addDays(7)->format('Y-m-d');
        $notCloseds = Arrival::where("arrival_status",  "PENDING")->get();
        $productArrivals = Arrival::where("arrival_date", "<=", $days7)->where('arrival_status', 'PENDING')->get();
        $productPayments = Arrival::where("payment_date", "<=", $days7)->where("arrival_status",  "COMPLETED")->get();
        $Arrivals = DB::table('arrivals as a')
                    ->join('supliers as s', 's.suplier_id', '=', 'a.suplier_id')
                    ->selectRaw('s.suplier_name, a.arrival_status, a.uuid, a.created_at, a.updated_at')
                    ->whereBetween("a.created_at", [$dFrom, $dTo])
                    ->paginate(20);

        return view('Arrival/arrivals', compact('Arrivals','notCloseds', 'productArrivals', 'productPayments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("createarrival", [
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
            'suplier_id' => 'required',
            'arrival_date' => 'date|required',
            'payment_date' => 'date',
            'suplier_note_number' => '',
            'invoice_number' => ''
        ]);
        
        Arrival::create($validated);

        return redirect("/arrivals")->with("success", "Sikeres felvétel!");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Arrival  $arrival
     * @return \Illuminate\Http\Response
     */
    public function show(Arrival $arrival)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Arrival  $arrival
     * @return \Illuminate\Http\Response
     */
    public function edit(Arrival $arrival)
    {
        $editArrival = Arrival::findOrFail($arrival->arrival_id) ?? [];
        if(!empty($editArrival) && $editArrival->arrival_status == "PENDING")
            $Arrivalitems = ArrivalItem::where('arrival_table_id', $arrival->uuid)->with(['product'])->paginate(50);
        else if(!empty($editArrival))
            $Arrivalitems = Transaction::where(['inner_table_id' => $arrival->uuid, "type" => "IN"])->with(['product'])->paginate(50);
        $Brands = Brand::get();
        $Catalogs = Catalog::get();

        return view('editarrival', compact('editArrival','Arrivalitems', 'Brands', 'Catalogs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Arrival  $arrival
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Arrival $arrival)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Arrival  $arrival
     * @return \Illuminate\Http\Response
     */
    public function destroy(Arrival $arrival)
    {
        $deleteArrivalItem = ArrivalItem::where('arrival_table_id', $arrival->arrival_id)->delete();
        $deleteArrival = Arrival::findOrFail($arrival->arrival_id);
        $deleteArrival->delete();
        
        return redirect("/arrivals")->with("success", "Sikeres törlés!");
    }

    public function closeArrival(Request $request)
    {
        $validated = $request->validate([
            'closeNote' => 'required'
        ]);

        $sumOfNetPrice = 0;

        //close items
        $closeArrivalItems = ArrivalItem::where('arrival_table_id', $request->arrival_id)->get();
        foreach($closeArrivalItems as $closeArrivalItem){
        
        $sumOfNetPrice += $closeArrivalItem->qty * $closeArrivalItem->net_price;

        Transaction::create(['product_id' => $closeArrivalItem->item_id,
            'type' => 'IN',
            'inner_table_id' => $request->arrival_id,
            'qty' => $closeArrivalItem->qty,
            'status' => 'COMPLETED',
            'net_price' => $closeArrivalItem->net_price,
            'sale_price' => $closeArrivalItem->sale_price,]);
        }

        //close note
        ArrivalItem::where("arrival_table_id", $request->arrival_id)->delete();
        Arrival::where("uuid", $request->arrival_id)->update(["arrival_status"=>"COMPLETED", 'total_net_value' => $sumOfNetPrice]);
        
        return redirect("/arrivals")->with("success", "Succesfull close!");
    }
}
