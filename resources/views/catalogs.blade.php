@extends('index')

@section("content")

@include("components.sideMenu")
<div class="col-9">
    <div class="col-12">
        <h4>Catalogs</h4><a href="/catalogs/create" class="btn btn-warning">New category</a>
    </div>

    @if(count($Catalogs) != 0)
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
                    @foreach($Catalogs as $Catalog)
                    <tr class="table-dark">
                        <td>{{ $Catalog->catalog_name }}</td>
                        <td><a href="{{ route('catalogs.edit', $Catalog->catalog_id)}}" class="btn btn-warning">Edit</a></td>
                        <td>
                        <form action="{{ route('catalogs.destroy', $Catalog->catalog_id)}}" method="post">
                                @csrf
                                @method ('DELETE')
                                <button class="btn btn-danger" type="submit">Delete</button>
                            </form>
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