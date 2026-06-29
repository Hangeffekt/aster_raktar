@extends('index')

@section("content")

<form action="{{ route('users.store') }}" method="post" class="mx-auto col-3">
    @csrf
    <h4>Create user</h4>
    <div class="mt-3 form-group">
        <label for="">Username</label>
        <input type="text" name="name" value="{{old('name')}}" class="form-control">
        @error('name')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="mt-3 form-group">
        <label for="">Email</label>
        <input type="text" name="email" value="{{old('email')}}" class="form-control">
        @error('email')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="mt-3 form-group">
        <label for="">Password</label>
        <input type="password" name="password" value="" class="form-control">
        @error('password')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <input type="submit" value="Save" class="mt-3 btn btn-success">
</form>

@endsection