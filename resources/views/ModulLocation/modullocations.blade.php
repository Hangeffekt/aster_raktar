@extends('index')

@section("content")

@include("components.sideMenu")
<div class="col-9">
    <div class="col-12">
        <h4>Modul locations</h4><a href="/modullocations/create" class="btn btn-warning">New modul location</a>
    </div>

    @if(count($ModulLocations) != 0)
        <div class="col-12">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Zone name/Line/Modul number</th>
                        <th>Product</th>
                        <th>Order</th>
                        <th>Is active</th>
                        <th></th>
                    </tr>
                    <tr>
                        
                        <th>Qty</th>
                        <th>Faces</th>
                        <th>Updated at</th>
                        <th>Created at</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ModulLocations as $ModulLocation)
                    <tr>
                        <td>{{ $ModulLocation->name }}/{{ $ModulLocation->line }}/{{ $ModulLocation->modul_number }}</td>
                        <td>{{ $ModulLocation->order }}</td>
                        <td>{{ $ModulLocation->is_active == 1 ? 'Yes' : 'No' }}</td>
                        <td><a href="{{ route('modullocations.edit', $ModulLocation->uuid)}}" class="btn btn-warning">Edit</a></td>
                    </tr>
                    <tr>
                        <td>{{ $ModulLocation->qty }}</td>
                        <td>{{ $ModulLocation->faces }}</td>
                        <td>{{ $ModulLocation->updated_at }}</td>
                        <td>{{ $ModulLocation->created_at }}</td>
                        <td>
                            <form action="{{ route('modullocations.destroy', $ModulLocation->uuid)}}" method="post">
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
        <div class="col-12 alert alert-info">There are no moduls!</div>
    @endif
</div>
            
@endsection