@extends('index')

@section("content")

@include("components.sideMenu")
<div class="col-9">
    <div class="col-12">
        <h4>Supliers</h4><a href="/supliers/create" class="btn btn-warning">New suplier</a>
    </div>

    @if(count($Supliers) != 0)
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
                    @foreach($Supliers as $Suplier)
                    <tr class="table-dark">
                        <td>{{ $Suplier->suplier_name }}</td>
                        <td><a href="{{ route('supliers.edit', $Suplier->uuid)}}" class="btn btn-warning">Edit</a></td>
                        <td>
                            <form action="{{ route('supliers.destroy', $Suplier->uuid)}}" method="post">
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
        <div class="col-12 alert alert-info">There are no supliers!</div>
    @endif
</div>
            
@endsection