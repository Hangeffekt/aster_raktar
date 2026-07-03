@extends('index')

@section("content")

@include("components.sideMenu")
<div class="col-9">
    <div class="col-12">
        <h4>Products</h4>
        @can('create product')<a href="/products/create" class="btn btn-warning">New product</a>@endcan
        @include("components.filters")
    </div>

    @if(count($Products) != 0)
        <div class="col-12">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Sale price</th>
                        @can('edit product')<th></th>@endcan
                        @can('delete product')<th></th>@endcan
                    </tr>
                </thead>
                <tbody>
                    @foreach($Products as $Product)
                    <tr>
                        <td>{!! $Product->full_name !!}</td>
                        <td>{{ $Product->sale_price }}</td>
                        @can('edit product')<td><a href="{{ route('products.edit', $Product->uuid)}}" class="btn btn-warning">Edit</a></td>@endcan
                        @can('show product_info')<td><a href="{{ route('products.show', $Product->uuid)}}" class="btn btn-info">Info</a></td>@endcan
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