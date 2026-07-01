@extends('index')

@section("content")

<form action="{{ route('roles.store') }}" method="post" class="col-3">
    <h4>Create role</h4>
    @csrf
    <div class="form-group">
        <label for="">Name</label>
        <input type="text" name="name" value="{{ old('name') }}" class="form-control">
        @error('name')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <input type="submit" value="Save" class="btn btn-success">
</form>

@endsection