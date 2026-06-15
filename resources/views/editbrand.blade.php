@extends('index')

@section("content")

<form action="{{ route('brands.update', $editBrand->brand_id) }}" method="post">
    @csrf
    @method('PATCH')
    <div class="form-control">
        <label for="">Név</label>
        <input type="text" name="brand_name" class="form-control" value="@if(old('brand_name')){{old('brand_name')}}@else{{ $editBrand->brand_name }}@endif">
        @error('brand_name')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <input type="submit" value="Mentés" class="btn btn-success">
</form>

@endsection