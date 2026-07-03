@extends('index')

@section("content")

<form action="{{ route('taxes.update', $editTax->uuid) }}" method="post" class="col-3">
    <h4>Edit tax</h4>
    @csrf
    @method('PATCH')
    <div class="form-group">
        <label for="">Érték</label>
        <input type="text" name="tax_value" value="@if(old('tax_value')){{old('tax_value')}}@else{{ $editTax->tax_value }}@endif" class="form-control">
        @error('tax_value')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <input type="submit" value="Mentés" class="btn btn-success">
</form>

@endsection