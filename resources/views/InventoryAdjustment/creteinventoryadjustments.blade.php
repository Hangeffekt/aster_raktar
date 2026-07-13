@extends('index')

@section("content")

<form action="{{ route('inventory-adjustments.store') }}" method="post" class="col-xl-3 col-md-6 col-sm-12">
@csrf
    <h4>Create arrival</h4>
    <div class="form-group">
        <label for="">Suplier name</label>
        <select name="suplier_uuid" id="" class="form-select">
            <option>-- Kérjük válasszon --</option>
            @foreach($AdjustmentTypes as $AdjustmentType)
                <option value="{{ $AdjustmentType->uuid }}"
                @if(old('adjustment_uuid') && old('adjustment_uuid') == $AdjustmentType->uuid)
                    selected
                @endif
                >{{ $AdjustmentType->adjustment_type }}</option>
            @endforeach
        </select>
        @error('adjustment_uuid')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <input type="submit" value="Save" class="btn btn-success">
    </div>
</form>

@endsection