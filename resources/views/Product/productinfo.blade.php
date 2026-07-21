@extends('index')

@section("content")
<div class="col-3">
    <h5>Name</h5>
    {!! $Product->full_name !!}
</div>
<div class="col-3">
    <h5>Current stock</h5>
    {{ currentStock($Product->product_id) }}
</div>
<div class="col-3">
    <h5>Sale price</h5>
    {{ $Product->sale_price }}
</div>
<div class="col-3">
    <h5>Tax</h5>
    {{ $Product->tax_id }}
</div>
<div class="col-3">
    <h5>Ean</h5>
    {{ $Product->ean }}
</div>
@include("components.filters")
<div class="col-12">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Created at</th>
                <th>User</th>
                <th>Transaction type</th>
                <th>Transaction status</th>
                <th>Net price</th>
                <th>Sale price</th>
                <th>Qty</th>
                <th></th>
            </tr>
            
        </thead>
        <tbody>
            @foreach($History as $Transaction)
            <tr>
                <td>{{ $Transaction->created_at }}</td>
                <td>{{ $Transaction->customer_id }}</td>
                <td>{{ $Transaction->type }}</td>
                <td>{{ $Transaction->status }}</td>
                <td>{{ abs($Transaction->net_price) }}</td>
                <td>{{ abs($Transaction->sale_price) }}</td>
                <td>{{ $Transaction->qty }}</td>
                <td>
                    @if($Transaction->type == "IN")
                        <a href="/arrivals/{{ $Transaction->inner_table_id }}/edit" class="btn btn-info">Info</a></td>
                    @elseif($Transaction->type == "OUT")
                        <a href="/sales/{{ $Transaction->inner_table_id }}/edit" class="btn btn-info">Info</a></td>
                    @elseif($Transaction->type == "TRANSFER")
                        <a href="/transfer/{{ $Transaction->inner_table_id }}/edit" class="btn btn-info">Info</a></td>
                    @elseif($Transaction->type == "ADJUSTMENT")
                        <a href="/inventory-adjustments/{{ $Transaction->inner_table_id }}/edit" class="btn btn-info">Info</a></td>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $History->withQueryString()->onEachSide(4)->links() }}
</div>
<x-actionline
        :page="['products','product']"
        :filter="['on']"
        :Product="$Product"
    >
    </x-actionline>
    <x-table 
        :headers="['Created at','User','Transaction type','Transaction status','Net price','Sale price','Qty']" 
        :keys="['created_at','customer_id','type','status','net_price','sale_price','qty']" 
        :items="$History"
        :page="['products','product']"
        :actionTypes="['show']"
    >
        <x-slot:actions></x-slot>
    </x-table>
@endsection