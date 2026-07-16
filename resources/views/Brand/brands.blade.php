@extends('index')

@section("content")

@include("components.sideMenu")
<div class="col-9">
    <div class="col-12">
        <h4>Brands</h4>
        @can('create brand')<a href="/brands/create" class="btn btn-warning">New brand</a>@endcan
    </div>


    <x-table 
        :headers="['Name']" 
        :keys="['brand_name']" 
        :items="$Brands"
    >
        <x-slot:actions>
            <a href="" class="btn btn-warning">Edit</a>
        </x-slot>
    </x-table>

</div>
            
@endsection