@extends('index')

@section("content")

@include("components.sideMenu")
<div class="col-9">
    <div class="col-12">
        <h4>Catalogs</h4>
        @can('create catalog')<a href="/catalogs/create" class="btn btn-warning">New catalog</a>@endcan
    </div>

    @if(count($Catalogs) != 0)
        <div class="col-12">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        @can('edit catalog')<th></th>@endcan
                        @can('delete catalog')<th></th>@endcan
                    </tr>
                </thead>
                <tbody>
                    @foreach($Catalogs as $Catalog)
                    <tr>
                        <td>{{ $Catalog->catalog_name }}</td>
                        @can('edit catalog')<td><a href="{{ route('catalogs.edit', $Catalog->uuid)}}" class="btn btn-warning">Edit</a></td>@endcan
                        @can('delete catalog')
                            <td>
                                <form action="{{ route('catalogs.destroy', $Catalog->uuid)}}" method="post">
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
        <div class="col-12 alert alert-info">There are no catalogs!</div>
    @endif
</div>
            
@endsection