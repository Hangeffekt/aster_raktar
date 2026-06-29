@extends('index')

@section("content")

<form action="/reset-password" method="post" class="mx-auto col-3">
    @csrf
    <h4>Reset password</h4>
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
    <div class="mt-3 form-group">
        <label for="">Password confirmation</label>
        <input type="password" name="password_confirmation" value="" class="form-control">
        @error('password_confirmation')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <input type="hidden" name="token" value="{{ request()->route('token') }}">
    <input type="submit" value="Send" class="mt-3 btn btn-success">
</form>

@endsection