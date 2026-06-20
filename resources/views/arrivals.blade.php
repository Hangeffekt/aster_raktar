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
                        <td>Suplier name</td>
                        <td>Total net value</td>
                        <td></td><td></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($Arrivals as $Arrival)
                    <tr class="table-dark">
                        <td>{{ $Arrival->suplier_name }}</td>
                        <td>net value</td>
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