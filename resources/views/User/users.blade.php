@extends('index')

@section("content")

@include("components.sideMenu")
<div class="col-9">
    <div class="col-12">
        <h4>Users</h4>
        @can('create user')<a href="/users/create" class="btn btn-warning">New user</a>@endcan
    </div>

    @if(count($Users) != 0)
        <div class="col-12">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Updated at</th>
                        <th>Created at</th>
                        @can('edit user')<th></th>@endcan
                    </tr>
                </thead>
                <tbody>
                    @foreach($Users as $User)
                    <tr>
                        <td>{{ $User->name }}</td>
                        <td>{{ $User->email }}</td>
                        <td>{{ $User->updated_at ? $User->updated_at : '-' }}</td>
                        <td>{{ $User->created_at }}</td>
                        @can('edit user')<td><a href="{{ route('users.edit', $User->id)}}" class="btn btn-warning">Edit</a></td>@endcan
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="col-12 alert alert-info">There are no users!</div>
    @endif
</div>
            
@endsection