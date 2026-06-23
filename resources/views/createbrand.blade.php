@extends('index')

@section("content")

<form action="{{ route('brands.store') }}" method="post">
    @csrf
    <div class="form-group">
        <label for="">Name</label>
        <input type="text" name="brand_name" value="{{ old('brand_name') }}" class="form-control">
        @error('brand_name')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <input type="submit" value="Mentés" class="btn btn-success">
</form>

@endsection