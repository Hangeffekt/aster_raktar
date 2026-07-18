@extends('index')

@section("content")

@include("components.sideMenu")
    <x-actionline
        :page="['taxes','tax']"
        :filter="['off']"
    >
    </x-actionline>
    <x-table 
        :headers="['Value']" 
        :keys="['tax_value']" 
        :items="$Taxes"
        :page="['taxes','tax']"
        :actionTypes="['edit','delete']"
    >
        <x-slot:actions></x-slot>
    </x-table>
@endsection