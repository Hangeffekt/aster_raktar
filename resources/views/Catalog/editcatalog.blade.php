@extends('index')

@section("content")

<form action="{{ route('catalogs.update', $editCatalog->uuid) }}" method="post">
    <h4>Edit catalog</h4>
    @csrf
    @method('PATCH')
    <div class="form-group">
        <label for="">Név</label>
        <input type="text" name="catalog_name" class="form-control" value="@if(old('catalog_name')){{old('catalog_name')}}@else{{ $editCatalog->catalog_name }}@endif">
        @error('catalog_name')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <input type="submit" value="Mentés" class="btn btn-success">
</form>

@endsection