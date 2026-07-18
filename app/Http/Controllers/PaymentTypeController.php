<?php

namespace App\Http\Controllers;

use App\Models\PaymentType;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Spatie\Permission\Middleware\PermissionMiddleware;

class PaymentTypeController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(PermissionMiddleware::using('show main_datas_payment_types'), only: ['index','show']),
            new Middleware(PermissionMiddleware::using('show main_datas_payment_types'), except: ['create','store','edit','update','destroy']),
            new Middleware(PermissionMiddleware::using('create payment_type'), only: ['create','store']),
            new Middleware(PermissionMiddleware::using('create payment_type'), except: ['index','show','edit','update','destroy']),
            new Middleware(PermissionMiddleware::using('edit payment_type'), only: ['edit','update']),
            new Middleware(PermissionMiddleware::using('edit payment_type'), except: ['index','show','create','store','destroy']),
            new Middleware(PermissionMiddleware::using('delete payment_type'), only: ['destroy']),
            new Middleware(PermissionMiddleware::using('delete payment_type'), except: ['index','create','store','edit','update']),
        ];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('PaymentType/paymenttypes', [
            'PaymentTypes' => PaymentType::paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('PaymentType/createpaymenttype');
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
            'payment_type' => 'required|string|max:255|unique:payment_types'
        ]);
        PaymentType::create($validated);

        return redirect("paymenttypes")->with("success", "Succesfull create!");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PaymentType  $paymentType
     * @return \Illuminate\Http\Response
     */
    public function show(PaymentType $paymentType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PaymentType  $paymenttype
     * @return \Illuminate\Http\Response
     */
    public function edit(PaymentType $paymenttype)
    {
        $editPaymentTypes = PaymentType::findOrFail($paymenttype->payment_id);

        return view('PaymentType/editpaymenttype', compact('editPaymentTypes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PaymentType  $paymenttype
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PaymentType $paymenttype)
    {
        $validated = $request->validate([
            'payment_type' => 'required|string|max:255|unique:payment_types'
        ]);

        PaymentType::where('payment_id', $paymenttype->payment_id)->update($validated);
        
        return redirect("paymenttypes")->with("success", "Succesfull update!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PaymentType  $paymenttype
     * @return \Illuminate\Http\Response
     */
    public function destroy(PaymentType $paymenttype)
    {
        $deleteCatalog = PaymentType::findOrFail($paymenttype->payment_id);
        $deleteCatalog->delete();
        
        return redirect("paymenttypes")->with("success", "Succesfull delete!");
    }
}
