@extends('index')

@section("content")

<form action="{{ route('arrivals.store') }}" method="post" class="col-xl-3 col-md-6 col-sm-12">
@csrf
    <h4>Create arrival</h4>
    <div class="form-group">
        <label for="">Suplier name</label>
        <select name="suplier_uuid" id="" class="form-select">
            <option>-- Kérjük válasszon --</option>
            @foreach($Supliers as $Suplier)
                <option value="{{ $Suplier->uuid }}"
                @if(old('suplier_uuid') && old('suplier_uuid') == $Suplier->uuid)
                    selected
                @endif
                >{{ $Suplier->suplier_name }}</option>
            @endforeach
        </select>
        @error('suplier_uuid')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="">Arrival date</label>
        <input type="date" name="arrival_date" value="{{ old('arrival_date') }}" class="form-control">
        @error('arrival_date')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="">Payment date</label>
        <input type="date" name="payment_date" value="{{ old('payment_date') }}" class="form-control">
        @error('payment_date')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="">Suplier note number</label>
        <input type="text" name="suplier_note_number" value="{{ old('suplier_note_number') }}" class="form-control">
        @error('suplier_note_number')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="">Invoice number</label>
        <input type="text" name="invoice_number" value="{{ old('invoice_number') }}" class="form-control">
        @error('invoice_number')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <input type="submit" value="Save" class="btn btn-success">
    </div>
</form>

@endsection