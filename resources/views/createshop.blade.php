@extends('index')

@section("content")

<form action="{{ route('shops.store') }}" method="post">
@csrf
    <div class="form-group">
        <label for="">Name</label>
        <input type="text" name="shop_name" value="{{ old('shop_name') }}" class="form-control">
        @error('shop_name')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="">Address</label>
        <input type="text" name="shop_address" value="{{ old('shop_address') }}" class="form-control">
        @error('shop_address')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="">Phone</label>
        <input type="text" name="shop_phone" value="{{ old('shop_phone') }}" class="form-control">
        @error('shop_phone')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="">E-mail</label>
        <input type="text" name="shop_email" value="{{ old('shop_email') }}" class="form-control">
        @error('shop_email')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <input type="submit" value="Save" class="btn btn-success">
</form>

@endsection