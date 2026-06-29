@extends('index')

@section("content")

@include("components.sideMenu")
<div class="col-9">
    <div class="col-12">
        <h4>Zones</h4>
        <a href="/zones/create" class="btn btn-warning">New zone</a>
    </div>
    @if(count($Zones) != 0)
        <div class="col-12">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Név</th>
                        <th>Is active</th>
                        <th>Updated_at</th>
                        <th>Created_at</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($Zones as $Zone)
                    <tr>
                        <td>{{ $Zone->name }}</td>
                        <td>{{ $Zone->is_active == 1 ? 'Yes' : 'No' }}</td>
                        <td>{{ $Zone->updated_at }}</td>
                        <td>{{ $Zone->creaed_at }}</td>
                        <td>{{ $Zone->name }}</td>
                        <td><a href="{{ route('zones.edit', $Zone->uuid)}}" class="btn btn-warning">Edit</a></td>
                        <td>
                            <form action="{{ route('zones.destroy', $Zone->uuid)}}" method="post">
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
        <div class="col-12 alert alert-info">There are no zones!</div>
    @endif
</div>
            
@endsection