@extends('index')

@section("content")

    <x-actionline
        :page="['brands','brand']"
        :filter="['off']"
    >
    </x-actionline>
    <x-table 
        :headers="['Name']" 
        :keys="['brand_name']" 
        :items="$Brands"
        :page="['brands','brand']"
        :actionTypes="['create','edit','delete']"
    >
        <x-slot:actions></x-slot>
    </x-table>
@endsection