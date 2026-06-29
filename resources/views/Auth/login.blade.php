@extends('index')

@section("content")

<form action="/login" method="post" class="mx-auto col-3">
    @csrf
    <h4>Login</h4>
    <div class="mt-3 form-group">
        <label for="">Email</label>
        <input type="text" name="email" value="{{ old('email') }}" class="form-control">
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
    <input type="submit" value="Login" class="mt-3 btn btn-success"><br>
    <a href="/forgot-password" class="mt-3 btn btn-warning">Forgot password</a>
</form>

@endsection