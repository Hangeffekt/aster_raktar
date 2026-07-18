@extends('index')

@section("content")

@include("components.sideMenu")
    <x-actionline
        :page="['supliers','suplier']"
        :filter="['on']"
    >
    </x-actionline>
    <x-table 
        :headers="['Name','Created at','Updated at']" 
        :keys="['suplier_name','created_at','updated_at']" 
        :items="$Supliers"
        :page="['supliers','suplier']"
        :actionTypes="['create','edit','delete']"
    >
        <x-slot:actions></x-slot>
    </x-table>
            
@endsection