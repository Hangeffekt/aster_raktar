@extends('index')

@section("content")

<form action="{{ route('supliers.store') }}" method="post">
    @csrf
    <div class="form-group">
        <label for="">Név</label>
        <input type="text" name="suplier_name" class="form-control"  value="{{ old('suplier_name') }}">
        @error('suplier_name')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="">Irányítószám</label>
        <input type="text" name="suplier_zip_code" class="form-control"  value="{{ old('suplier_zip_code') }}">
        @error('suplier_zip_code')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="">Település</label>
        <input type="text" name="suplier_settlement" class="form-control"  value="{{ old('suplier_settlement') }}">
        @error('suplier_settlement')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="">Cím</label>
        <input type="text" name="suplier_address" class="form-control"  value="{{ old('suplier_address') }}">
        @error('suplier_address')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="">Adószám</label>
        <input type="text" name="suplier_tax_number" class="form-control"  value="{{ old('suplier_tax_number') }}">
        @error('suplier_tax_number')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="">telefonszám</label>
        <input type="text" name="suplier_phone" class="form-control"  value="{{ old('suplier_phone') }}">
        @error('suplier_phone')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="">E-mail cím</label>
        <input type="text" name="suplier_email" class="form-control"  value="{{ old('suplier_email') }}">
        @error('suplier_email')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <input type="submit" value="Mentés" class="btn btn-success">
</form>

@endsection