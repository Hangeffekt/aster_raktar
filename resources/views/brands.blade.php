@extends('index')

@section("content")

@include("components.sideMenu")
<div class="col-9">
    <div class="col-12">
        <h4>Brands</h4><a href="/brands/create" class="btn btn-warning">New product</a>
    </div>

    @if(count($Brands) != 0)
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
                    @foreach($Brands as $Brand)
                    <tr class="table-dark">
                        <td>{{ $Brand->brand_id }} {{ $Brand->brand_name }}</td>
                        <td><a href="{{ route('brands.edit', $Brand->brand_id)}}" class="btn btn-warning">Edit</a></td>
                        <td>
                            <form action="{{ route('brands.destroy', $Brand->brand_id)}}" method="post">
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