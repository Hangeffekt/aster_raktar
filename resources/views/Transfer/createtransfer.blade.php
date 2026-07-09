@extends('index')

@section("content")

<form action="{{ route('transfer.store') }}" method="post" class="col-xl-3 col-md-6 col-sm-12">
@csrf
    <div class="form-group">
        <label for="">Suplier name</label>
        <select name="suplier_id" id="" class="form-select">
            <option>-- Please choose --</option>
            @foreach($Supliers as $Suplier)
                <option value="{{ $Suplier->uuid }}"
                @if(old('suplier_id') && old('suplier_id') == $Suplier->uuid)
                    selected
                @endif
                >{{ $Suplier->suplier_name }}</option>
            @endforeach
        </select>
        @error('suplier_id')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <input type="submit" value="Save" class="btn btn-success">
    </div>
</form>

@endsection