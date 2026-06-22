@extends('index')

@section("content")

@include("components.sideMenu")
<div class="col-9">
    @if(count($Transactions) != 0)
        <div class="col-12">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Product name</th>
                        <th>Original value</th>
                        <th>Value</th>
                        <th>Original qty</th>
                        <th>Qty</th>
                        <th>Total value</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($Transactions as $Sale)
                    <tr>
                        <input type="hidden" name="product_id" value="{{ $Sale->id }}">
                        <td>{!! $Sale->product->full_name !!}</td>
                        <td>{{ $Sale->sale_price }}</td>
                        <td><input type="text" name="sale_price_{{ $Sale->id }}" class="form-control" value="0"></td>
                        <td>{{ $Sale->qty * -1 }}</td>
                        <td><input type="text" name="qty_{{ $Sale->id }}" class="form-control" value="0"></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </form>
        </div>
        {{ $Transactions->onEachSide(4)->links() }}
    @else
        <div class="col-12 alert alert-info">There are no transactions!</div>
    @endif
</div>
    
            
@endsection