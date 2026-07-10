@extends('index')

@section("content")

@include("components.sideMenu")
<div class="col-9">
    <h4>Arrival storno</h4>
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
                    @foreach($Transactions as $arrival)
                    <tr>
                        <td>{!! $arrival->product->full_name !!}</td>
                        <td>{{ $arrival->net_price }}</td>
                        <td>
                            <input type="text" name="net_price_{{ $arrival->uuid }}" class="form-control" value="{{ $arrival->net_price }}">
                            @error('net_price_{{ $arrival->uuid }}')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </td>
                        <td>{{ abs($arrival->qty) }}</td>
                        <td><input type="text" name="qty_{{ $arrival->uuid }}" class="form-control" value="{{ abs($arrival->qty) }}">
                            @error('qty_{{ $arrival->uuid }}')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </td>
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