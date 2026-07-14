<?php

namespace App\Http\Controllers;

use App\Models\Arrival;
use App\Models\Suplier;
use App\Models\ArrivalItem;
use App\Models\Brand;
use App\Models\Catalog;
use App\Models\Transaction;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Spatie\Permission\Middleware\PermissionMiddleware;
use App\Http\Requests\ArrivalPostRequest;

use Illuminate\Support\Facades\Auth;

class ArrivalController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(PermissionMiddleware::using('show arrivals'), only: ['index','show']),
            new Middleware(PermissionMiddleware::using('show arrivals'), except: ['create','store','edit','update','destroy']),
            new Middleware(PermissionMiddleware::using('create arrival'), only: ['create','store']),
            new Middleware(PermissionMiddleware::using('create arrival'), except: ['index','show','edit','update','destroy']),
            new Middleware(PermissionMiddleware::using('edit arrival'), only: ['edit','update']),
            new Middleware(PermissionMiddleware::using('edit arrival'), except: ['index','show','create','store','destroy']),
            new Middleware(PermissionMiddleware::using('delete arrival'), only: ['destroy']),
            new Middleware(PermissionMiddleware::using('delete arrival'), except: ['index','create','show','store','edit','update']),
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
        $days7 = Carbon::now()->addDays(7)->format('Y-m-d');
        $notCloseds = Arrival::where("arrival_status",  "PENDING")->get();
        $productArrivals = Arrival::where("arrival_date", "<=", $days7)->where('arrival_status', 'PENDING')->get();
        $productPayments = Arrival::where("payment_date", "<=", $days7)->where("arrival_status",  "COMPLETED")->get();
        $Arrivals = DB::table('arrivals as a')
                    ->join('supliers as s', 's.suplier_id', '=', 'a.suplier_id')
                    ->leftJoin('users as u', 'a.approves', '=', 'u.id')
                    ->selectRaw('u.name, s.suplier_name, a.arrival_id, a.arrival_status, a.uuid, a.created_at, a.updated_at')
                    ->whereBetween("a.created_at", [$dFrom, $dTo])
                    ->paginate(20);
        $Supliers = Suplier::get();

        return view('Arrival/arrivals', compact('Arrivals','notCloseds', 'productArrivals', 'productPayments', 'Supliers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("Arrival/createarrival", [
            'Supliers' => Suplier::get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArrivalPostRequest $request)
    {   
        Arrival::create($request->all());

        return redirect("/arrivals")->with("success", "Successfull created!");
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

        return view('Arrival/editarrival', compact('editArrival','Arrivalitems', 'Brands', 'Catalogs'));
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
        $validated = $request->validate([
            'closeNote' => 'required'
        ]);

        $sumOfNetPrice = 0;

        //close items
        $closeArrivalItems = ArrivalItem::where('arrival_table_id', $arrival->uuid)->get();
        foreach($closeArrivalItems as $closeArrivalItem){

            Transaction::create(['product_id' => $closeArrivalItem->item_id,
                'type' => 'IN',
                'inner_table_id' => $arrival->uuid,
                'qty' => $closeArrivalItem->qty,
                'status' => 'COMPLETED',
                'net_price' => $closeArrivalItem->net_price,
                'sale_price' => $closeArrivalItem->sale_price,]);

            Product::where('product_id', $closeArrivalItem->item_id)->update(['net_price' => $closeArrivalItem->net_price]);
        }

        //close note
        ArrivalItem::where("arrival_table_id", $arrival->uuid)->delete();
        Arrival::where("arrival_id", $arrival->arrival_id)->update(["arrival_status"=>"COMPLETED", "approves" => Auth::id()]);
        
        return redirect("/arrivals")->with("success", "Successfull close!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Arrival  $arrival
     * @return \Illuminate\Http\Response
     */
    public function destroy(Arrival $arrival)
    {
        if($arrival->arrival_status == 'PENDING'){
            ArrivalItem::where('arrival_table_id', $arrival->uuid)->delete();
            $deleteArrival = Arrival::findOrFail($arrival->arrival_id);
            $deleteArrival->delete();

        return redirect("/arrivals")->with("success", "Successfull deleted!");
        }
        else
            return redirect("/arrivals")->with("error", "You can't do that!");
    }
}
