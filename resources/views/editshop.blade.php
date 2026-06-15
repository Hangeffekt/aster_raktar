@extends('index')

@section("content")

<form action="{{ route('shops.update', $editShop->shop_id) }}" method="post">
    @csrf
    @method('PATCH')
    <div class="form-group">
        <label for="">Név</label>
        <input type="text" name="shop_name" value="@if(old('shop_name')){{old('shop_name')}}@else{{ $editShop->shop_name }}@endif" class="form-control">
        @error('shop_name')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="">Cím</label>
        <input type="text" name="shop_address" value="@if(old('shop_address')){{old('shop_address')}}@else{{ $editShop->shop_address }}@endif" class="form-control">
        @error('shop_address')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="">Telefon</label>
        <input type="text" name="shop_phone" value="@if(old('shop_phone')){{old('shop_phone')}}@else{{ $editShop->shop_phone }}@endif" class="form-control">
        @error('shop_phone')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="">E-mail</label>
        <input type="text" name="shop_email" value="@if(old('shop_email')){{old('shop_email')}}@else{{ $editShop->shop_email }}@endif" class="form-control">
        @error('shop_email')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <input type="submit" value="Mentés" class="btn btn-success">
</form>

@endsection