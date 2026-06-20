@extends('index')

@section("content")

<form action="{{ route('paymenttypes.update', $editPaymentTypes->uuid) }}" method="post" class="col-xl-3 col-md-6 col-sm-12">
    @csrf
    @method('PATCH')
    <div class="form-group">
        <label for="">Name</label>
        <input type="text" name="catalog_name" class="form-control" value="@if(old('payment_type')){{old('payment_type')}}@else{{ $editPaymentTypes->payment_type }}@endif">
        @error('payment_type')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <input type="submit" value="Save" class="btn btn-success">
</form>

@endsection