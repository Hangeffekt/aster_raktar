@extends('index')

@section("content")

<form action="{{ route('roles.update', $editRole->id) }}" class="col-3">
    <h4>Edit role</h4>
    @csrf
    @method('PATCH')
    <div class="form-group">
        <label for="">Name</label>
        <input type="text" name="name" class="form-control" value="@if(old('name')){{old('name')}}@else{{ $editRole->name }}@endif">
        @error('name')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <input type="submit" value="Save" class="btn btn-success">
</form>

@endsection