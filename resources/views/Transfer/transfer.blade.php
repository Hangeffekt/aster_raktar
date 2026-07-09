@extends('index')

@section("content")

@include("components.sideMenu")
<div class="col-9">
    <h4>Transfers</h4>
    @can('create transfer')
        <a href="/transfer/create" class="btn btn-warning">New transfer</a>
    @endcan
    @include("components.filters")
    @if(count($Transfers) != 0)
        <div class="col-12">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Suplier</th>
                        <th>Total value</th>
                        <th>Approved</th>
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
                        <td>{{ $Transfer->name }}</td>
                        <td>{{ $Transfer->status }}</td>
                        <td>{{ $Transfer->created_at }}</td>
                        <td>{{ $Transfer->updated_at }}</td>
                            @if($Transfer->status == 'PENDING')
                                <td>
                                    @can('edit transfer')
                                        <a class="btn btn-warning edit_item" type="button" href="{{ route('transfer.edit', $Transfer->uuid) }}">Edit transfer</a>
                                    @endcan
                                    @can('delete transfer')
                                        <form action="{{ route('transfer.destroy', $Transfer->uuid)}}" method="post">
                                            @csrf
                                            @method ('DELETE')
                                            <button class="btn btn-danger" type="submit">Delete</button>
                                        </form>
                                    @endcan
                                </td>    
                            @elseif($Transfer->status == 'COMPLETED')
                                <td><a class="btn btn-info edit_item" type="button" href="{{ route('transfer.edit', $Transfer->uuid) }}">Info</a></td>
                                <td>
                                    @can('create storno_transfer')
                                        <a class="btn btn-danger edit_item" type="button" href="{{ route('transferstorno.edit', $Transfer->uuid) }}">Storno</a>
                                    @endcan
                                </td>
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