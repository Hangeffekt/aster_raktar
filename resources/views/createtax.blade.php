@extends('index')

@section("content")

<form action="{{ route('taxes.store') }}" method="post">
    @csrf
    <div class="form-group">
        <label for="">Érték</label>
        <input type="text" name="tax_value" value="{{ old('tax_value') }}" class="form-control">
        @error('tax_value')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <input type="submit" value="Mentés" class="btn btn-success">
</form>

@endsection