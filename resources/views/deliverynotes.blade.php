@extends('index')

@section("content")

<div class="col-9">
    <a href="/cart" class="btn btn-success">New delivery note</a>
    @if(count($DeliveryNotes) != 0)
    @else
        <div class="col-12 alert alert-info">There are no sales!</div>
    @endif
</div>
      
@endsection