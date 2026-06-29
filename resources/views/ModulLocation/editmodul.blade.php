@extends('index')

@section("content")
<h4>Edit modul</h4>
<form action="{{ route('moduls.update', $editModul->uuid) }}" method="post" class="col-3">
    @csrf
    @method('PATCH')
    <div class="form-group"><label>Tax</label>
        <select name="zone_id" id="" class="form-select">
            <option>-- Kérjük válasszon --</option>
            @foreach($Zones as $Zone)
                <option value="{{ $Zone->zone_id }}"
                @if(old('zone_id') && old('zone_id') == $Tax->zone_id || $editModul->zone_id == $Zone->zone_id)
                    selected
                @endif
                >{{ $Zone->name }}</option>
            @endforeach
        </select>
        @error('zone_id')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="">Line</label>
        <input type="text" name="line" value="@if(old('line')){{old('line')}}@else{{ $editModul->line }}@endif" class="form-control">
        @error('line')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="">Modul number</label>
        <input type="number" name="modul_number" value="@if(old('modul_number')){{old('modul_number')}}@else{{ $editModul->modul_number }}@endif" class="form-control">
        @error('modul_number')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-check mt-3 mb-3">
        <label for="">Is active</label>
        <input type="checkbox" name="is_active" class="form-check-input" checked="{{ (old('is_active') || $editModul->is_active == 1) ? 'checked' : '' }}">
        @error('is_active')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <input type="submit" value="Mentés" class="btn btn-success">
</form>

@endsection