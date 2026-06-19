@extends('index')

@section("content")

@include("components.sideMenu")
<div class="col-9">
    <h4>Transfers</h4><a href="/transfer/create" class="btn btn-warning">New transfer</a>
    @if(count($Transfers) != 0)
        <div class="col-12">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <td>Suplier/Company</td>
                        <td>Total value</td>
                        <td>Status</td>
                        <td></td><td></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($Transfers as $Transfer)
                    <tr class="table-dark">
                        <td>{{ $Transfer->suplier_name }}</td>
                        <td>
                            @foreach($Groups as $group)
                                @if($group->inner_table_id == $Transfer->id)
                                    {{$group->total_sum * -1}}
                                @endif
                            @endforeach
                        </td>
                        <td>{{ $Transfer->status }}</td>
                            @if($Transfer->status == 'PENDING')
                                <td><a class="btn btn-warning edit_item" type="button" href="{{ route('transfer.edit', $Transfer->uuid) }}">Edit transfer</a></td>
                            @elseif($Transfer->status == 'COMPLETED')
                                <td><a class="btn btn-info edit_item" type="button" href="{{ route('transfer.edit', $Transfer->uuid) }}">Info</a></td>
                                <td><a class="btn btn-danger edit_item" type="button" href="{{ route('salestorno.edit', $Transfer->uuid) }}">Storno</a></td>
                            @else
                                <td><a class="btn btn-info edit_item" type="button" href="{{ route('transfer.edit', $Transfer->uuid) }}">Info</a></td>
                            @endif
                        
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $Transfers->onEachSide(4)->links() }}
    @else
        <div class="col-12 alert alert-info">There are no transfer!</div>
    @endif
</div>
    
            
@endsection