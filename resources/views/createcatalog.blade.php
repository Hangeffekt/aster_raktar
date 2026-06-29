@extends('index')

@section("content")

<form action="{{ route('catalogs.store') }}" method="post">
@csrf
    <div class="form-group">
        <label for="">Név</label>
        <input type="text" name="catalog_name" value="{{ old('catalog_name') }}" class="form-control">
        @error('catalog_name')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <input type="submit" value="Save" class="btn btn-success">
    </div>
</form>

@endsection