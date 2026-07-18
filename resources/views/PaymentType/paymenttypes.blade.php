@extends('index')

@section("content")

@include("components.sideMenu")
    <x-actionline
        :page="['paymenttypes','paymenttype']"
        :filter="['off']"
    >
    </x-actionline>
    <x-table 
        :headers="['Name']" 
        :keys="['payment_type']" 
        :items="$PaymentTypes"
        :page="['paymenttypes','paymenttype']"
        :actionTypes="['create','edit','delete']"
    >
        <x-slot:actions></x-slot>
    </x-table>
            
@endsection