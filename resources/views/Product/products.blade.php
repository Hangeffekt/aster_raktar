@extends('index')

@section("content")

@include("components.sideMenu")
<div class="col-9">
    <div class="col-12">
        <h4>Products</h4><a href="/products/create" class="btn btn-warning">New product</a>
    </div>

    @if(count($Products) != 0)
        <div class="col-12">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Sale price</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($Products as $Product)
                    <tr>
                        <td>{!! $Product->full_name !!}</td>
                        <td>{{ $Product->sale_price }}</td>
                        <td><a href="{{ route('products.edit', $Product->uuid)}}" class="btn btn-warning">Edit</a></td>
                        <td><a href="{{ route('products.show', $Product->uuid)}}" class="btn btn-info">Info</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="col-12 alert alert-info">There are no products!</div>
    @endif
</div>
            
@endsection