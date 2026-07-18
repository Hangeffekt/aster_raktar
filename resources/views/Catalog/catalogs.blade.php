@extends('index')

@section("content")
    <x-actionline
        :page="['catalogs','catalog']"
        :filter="['off']"
    >
    </x-actionline>
    <x-table 
        :headers="['Name']" 
        :keys="['catalog_name']" 
        :items="$Catalogs"
        :page="['catalogs','catalog']"
        :actionTypes="['create','edit','delete']"
    >
        <x-slot:actions></x-slot>
    </x-table>
            
@endsection