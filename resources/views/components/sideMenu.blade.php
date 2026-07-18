<div class="col-3 bg-gradient rounded-4">
    @if (Request::is('arrivals/*/edit'))
        <div class="card-body">
            <div class="mb-3">
                <h4>Net value:</h4>
                <div>{{ arrivalNetValue($editArrival->uuid, $editArrival->arrival_status) }}</div>
            </div>
            @can('edit arrival')
                <form action="">
                    @csrf
                    <div class="mb-3">
                        <label for="">Add Invioce image</label>
                        <input class="form-control" type="file" id="formFile">
                    </div>
                    <input type="submit" value="Search" class="btn btn-success">
                </form>
                <form action="">
                    @csrf
                    <div class="mb-3">
                        <label for="">Add suplier note image</label>
                        <input class="form-control" type="file" id="formFile">
                    </div>
                    <input type="submit" value="Search" class="btn btn-success">
                </form>
                @if($editArrival->arrival_status == "PENDING")
                <form action="{{ route('arrivals.update', $editArrival->uuid) }}" method="post" class="mt-3">
                    <h4>Close arrival</h4>
                    @csrf
                    @method('PATCH')
                    <div class="mb-3">
                        <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" name="closeNote">
                        <label class="form-check-label" for="flexSwitchCheckDefault">Close the note</label>
                        @error('closeNote')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <input type="submit" value="Close" class="btn btn-success">
                </form>
            @endcan
            @endif
        </div>
    @elseif (Request::is('arrivals'))
        <div class="card-body">
            @include("components.calendar")
            <div class="mb-3">
                <h5>Not closed notes <span class="badge bg-primary">
                    @if(count($notCloseds) != 0)
                        {{ count($notCloseds) }}
                    @else
                        0
                    @endif
                </span></h5>
            </div>
            <div class="mb-3">
                <h5>Next 7 days arrivaing <span class="badge bg-primary">
                    @if(count($productArrivals) != 0)
                        {{ count($productArrivals) }}
                    @else
                        0
                    @endif
                </span></h5>
            </div>
            <div class="mb-3">
                <h5>Next 7 days payments <span class="badge bg-primary">
                    @if(count($productPayments) != 0)
                        {{ count($productPayments) }}
                    @else
                        0
                    @endif
                </span></h5>
            </div>
        </div>

    @elseif (Request::is('moduls', 'zones', 'lines'))
        <div class="list-group">
            <a class="list-group-item list-group-item-action @if(Request::is('moduls')) active @endif" href="/moduls">Moduls</a>
            <a class="list-group-item list-group-item-action @if(Request::is('zones')) active @endif" href="/zones">Zones</a>
            <a class="list-group-item list-group-item-action @if(Request::is('modul-locations')) active @endif" href="/modul-locations">Modul locations</a>
        </div>
            @elseif (Request::is('sales'))
        <div class="card-body mb-3">
            @include("components.calendar")
        </div>
        <div class="card-body  mb-3">
            <h5>Today</h5>
                {{$Today * -1}} Ft
            @foreach($Cashes as $Cash)
                @if($Cash->payment_type == 1)
                    <h5>Cash</h5>
                    {{ $Cash->total_calculated_sum * -1}}
                @elseif($Cash->payment_type == 2)
                    <h5>Card</h5>
                    {{ $Cash->total_calculated_sum * -1}}
                @elseif($Cash->payment_type == 3)
                    <h5>Transfer</h5>
                    {{ $Cash->total_calculated_sum * -1}}
                @elseif($Cash->payment_type == 4)
                    <h5>Online</h5>
                    {{ $Cash->total_calculated_sum * -1}}
                @endif
            @endforeach
        </div>
    @elseif (Request::is('sales/*/edit'))
        <div class="card-body mb-3 mt-3">
            <h5>Status</h5>
            {{ $Sale->sale_status ?? "" }}
        </div>
        <div class="card-body mb-3">
            <h5>Payment mode</h5>
            {{ $Sale->payment_type ?? "" }}
        </div>
        <div class="card-body mb-3">
            <h5>Cart value:</h5>
            <div>
                @if(count($Transactions) != 0)
                        @php
                            $net_value = 0;
                        @endphp
                    @foreach($Transactions as $cartItem)
                        @php
                            $net_value +=  $cartItem->sale_price * $cartItem->qty * -1;
                        @endphp
                    @endforeach
                    {{ $net_value }} Ft
                @else
                    0 Ft
                @endif
            </div>
        </div>
        <div class="card-body mb-3">
            <h5>Created at</h5>
            {{ $Sale->created_at ?? "" }}
        </div>
        <div class="card-body mb-3">
            <h5>Updated at</h5>
            {{ $Sale->updated_at ?? "" }}
        </div>
        <div class="card-body mb-3">
            @if($Sale->sale_status == 'PENDING')
                <form action="{{ route('sales.update', $Sale->uuid) }}" method="post">
                    @method('PATCH')
                    @csrf
                    <div class="mb-3">
                        <label for="sale_status">Payment type</label>
                        <select name="payment_type" class="form-select">
                        @foreach($SaleStatus as $status)
                            <option value="{{$status->uuid }}">{{$status->payment_type}}</option>
                        @endforeach
                        </select>
                        @error('payment_type')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" name="closeNote">
                        <label class="form-check-label" for="flexSwitchCheckDefault">Close the note</label>
                        @error('closeNote')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <input type="submit" value="Close" class="btn btn-success">
                </form>
            @endif
        </div>
    @elseif (Request::is('salestorno/*/edit'))
    <div class="mb-3">
        <h5>Storno</h5>
        <form action="{{ route('salestorno.update', $Sale->uuid) }}" method="post">
            @csrf
            @method("PATCH")
            <div class="mb-3">
                <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" name="closeNote">
                <label class="form-check-label" for="flexSwitchCheckDefault">Close the note</label>
                @error('closeNote')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <input type="submit" value="Close" class="btn btn-success">
    </div>
    @elseif (Request::is('arrivalstorno/*/edit'))
    <div class="mb-3">
        <h5>Storno</h5>
        <form action="{{ route('arrivalstorno.update', $Arrival->uuid) }}" method="post">
            @csrf
            @method("PATCH")
            <div class="mb-3">
                <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" name="closeNote">
                <label class="form-check-label" for="flexSwitchCheckDefault">Close arrival</label>
                @error('closeNote')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <input type="submit" value="Close" class="btn btn-success">
    </div>
    @elseif (Request::is('transferstorno/*/edit'))
    <div class="mb-3">
        <h5>Storno</h5>
        <form action="{{ route('transferstorno.update', $Transfer->uuid) }}" method="post">
            @csrf
            @method("PATCH")
            <div class="mb-3">
                <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" name="closeNote">
                <label class="form-check-label" for="flexSwitchCheckDefault">Close the note</label>
                @error('closeNote')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <input type="submit" value="Close" class="btn btn-success">
    </div>
    @elseif (Request::is('cart'))
        <div class="card-body">
            <div class="mb-3">
                <h4>Cart value:</h4>
                <div>
                @if(count($cartItems) != 0)
                        @php
                            $net_value = 0;
                        @endphp
                    @foreach($cartItems as $cartItem)
                        @php
                            $net_value +=  $cartItem->sale_product_value * $cartItem->sale_product_qty;
                        @endphp
                    @endforeach
                    {{ $net_value }} Ft.
                @else
                    0 Ft.
                @endif
                </div>
            </div>
            @can('edit sale')
                <form action="{{ route('closeCart') }}" method="post">
                    @csrf
                    <label for="sale_status">Sale status</label>
                    <select name="sale_status" class="form-select">
                    @foreach($SaleStatus as $status)
                        <option value="{{$status->sale_status_id }}">{{$status->sale_status_name}}</option>
                    @endforeach
                    </select>
                    <input type="submit" value="Close" class="btn btn-success">
                </form>
            @endcan
        </div>
    @elseif (Request::is('transfer'))
        <div class="card-body">
            @include("components.calendar")
        </div>
    @elseif (Request::is('transfer/*/edit'))
        <div class="mb-3">
            <h5>Suplier</h5>
            {{ $Transfer->suplier_name }}
            <h5>Status</h5>
            {{ $Transfer->status ?? "" }}
            <h5>Created at</h5>
            {{ $Transfer->created_at ?? "" }}
            <h5>Updated at</h5>
            {{ $Transfer->updated_at ?? "" }}
            @if($Transfer->status == 'PENDING')
                <form action="{{ route('transfer.update', $Transfer->uuid) }}" method="post">
                    @method('PATCH')
                    @csrf
                    <input type="submit" value="Close" class="btn btn-success">
                </form>
            @endif
        </div>
    @elseif (Request::is('inventory-adjustments/*/edit'))
        <div class="mb-3">
            <h5>Suplier</h5>
            {{ $Adjustment->adjustment_type }}
            <h5>Status</h5>
            {{ $Adjustment->status ?? "" }}
            <h5>Created at</h5>
            {{ $Adjustment->created_at ?? "" }}
            <h5>Updated at</h5>
            {{ $Adjustment->updated_at ?? "" }}
            @if($Adjustment->status == 'PENDING')
                <form action="{{ route('inventory-adjustments.update', $Adjustment->uuid) }}" method="post">
                    @method('PATCH')
                    @csrf
                    <div class="mb-3">
                        <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" name="closeNote">
                        <label class="form-check-label" for="flexSwitchCheckDefault">Close the note</label>
                        @error('closeNote')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <input type="submit" value="Close" class="btn btn-success">
                </form>
            @endif
        </div>
    @endif
</div>