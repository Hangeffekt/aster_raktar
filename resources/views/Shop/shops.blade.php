@extends('index')

@section("content")

@include("components.sideMenu")
<div class="col-9">
    <x-table 
        :headers="['Name']" 
        :keys="['shop_name']" 
        :items="$Shops"
        :page="['shops','shop']"
        :actionTypes="['create','edit']"
    >
        <x-slot:actions></x-slot>
    </x-table>
</div>
            
@endsection