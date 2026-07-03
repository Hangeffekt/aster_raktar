@extends('index')

@section("content")

<form action="{{ route('users.update', $editUser->id) }}" method="post" class="mx-auto col-3">
    <h4>Edit user</h4>
    @csrf
    @method('PATCH')
    <h4>Edit user</h4>
    <div class="mt-3 form-group">
        <label for="">Username</label>
        <input type="text" name="name" value="@if(old('name')){{old('name')}}@else{{ $editUser->name }}@endif" class="form-control">
        @error('name')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="mt-3 form-group">
        <label for="">Email</label>
        <input type="text" name="email" value="@if(old('email')){{old('email')}}@else{{ $editUser->email }}@endif" class="form-control">
        @error('email')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="mt-3 form-group">
        <label for="">Role</label>
        <select name="role" id="" class="form-select">
            <option value="">-- Please choose --</option>
            @foreach($Roles as $Role)
                <option value="{{ $Role->name }}"
                @if(old('role') && old('role') == $Role->name || $editUser->hasRole($Role->name))
                    selected
                @endif
                >{{ $Role->name }}</option>
            @endforeach
        </select>
        @error('role')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <input type="submit" value="Save" class="mt-3 btn btn-success">
</form>

@endsection