@extends('index')

@section("content")

@include("components.sideMenu")
<div class="col-9">
    <div class="col-12">
        <h4>Roles</h4><a href="/roles/create" class="btn btn-warning">New role</a>
    </div>

    @if(count($Roles) != 0)
        <div class="col-12">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>updated at</th>
                        <th>created at</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($Roles as $Role)
                    <tr>
                        <td>{{ $Role->name }}</td>
                        <td>{{ $Role->updated_at }}</td>
                        <td>{{ $Role->created_at }}</td>
                        <td><a href="{{ route('roles.edit', $Role->id)}}" class="btn btn-warning">Edit</a></td>
                        <td>
                            <form action="{{ route('roles.destroy', $Role->id)}}" method="post">
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