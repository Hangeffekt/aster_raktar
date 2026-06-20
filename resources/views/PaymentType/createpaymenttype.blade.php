@extends('index')

@section("content")

<form action="{{ route('paymenttypes.store') }}" method="post" class="col-xl-3 col-md-6 col-sm-12">
@csrf
    <div class="form-group">
        <label for="">Name</label>
        <input type="text" name="payment_type" value="{{ old('payment_type') }}" class="form-control">
        @error('payment_type')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <input type="submit" value="Save" class="btn btn-success">
    </div>
</form>

@endsection