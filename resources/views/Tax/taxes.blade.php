@extends('index')

@section("content")

@include("components.sideMenu")
<div class="col-9">
    <div class="col-12">
        <h4>Taxes</h4>
        @can('create tax')<a href="/taxes/create" class="btn btn-warning">New tax</a>@endcan
    </div>

    @if(count($Taxes) != 0)
        <div class="col-12">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Value</th>
                        @can('edit tax')<th></th>@endcan
                        @can('delete tax')<th></th>@endcan
                    </tr>
                </thead>
                <tbody>
                    @foreach($Taxes as $Tax)
                    <tr>
                        <td>{{ $Tax->tax_value }}</td>
                        @can('edit tax')<td><a href="{{ route('taxes.edit', $Tax->uuid)}}" class="btn btn-warning">Edit</a></td>@endcan
                        @can('delete tax')
                            <td>
                                <form action="{{ route('taxes.destroy', $Tax->uuid)}}" method="post">
                                    @csrf
                                    @method ('DELETE')
                                    <button class="btn btn-danger" type="submit">Delete</button>
                                </form>
                            </td>
                        @endcan
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $Taxes->onEachSide(4)->links() }}
        </div>
    @else
        <div class="col-12 alert alert-info">There are no taxes!</div>
    @endif
</div>
@endsection