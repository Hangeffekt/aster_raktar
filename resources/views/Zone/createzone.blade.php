@extends('index')

@section("content")
<h4>New zone</h4>
<form action="{{ route('zones.store') }}" method="post" class="col-3">
    @csrf
    <div class="form-group">
        <label for="">Name</label>
        <input type="text" name="name" value="{{ old('name') }}" class="form-control">
        @error('name')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-check mt-3 mb-3">
        <label for="">Is active</label>
        <input type="checkbox" name="is_active" value="{{ old('is_active') }}" class="form-check-input">
        @error('is_active')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <input type="submit" value="Save" class="btn btn-success">
</form>

@endsection