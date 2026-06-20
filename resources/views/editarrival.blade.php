@extends('index')

@section("content")

@include("components.sideMenu")

<div class="col-9">
    <div class="container">
        <div class="col-12">
            @if($editArrival->arrival_status != 'closed')
                @include("components.productSearch")
            @endif
            <div class="col-12">
                @if(count($Arrivalitems) != 0)
                <div class="col-12">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <td>Product name</td>
                                <td>Net price</td>
                                <td>Sale price</td>
                                <td>qty</td>
                                <td></td><td></td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($Arrivalitems as $Arrivalitem)
                            <tr class="table-dark editItemValues">
                                <td>{!! $Arrivalitem->product->full_name !!}</td>
                                <td>{{ $Arrivalitem->net_price }}</td>
                                <td>{{ $Arrivalitem->sale_price }}</td>
                                <td>{{ $Arrivalitem->qty }}</td>
                                @if($editArrival->arrival_status == "PENDING")
                                <td><button class="btn btn-warning edit_item" type="button" data-bs-toggle="collapse" data-bs-target="#editProduct{{ $Arrivalitem->arrival_item_id }}" aria-expanded="false" aria-controls="collapseExample">Edit item</button></td>
                                <td>
                                    <form action="{{ route('arrivalItemDelete')}}" method="post">
                                        @csrf
                                        <input type="hidden" name="arrival_item_id" value="{{ $Arrivalitem->arrival_item_id }}">
                                        <button class="btn btn-danger" type="submit">Delete</button>
                                    </form>
                                </td>
                                @else
                                    <td colspan="2"></td>
                                @endif
                            </tr>
                            <tr class="collapse" id="editProduct{{ $Arrivalitem->arrival_item_id }}">
                                <td colspan="6">
                                    <form action="{{ route('arrivalItemEdit') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="arrival_item_id" value="{{ $Arrivalitem->arrival_item_id }}">
                                        <div class="row">
                                            <div class="col">
                                                <label for="">Net price</label>
                                                <input type="text" name="net_price" class="form-control" value="{{ $Arrivalitem->net_price }}">
                                            </div>
                                            <div class="col">
                                                <label for="">Sale price</label>
                                                <input type="text" name="sale_price" class="form-control" value="{{ $Arrivalitem->sale_price }}">
                                            </div>
                                            <div class="col">
                                                <label for="">Qty</label>
                                                <input type="text" name="qty" class="form-control" value="{{ $Arrivalitem->qty }}">
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
                {{ $Arrivalitems->onEachSide(4)->links() }}
                @else
                    <div class="col-12 alert alert-info">There are no items!</div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection