@extends('index')

@section("content")

@include("components.sideMenu")
<div class="col-9">
    <div class="col-12">
        <h4>Inventory adjustments</h4>
        @can('create arrival')<a href="/inventory-adjustments/create" class="btn btn-warning">New adjustment</a>@endcan
        @include("components.filters")
    </div>

    @if(count($Adjustments) != 0)
        <div class="col-12">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Total net value</th>
                        <th>Approved</th>
                        <th>Status</th>
                        <th>Created at</th>
                        <th>Updated at</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($Adjustments as $Adjustment)
                    <tr>
                        <td>{{ arrivalNetValue($Adjustment->uuid, $Adjustment->status) }}</td>
                        <td>{{ $Adjustment->name }}</td>
                        <td>{{ $Adjustment->status }}</td>
                        <td>{{ $Adjustment->created_at }}</td>
                        <td>{{ $Adjustment->updated_at }}</td>
                        
                            @if($Adjustment->status == "PENDING")
                                <td>
                                    @can('edit arrival')
                                        <a href="{{ route('inventory-adjustments.edit', $Adjustment->uuid)}}" class="btn btn-warning">Edit</a>
                                    @endcan    
                                </td>
                                <td></td>
                            @else
                                <td><a class="btn btn-info edit_item" type="button" href="{{ route('arrivals.edit', $Adjustment->uuid) }}">Info</a></td>
                                <td></td>
                            @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $Adjustments->onEachSide(4)->links() }}
    @else
        <div class="col-12 alert alert-info">There are no adjustments!</div>
    @endif
</div>
    
            
@endsection