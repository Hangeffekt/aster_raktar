<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ArrivalItem;
use App\Models\Arrival;
use App\Models\SaleStatus;


class ProductSearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $Products = Product::
        when($request->product_name != null, function($query) use ($request){
            return $query->where('product_name', 'LIKE', '%'.$request->product_name.'%');
        })
        ->when($request->brand_id != null, function($query) use ($request){
            return $query->where("brand_id", 'LIKE', '%'.$request->brand_id.'%');
        })
        ->when($request->catalog_id != null, function($query) use ($request){
            return $query->where("catalog_id", 'LIKE', '%'.$request->catalog_id.'%');
        })
        ->get();

        return response()->json(['Products' => $Products]);
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
        $Product = Product::where('ean', $request->ean)->first();
  
        return response()->json(['Product' => $Product]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'arrival_table_id' => 'required',
            'item_id' => 'required|numeric',
            'net_price' => 'required|numeric',
            'sale_price' => 'required|numeric',
            'qty' => 'required|numeric'
        ]);
        
        ArrivalItem::create($validated);
        
        return redirect()->back()->with("success", "Succesfull create!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
