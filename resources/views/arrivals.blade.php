@extends('index')

@section("content")

@include("components.sideMenu")
<div class="col-9">
    <div class="col-12">
        <h4>Arrivals</h4><a href="/arrivals/create" class="btn btn-warning">New arrival</a>
    </div>

    @if(count($Arrivals) != 0)
        <div class="col-12">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Suplier name</th>
                        <th>Total net value</th>
                        <th>Created at</th>
                        <th>Updated at</th>
                        <th></th><th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($Arrivals as $Arrival)
                    <tr>
                        <td>{{ $Arrival->suplier_name }}</td>
                        <td>net value</td>
                        <td>{{ $Arrival->created_at }}</td>
                        <td>{{ $Arrival->updated_at }}</td>
                        <td>
                            @if($Arrival->arrival_status == "COMPLETED")
                                <a href="{{ route('arrivals.edit', $Arrival->uuid)}}" class="btn btn-info">Info</a>
                            @else
                                <a href="{{ route('arrivals.edit', $Arrival->uuid)}}" class="btn btn-warning">Edit</a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $Arrivals->onEachSide(4)->links() }}
    @else
        <div class="col-12 alert alert-info">There are no arrivals!</div>
    @endif
</div>
    
            
@endsection