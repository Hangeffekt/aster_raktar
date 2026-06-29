@extends('index')

@section("content")

@include("components.sideMenu")
<div class="col-9">
    <div class="col-12">
        <h4>Payment types</h4>
        <a href="/paymenttypes/create" class="btn btn-warning">New payment type</a>
    </div>
    @if(count($PaymentTypes) != 0)
        <div class="col-12">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($PaymentTypes as $PaymentType)
                    <tr>
                        <td>{{ $PaymentType->payment_type }}</td>
                        <td><a href="{{ route('paymenttypes.edit', $PaymentType->uuid)}}" class="btn btn-warning">Edit</a></td>
                        <td>
                            <form action="{{ route('paymenttypes.destroy', $PaymentType->uuid)}}" method="post">
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
        <div class="col-12 alert alert-info">There are no payment type!</div>
    @endif
</div>
            
@endsection