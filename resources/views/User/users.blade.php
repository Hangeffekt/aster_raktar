@extends('index')

@section("content")
    <x-actionline
        :page="['users','user']"
        :filter="['on']"
    >
    </x-actionline>
    <x-table 
        :headers="['Name','Email','Created at','Updated at']" 
        :keys="['name','email','created_at','updated_at']" 
        :items="$Users"
        :page="['users','user']"
        :actionTypes="['edit']"
    >
        <x-slot:actions></x-slot>
    </x-table>
            
@endsection