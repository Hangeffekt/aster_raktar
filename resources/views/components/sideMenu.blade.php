<div class="col-3 text-bg-info bg-gradient rounded-4">
    @if (Request::is('arrivals/*/edit'))
        <div class="card-body">
            <div class="mb-3">
                <h4>Net value:</h4>
                <div>
                @if(count($Arrivalitems) != 0)
                        @php
                            $net_value = 0;
                        @endphp
                    @foreach($Arrivalitems as $Arrivalitem)
                        @php
                            $net_value +=  $Arrivalitem->net_price * $Arrivalitem->qty;
                        @endphp
                    @endforeach
                    {{ $net_value }} Ft.
                @else
                    0 Ft.
                @endif
                </div>
            </div>
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
            <form action="{{ route('closeArrival') }}" method="post">
                @csrf
                <div class="mb-3">
                    <input type="hidden" name="arrival_id" value="{{ $editArrival->uuid }}">
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
    @elseif (Request::is('arrivals'))
        <div class="card-body">
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
    @elseif (Request::is('products', 'brands', 'catalogs', 'shops', 'taxes', 'supliers', 'paymenttypes'))
        <div class="list-group">
            <a class="list-group-item list-group-item-action list-group-item-info @if(Request::is('products')) active @endif" href="/products">Products</a>
            <a class="list-group-item list-group-item-action list-group-item-info @if(Request::is('brands')) active @endif" href="/brands">Brands</a>
            <a class="list-group-item list-group-item-action list-group-item-info @if(Request::is('catalogs')) active @endif" href="/catalogs">Catalogs</a>
            <a class="list-group-item list-group-item-action list-group-item-info @if(Request::is('shops')) active @endif" href="/shops">Shops</a>
            <a class="list-group-item list-group-item-action list-group-item-info @if(Request::is('taxes')) active @endif" href="/taxes">Taxes</a>
            <a class="list-group-item list-group-item-action list-group-item-info @if(Request::is('supliers')) active @endif" href="/supliers">Supliers</a>
            <a class="list-group-item list-group-item-action list-group-item-info @if(Request::is('paymenttypes')) active @endif" href="/paymenttypes">Payment types</a>
        </div>
    @elseif (Request::is('sales') || Request::is('sales/history'))
        <div class="mb-3">
            <h5>Calendar</h5>
            <form action="sales/history" method="post">
                @csrf
                <input type="date" name="date">
                <input type="submit" value="check" class="btn btn-success" name="history">
            </form>
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
        <div class="mb-3">
            <h5>Status</h5>
            {{ $Sale->sale_status ?? "" }}
            <h5>Payment mode</h5>
            {{ $Sale->payment_type ?? "" }}
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
                    {{ $net_value }} Ft.
                @else
                    0 Ft.
                @endif
            </div>
            <h5>Created at</h5>
            {{ $Sale->created_at ?? "" }}
            <h5>Updated at</h5>
            {{ $Sale->updated_at ?? "" }}
            @if($Sale->sale_status == 'PENDING')
                <form action="{{ route('sales.update', $Sale->sale_id) }}" method="post">
                    @method('PATCH')
                    @csrf
                    <label for="sale_status">Payment type</label>
                    <select name="payment_type" class="form-select">
                    @foreach($SaleStatus as $status)
                        <option value="{{$status->uuid }}">{{$status->payment_type}}</option>
                    @endforeach
                    </select>
                    <input type="submit" value="Close" class="btn btn-success">
                </form>
            @endif
        </div>
    @elseif (Request::is('salestorno/*/edit'))
    <div class="mb-3">
        <h5>Storno</h5>
        <form action="{{ route('salestorno.update', $Sale->sale_id) }}" method="post">
            @csrf
            @method("PATCH")
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
        </div>
    @endif
</div>