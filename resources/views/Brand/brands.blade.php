@extends('index')

@section("content")

@include("components.sideMenu")
<div class="col-9">
    <div class="col-12">
        <h4>Brands</h4>
        @can('create brand')<a href="/brands/create" class="btn btn-warning">New brand</a>@endcan
    </div>

    @if(count($Brands) != 0)
        <div class="col-12">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        @can('edit brand')<th></th>@endcan
                        @can('delete brand')<th></th>@endcan
                    </tr>
                </thead>
                <tbody>
                    @foreach($Brands as $Brand)
                    <tr>
                        <td>{{ $Brand->brand_name }}</td>
                        @can('edit brand')<td><a href="{{ route('brands.edit', $Brand->uuid)}}" class="btn btn-warning">Edit</a></td>@endcan
                        @can('delete brand')
                            <td>
                                <form action="{{ route('brands.destroy', $Brand->uuid)}}" method="post">
                                    @csrf
                                    @method ('DELETE')
                                    <button class="btn btn-danger" type="submit">Delete</button>
                                </form>
                            </td>
                        @endcan
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