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
                        <th>Suplier</th>
                        <th>Total value</th>
                        <th>Status</th>
                        <th>Created at</th>
                        <th>Updated at</th>
                        <th></th><th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($Transfers as $Transfer)
                    <tr>
                        <td>{{ $Transfer->suplier_name }}</td>
                        <td>
                            @foreach($Groups as $group)
                                @if($group->inner_table_id == $Transfer->uuid)
                                    {{$group->total_sum * -1}}
                                @endif
                            @endforeach
                        </td>
                        <td>{{ $Transfer->status }}</td>
                        <td>{{ $Transfer->created_at }}</td>
                        <td>{{ $Transfer->updated_at }}</td>
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