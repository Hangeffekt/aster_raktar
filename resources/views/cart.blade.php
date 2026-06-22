@extends('index')

@section("content")

@include("components.sideMenu")

<div class="col-9">
    <div class="container">
        <div class="col-12">
            @include("components.productSearch")
            <div class="col-12">
            @if(count($cartItems) != 0)
        <div class="col-12">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Product name</th>
                        <th>Value</th>
                        <th>Qty</th>
                        <th>Total value</th>
                        <th></th><th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cartItems as $Sale)
                    <tr>
                        <td>{{ $Sale->sale_product_name }}</td>
                        <td>{{ $Sale->sale_product_value }}</td>
                        <td>{{ $Sale->sale_product_qty }}</td>
                        <td>
                            @php $total_value = $Sale->sale_product_value * $Sale->sale_product_qty @endphp
                            {{ $total_value }}
                        </td>
                        @if($Sale->finished == null)
                        <td><button class="btn btn-warning edit_item" type="button" data-bs-toggle="collapse" data-bs-target="#editProduct{{ $Sale->sale_item_id }}" aria-expanded="false" aria-controls="collapseExample">Edit item</button></td>
                        <td>
                            @if($Sale->total_net_value == null || $Sale->total_net_value == 0)
                            <form action="{{ route('cart.destroy', $Sale->sale_item_id)}}" method="post">
                                @csrf
                                @method ('DELETE')
                                <button class="btn btn-danger" type="submit">Delete</button>
                            </form>
                            @endif
                        </td>
                        @else
                            <td colspan="2"></td>
                        @endif
                    </tr>
                    <tr class="collapse" id="editProduct{{ $Sale->sale_item_id }}">
                        <td colspan="6">
                            <form action="{{ route('cart.update', $Sale->sale_item_id) }}" method="post">
                                @csrf
                                @method('PATCH')
                                <div class="row">
                                    <div class="col">
                                        <label for="">Sale price</label>
                                        <input type="text" name="sale_product_value" class="form-control" value="{{ $Sale->sale_product_value }}">
                                    </div>
                                    <div class="col">
                                        <label for="">Qty</label>
                                        <input type="text" name="sale_product_qty" class="form-control" value="{{ $Sale->sale_product_qty }}">
                                    </div>
                                    <input type="submit" value="Save" class="mt-3 btn btn-success">
                                </div>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $cartItems->onEachSide(4)->links() }}
    @else
        <div class="col-12 alert alert-info">There are no products in cart!</div>
    @endif
</div>

@endsection