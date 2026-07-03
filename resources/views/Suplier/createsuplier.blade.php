@extends('index')

@section("content")

<form action="{{ route('supliers.store') }}" method="post" class="col-3">
    <h4>Create suplier</h4>
    @csrf
    <div class="form-group mb-3">
        <label for="">Company name</label>
        <input type="text" name="suplier_name" class="form-control"  value="{{ old('suplier_name') }}">
        @error('suplier_name')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group mb-3">
        <label for="">Zip code</label>
        <input type="text" name="suplier_zip_code" class="form-control"  value="{{ old('suplier_zip_code') }}">
        @error('suplier_zip_code')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group mb-3">
        <label for="">Town</label>
        <input type="text" name="suplier_settlement" class="form-control"  value="{{ old('suplier_settlement') }}">
        @error('suplier_settlement')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group mb-3">
        <label for="">Address</label>
        <input type="text" name="suplier_address" class="form-control"  value="{{ old('suplier_address') }}">
        @error('suplier_address')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group mb-3">
        <label for="">Tax number</label>
        <input type="text" name="suplier_tax_number" class="form-control"  value="{{ old('suplier_tax_number') }}">
        @error('suplier_tax_number')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group mb-3">
        <label for="">Phone</label>
        <input type="text" name="suplier_phone" class="form-control"  value="{{ old('suplier_phone') }}">
        @error('suplier_phone')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group mb-3">
        <label for="">Email</label>
        <input type="text" name="suplier_email" class="form-control"  value="{{ old('suplier_email') }}">
        @error('suplier_email')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-check mb-3">
        <label for="">Generate order</label>
        <input type="checkbox" name="generate_order" class="form-check-input"  value="{{ old('generate_order') }}">
        @error('generate_order')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <h5 class="mb-3">Which day generate order?</h5>
    <div class="form-check">
        <input type="checkbox" name="generate_monday" class="form-check-input"  value="">
        <label> Monday</label>
    </div>
    <div class="form-check">
        <input type="checkbox" name="generate_tuesday" class="form-check-input"  value="">
        <label> Tuesday</label>
    </div>
    <div class="form-check">
        <input type="checkbox" name="generate_wednesday" class="form-check-input"  value="">
        <label> Wednesday</label>
    </div>
    <div class="form-check">
        <input type="checkbox" name="generate_thursday" class="form-check-input"  value="">
        <label> Thursday</label>
    </div>
    <div class="form-check">
        <input type="checkbox" name="generate_friday" class="form-check-input"  value="">
        <label> Friday</label>
    </div>
    <h5 class="mb-3">Which week generate order?</h5>
    <div class="form-check">
        <input type="radio" name="generate_friday" class="form-check-input" name="week" value="every">
        <label>Every</label>
    </div>
    <div class="form-check">
        <input type="radio" name="generate_friday" class="form-check-input" name="week" value="second">
        <label>Second</label>
    </div>
    <div class="form-check">
        <input type="radio" name="generate_friday" class="form-check-input" name="week" value="third">
        <label>Third</label>
    </div>
    <div class="form-check">
        <input type="radio" name="generate_friday" class="form-check-input" name="week" value="thirdofthemonth">
        <label>Third of the month</label>
    </div>
    <div class="form-check">
        <input type="radio" name="generate_friday" class="form-check-input" name="week" value="fourth">
        <label>Fourth</label>
    </div>
    <div class="form-controll mt-3 mb-3">
        <label for="" class="form-label">Which date start</label>
        <input class="form-control" type="date" name="date-start">
    </div>
    <input type="submit" value="Mentés" class="btn btn-success">
</form>

@endsection