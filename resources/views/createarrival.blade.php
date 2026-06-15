@extends('index')

@section("content")

<form action="{{ route('arrivals.store') }}" method="post">
@csrf
    <div class="form-group">
        <label for="">Suplier name</label>
        <select name="suplier_id" id="" class="form-select">
            <option>-- Kérjük válasszon --</option>
            @foreach($Supliers as $Suplier)
                <option value="{{ $Suplier->suplier_name }}"
                @if(old('suplier_id') && old('suplier_id') == $Suplier->suplier_name)
                    selected
                @endif
                >{{ $Suplier->suplier_name }}</option>
            @endforeach
        </select>
        @error('suplier_id')
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
    <input type="submit" value="Mentés" class="btn btn-success">
    </div>
</form>

@endsection