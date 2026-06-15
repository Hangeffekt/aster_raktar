@extends('index')

@section("content")

<form action="{{ route('supliers.update', $editSuplier->uuid) }}" method="post">
    @csrf
    @method('PATCH')
    <div class="form-group">
        <label for="">Név</label>
        <input type="text" name="suplier_name" class="form-control" value="@if(old('suplier_name')){{old('suplier_name')}}@else{{ $editSuplier->suplier_name }}@endif">
        @error('suplier_name')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="">Irányítószám</label>
        <input type="text" name="suplier_zip_code" class="form-control" value="@if(old('suplier_zip_code')){{old('suplier_zip_code')}}@else{{ $editSuplier->suplier_zip_code }}@endif">
        @error('suplier_zip_code')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="">Település</label>
        <input type="text" name="suplier_settlement" class="form-control" value="@if(old('suplier_settlement')){{old('suplier_settlement')}}@else{{ $editSuplier->suplier_settlement }}@endif">
        @error('suplier_settlement')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="">Cím</label>
        <input type="text" name="suplier_address" class="form-control" value="@if(old('suplier_address')){{old('suplier_address')}}@else{{ $editSuplier->suplier_address }}@endif">
        @error('suplier_address')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="">Adószám</label>
        <input type="text" name="suplier_tax_number" class="form-control" value="@if(old('suplier_tax_number')){{old('suplier_tax_number')}}@else{{ $editSuplier->suplier_tax_number }}@endif">
        @error('suplier_tax_number')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="">telefonszám</label>
        <input type="text" name="suplier_phone" class="form-control" value="@if(old('suplier_phone')){{old('suplier_phone')}}@else{{ $editSuplier->suplier_phone }}@endif">
        @error('suplier_phone')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="">E-mail cím</label>
        <input type="text" name="suplier_email" class="form-control" value="@if(old('suplier_email')){{old('suplier_email')}}@else{{ $editSuplier->suplier_email }}@endif">
        @error('suplier_email')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <input type="submit" value="Mentés" class="btn btn-success">
</form>

@endsection