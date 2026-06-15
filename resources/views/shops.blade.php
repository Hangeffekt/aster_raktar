@extends('index')

@section("content")

@include("components.sideMenu")
<div class="col-9">
    <div class="col-12">
        <h4>Shops</h4><a href="/shops/create" class="btn btn-warning">New shop</a>
    </div>

    @if(count($Shops) != 0)
        <div class="col-12">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <td>Név</td>
                        <td></td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($Shops as $Shop)
                    <tr class="table-dark">
                        <td>{{ $Shop->shop_name }}</td>
                        <td><a href="{{ route('shops.edit', $Shop->shop_id)}}" class="btn btn-warning">Edit</a></td>
                        <td>
                            <form action="{{ route('shops.destroy', $Shop->shop_id)}}" method="post">
                                @csrf
                                @method ('DELETE')
                                <button class="btn btn-danger" type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="col-12 alert alert-info">There are no brands!</div>
    @endif
</div>
            
@endsection