@extends('index')

@section("content")

@include("components.sideMenu")
<div class="col-9">
    <div class="col-12">
        <h4>Permissions</h4>
    </div>

    @if(count($Permissions) != 0)
        <div class="col-12">
            <table class="table table-hover permission-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        @foreach($Roles as $Role)
                            @if($Role->name == 'admin')
                                @hasrole('admin')
                                    <th>{{ $Role->name }}</th>
                                @endhasrole
                            @else
                                <th>{{ $Role->name }}</th>
                            @endif
                        @endforeach
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($Permissions as $Permission)
                    <tr>
                        <form action="{{ route('permissions.update', $Permission->id)}}" method="post">
                            <td>{{ $Permission->name }}</td>
                                @foreach($Roles as $Role)
                                     @if($Role->name == 'admin')
                                        @hasrole('admin')
                                            <td>
                                                <input type="checkbox" name="{{ $Role->name }}" {{ $Role->hasPermissionTo($Permission->name) ? 'checked' : '' }}>
                                            </td>
                                        @endhasrole
                                    @else
                                        <td>
                                            <input type="checkbox" name="{{ $Role->name }}" {{ $Role->hasPermissionTo($Permission->name) ? 'checked' : '' }}>
                                        </td>
                                    @endif
                                @endforeach
                            <td>
                                @csrf
                                @method ('PATCH')
                                <button class="btn btn-success" type="submit">Save</button>
                            </td>
                        </form>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="col-12 alert alert-info">There are no permissions!</div>
    @endif
</div>
            
@endsection