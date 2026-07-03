@extends('index')

@section("content")

@include("components.sideMenu")
<div class="col-9">
    <div class="col-12">
        <h4>Supliers</h4>
        @can('create suplier')<a href="/supliers/create" class="btn btn-warning">New suplier</a>@endcan
    </div>

    @if(count($Supliers) != 0)
        <div class="col-12">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        @can('edit suplier')<th></th>@endcan
                        @can('delete suplier')<th></th>@endcan
                    </tr>
                </thead>
                <tbody>
                    @foreach($Supliers as $Suplier)
                    <tr>
                        <td>{{ $Suplier->suplier_name }}</td>
                        @can('edit suplier')<td><a href="{{ route('supliers.edit', $Suplier->uuid)}}" class="btn btn-warning">Edit</a></td>@endcan
                        @can('delete suplier')
                            <td>
                                <form action="{{ route('supliers.destroy', $Suplier->uuid)}}" method="post">
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
        <div class="col-12 alert alert-info">There are no supliers!</div>
    @endif
</div>
            
@endsection