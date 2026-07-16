@extends('index')

@section("content")

@include("components.sideMenu")
<div class="col-9">
    <div class="col-12">
        <h4>Roles</h4>
        @can('create role')<a href="/roles/create" class="btn btn-warning">New role</a>@endcan
    </div>

    @if(count($Roles) != 0)
        <div class="col-12">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>updated at</th>
                        <th>created at</th>
                        @can('edit role')<th></th>@endcan
                        @can('delete role')<th></th>@endcan
                    </tr>
                </thead>
                <tbody>
                    @foreach($Roles as $Role)
                        @if($Role->name != 'admin')
                        <tr>
                            <td>{{ $Role->name }}</td>
                            <td>{{ $Role->updated_at }}</td>
                            <td>{{ $Role->created_at }}</td>
                            @can('edit role')<td><a href="{{ route('roles.edit', $Role->id)}}" class="btn btn-warning">Edit</a></td>@endcan
                            @can('delete role')
                                <td>
                                    <form action="{{ route('roles.destroy', $Role->id)}}" method="post">
                                        @csrf
                                        @method ('DELETE')
                                        <button class="btn btn-danger" type="submit">Delete</button>
                                    </form>
                                </td>
                            @endcan
                        </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="col-12 alert alert-info">There are no roles!</div>
    @endif
</div>
            
@endsection