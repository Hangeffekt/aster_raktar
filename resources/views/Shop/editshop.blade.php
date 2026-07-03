@extends('index')

@section("content")

<form action="{{ route('shops.update', $editShop->uuid) }}" class="col-3" method="post">
    @csrf
    @method('PATCH')
    <h4>Edit shop</h4>
    <div class="form-group">
        <label for="">Name</label>
        <input type="text" name="shop_name" value="@if(old('shop_name')){{old('shop_name')}}@else{{ $editShop->shop_name }}@endif" class="form-control">
        @error('shop_name')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="">Zip code</label>
        <input type="text" name="shop_zip_code" class="form-control" value="@if(old('shop_zip_code')){{old('shop_zip_code')}}@else{{ $editShop->shop_zip_code }}@endif">
        @error('shop_zip_code')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="">Town</label>
        <input type="text" name="shop_settlement" class="form-control" value="@if(old('shop_settlement')){{old('shop_settlement')}}@else{{ $editShop->shop_settlement }}@endif">
        @error('shop_settlement')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="">Address</label>
        <input type="text" name="shop_address" value="@if(old('shop_address')){{old('shop_address')}}@else{{ $editShop->shop_address }}@endif" class="form-control">
        @error('shop_address')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="">Tax number</label>
        <input type="text" name="shop_tax_number" class="form-control" value="@if(old('shop_tax_number')){{old('shop_tax_number')}}@else{{ $editShop->shop_tax_number }}@endif">
        @error('shop_tax_number')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="">Phone</label>
        <input type="text" name="shop_phone" value="@if(old('shop_phone')){{old('shop_phone')}}@else{{ $editShop->shop_phone }}@endif" class="form-control">
        @error('shop_phone')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="">Email</label>
        <input type="text" name="shop_email" value="@if(old('shop_email')){{old('shop_email')}}@else{{ $editShop->shop_email }}@endif" class="form-control">
        @error('shop_email')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <input type="submit" value="Save" class="btn btn-success">
</form>

@endsection