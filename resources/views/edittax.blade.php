@extends('index')

@section("content")

<form action="{{ route('taxes.update', $editTax->uuid) }}" method="post">
    @csrf
    @method('PATCH')
    <div class="form-control">
        <label for="">Érték</label>
        <input type="text" name="tax_value" value="@if(old('tax_value')){{old('tax_value')}}@else{{ $editTax->tax_value }}@endif">
        @error('tax_value')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <input type="submit" value="Mentés" class="btn btn-success">
</form>

@endsection