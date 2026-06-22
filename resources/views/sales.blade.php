@extends('index')

@section("content")

@include("components.sideMenu")
<div class="col-9">
    <form action="{{ route('sales.store') }}" method="post">
        @csrf
        <button class="btn btn-success">New sale</button>
    </form>
    <form action="{{ route('sales.store') }}" method="post">
        @csrf
        <button class="btn btn-success">New order</button>
    </form>
    @if(count($Sales) != 0)
        <div class="col-12">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Total value</th>
                        <th>Payment type</th>
                        <th>Status</th>
                        <th>Created at</th>
                        <th>Updated at</th>
                        <th></th><th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($Sales as $Sale)
                    <tr>
                        <td>
                            @foreach($Groups as $group)
                                @if($group->inner_table_id == $Sale->uuid)
                                    {{$group->total_sum}}
                                @endif
                            @endforeach
                        </td>
                        <td>{{ $Sale->payment_type }}</td>
                        <td>{{ $Sale->sale_status }}</td>
                        <td>{{ $Sale->created_at }}</td>
                        <td>{{ $Sale->updated_at }}</td>
                            @if($Sale->sale_status == 'PENDING')
                                <td><a class="btn btn-warning edit_item" type="button" href="{{ route('sales.edit', $Sale->uuid) }}">Edit transaction</a></td>
                            @elseif($Sale->sale_status == 'COMPLETED')
                                <td><a class="btn btn-info edit_item" type="button" href="{{ route('sales.edit', $Sale->uuid) }}">Info</a></td>
                                <td><a class="btn btn-danger edit_item" type="button" href="{{ route('salestorno.edit', $Sale->uuid) }}">Storno</a></td>
                            @else
                                <td><a class="btn btn-info edit_item" type="button" href="{{ route('sales.edit', $Sale->uuid) }}">Info</a></td>
                            @endif
                        
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $Sales->onEachSide(4)->links() }}
    @else
        <div class="col-12 alert alert-info">There are no sales!</div>
    @endif
</div>
    
            
@endsection