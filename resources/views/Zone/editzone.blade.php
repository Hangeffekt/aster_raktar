@extends('index')

@section("content")
<h4>Edit zone</h4>
<form action="{{ route('zones.update', $editZone->uuid) }}" method="post" class="col-3">
    @csrf
    @method('PATCH')
    <div>
        <label for="">Name</label>
        <input type="text" name="name" class="form-control" value="@if(old('name')){{old('name')}}@else{{ $editZone->name }}@endif">
        @error('name')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-check mt-3 mb-3">
        <label for="">Is active</label>
        <input type="checkbox" name="is_active" value="{{ old('is_active') }}" class="form-check-input" {{ $editZone->is_active == 1 ? 'checked' : '' }}>
        @error('is_active')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <input type="submit" value="Mentés" class="btn btn-success">
</form>

@endsection