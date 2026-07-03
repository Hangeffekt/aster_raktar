@extends('index')

@section("content")

@include("components.sideMenu")
<div class="col-9">

    @if(count($Shops) != 0)
        <div class="col-12">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Név</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($Shops as $Shop)
                    <tr>
                        <td>{{ $Shop->shop_name }}</td>
                        <td><a href="{{ route('shops.edit', $Shop->uuid)}}" class="btn btn-warning">Edit</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <h4>Shops</h4><a href="/shops/create" class="btn btn-warning">New shop</a>
    @endif
</div>
            
@endsection