@extends('index')

@section("content")

@include("components.sideMenu")
<div class="col-9">
    <div class="col-12">
        <h4>Arrivals</h4>
        @can('create arrival')<a href="/arrivals/create" class="btn btn-warning">New arrival</a>@endcan
        @include("components.filters")
    </div>

    @if(count($Arrivals) != 0)
        <div class="col-12">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Suplier name</th>
                        <th>Total net value</th>
                        <th>Status</th>
                        <th>Created at</th>
                        <th>Updated at</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($Arrivals as $Arrival)
                    <tr>
                        <td>{{ $Arrival->suplier_name }}</td>
                        <td>{{ arrivalNetValue($Arrival->uuid, $Arrival->arrival_status) }}</td>
                        <td>{{ $Arrival->arrival_status }}</td>
                        <td>{{ $Arrival->created_at }}</td>
                        <td>{{ $Arrival->updated_at }}</td>
                            @if($Arrival->arrival_status == "PENDING")
                                <td>
                                    @can('edit arrival')
                                        <a href="{{ route('arrivals.edit', $Arrival->uuid)}}" class="btn btn-warning">Edit</a>
                                    @endcan    
                                </td>
                                <td></td>
                            @elseif($Arrival->arrival_status == 'COMPLETED')
                                <td><a class="btn btn-info edit_item" type="button" href="{{ route('arrivals.edit', $Arrival->uuid) }}">Info</a></td>
                                <td>
                                    @can('create storno_arrival')
                                        <a class="btn btn-danger edit_item" type="button" href="{{ route('arrivalstorno.edit', $Arrival->uuid) }}">Storno</a>
                                    @endcan
                                </td>
                            @else
                                <td><a class="btn btn-info edit_item" type="button" href="{{ route('arrivals.edit', $Arrival->uuid) }}">Info</a></td>
                                <td></td>
                            @endif
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