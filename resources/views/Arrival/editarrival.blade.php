@extends('index')

@section("content")

@include("components.sideMenu")

<div class="col-9">
    <div class="container">
        <div class="col-12">
            @if($editArrival->arrival_status == 'PENDING')
                @can('create edit_arrival')
                    @include("components.productSearch")
                @endcan
            @endif
            <div class="col-12">
                @if(count($Arrivalitems) != 0)
                <div class="col-12">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Product name</th>
                                <th>Net price</th>
                                <th>Sale price</th>
                                <th>qty</th>
                                <th></th><th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($Arrivalitems as $Arrivalitem)
                                <tr>
                                    <td>{!! $Arrivalitem->product->full_name !!}</td>
                                    <td>{{ $Arrivalitem->net_price }}</td>
                                    <td>{{ $Arrivalitem->sale_price }}</td>
                                    <td>{{ $Arrivalitem->qty }}</td>
                                    @if($editArrival->arrival_status == "PENDING")
                                    <td>
                                        @can('edit edit_arrival')
                                            <button class="btn btn-warning edit_item" type="button" data-bs-toggle="collapse" data-bs-target="#editProduct{{ $Arrivalitem->uuid }}" aria-expanded="false" aria-controls="collapseExample">Edit item</button>
                                        @endcan
                                    </td>
                                    <td>
                                        @can('delete edit_arrival')
                                        <form action="{{ route('arrivalitem.destroy', $Arrivalitem->arrival_item_id)}}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger" type="submit">Delete</button>
                                        </form>
                                        @endcan
                                    </td>
                                    @else
                                        <td colspan="2"></td>
                                    @endif
                                </tr>
                                @can('edit edit_arrival')
                                    <tr class="collapse" id="editProduct{{ $Arrivalitem->uuid }}">
                                        <td colspan="6">
                                            <form action="{{ route('arrivalitem.update', $Arrivalitem->arrival_item_id) }}" method="post">
                                                @csrf
                                                @method('PATCH')
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
                                @endcan
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