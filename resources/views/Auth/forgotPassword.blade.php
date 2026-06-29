@extends('index')

@section("content")

<form action="/forgot-password" method="post" class="mx-auto col-3">
    @csrf
    <h4>Forgot password</h4>
    <div class="mt-3 form-group">
        <label for="">Email</label>
        <input type="text" name="email" value="{{ old('email') }}" class="form-control">
        @error('email')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <input type="submit" value="Send" class="mt-3 btn btn-success">
</form>
@endsection