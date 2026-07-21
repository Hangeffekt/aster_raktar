@extends('index')

@section("content")

<x-actionline
        :page="['products','product']"
        :filter="['on']"
        :Brands="$Brands"
        :Catalogs="$Catalogs"
        :Taxes="$Taxes"
    >
    </x-actionline>
    <x-table 
        :headers="['Name','Sale price','Created at','Updated at']" 
        :keys="['full_name','sale_price','created_at','updated_at']" 
        :items="$Products"
        :page="['products','product']"
        :actionTypes="['show','create','edit','delete']"
        
    >
        <x-slot:actions></x-slot>
    </x-table>
@endsection