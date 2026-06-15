@extends('index')

@section("content")

@include("components.sideMenu")
<div class="col-9">
    @if($Sale->sale_status != 'COMPLETED')
        @include("components.productSearch")
    @endif
    @if(count($Transactions) != 0)
        <div class="col-12">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <td>Product name</td>
                        <td>Value</td>
                        <td>Qty</td>
                        <td>Total value</td>
                        <td></td><td></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($Transactions as $Sale)
                    <tr class="table-dark">
                        <td>{!! $Sale->product->full_name !!}</td>
                        <td>{{ $Sale->sale_price }}</td>
                        <td>{{ $Sale->qty * -1 }}</td>
                        <td>
                            @php $total_value = $Sale->sale_price * $Sale->qty * -1 @endphp
                            {{ $total_value }}
                        </td>
                        @if($Sale->status == "PENDING")
                        <td><button class="btn btn-warning edit_item" type="button" data-bs-toggle="collapse" data-bs-target="#editProduct{{ $Sale->id }}" aria-expanded="false" aria-controls="collapseExample">Edit item</button></td>
                        <td>
                            @if($Sale->status != "COMPLETED" )
                            <form action="{{ route('cart.destroy', $Sale->id)}}" method="post">
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
                    <tr class="collapse" id="editProduct{{ $Sale->id }}">
                        <td colspan="6">
                            <form action="{{ route('cart.update', $Sale->id) }}" method="post">
                                @csrf
                                @method('PATCH')
                                <div class="row">
                                    <div class="col">
                                        <label for="">Sale price</label>
                                        <input type="text" name="sale_price" class="form-control" value="{{ $Sale->sale_price }}">
                                    </div>
                                    <div class="col">
                                        <label for="">Qty</label>
                                        <input type="text" name="qty" class="form-control" value="{{ $Sale->qty * -1 }}">
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
        {{ $Transactions->onEachSide(4)->links() }}
    @else
        <div class="col-12 alert alert-info">There are no transactions!</div>
    @endif
</div>
    
            
@endsection