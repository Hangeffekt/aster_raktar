@extends('index')

@section("content")

@include("components.sideMenu")
<div class="col-9">
    <div class="col-12">
        <h4>Moduls</h4><a href="/moduls/create" class="btn btn-warning">New modul</a>
    </div>

    @if(count($Moduls) != 0)
        <div class="col-12">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Zone name</th>
                        <th>Line</th>
                        <th>Modul numbers</th>
                        <th>Is active</th>
                        <th>Updated_at</th>
                        <th>Created_at</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($Moduls as $Modul)
                    <tr>
                        <td>{{ $Modul->name }}</td>
                        <td>{{ $Modul->line }}</td>
                        <td>{{ $Modul->modul_number }}</td>
                        <td>{{ $Modul->is_active == 1 ? 'Yes' : 'No' }}</td>
                        <td>{{ $Modul->updated_at }}</td>
                        <td>{{ $Modul->created_at }}</td>
                        <td><a href="{{ route('moduls.edit', $Modul->uuid)}}" class="btn btn-warning">Edit</a></td>
                        <td>
                            <form action="{{ route('moduls.destroy', $Modul->uuid)}}" method="post">
                                @csrf
                                @method ('DELETE')
                                <button class="btn btn-danger" type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="col-12 alert alert-info">There are no moduls!</div>
    @endif
</div>
            
@endsection