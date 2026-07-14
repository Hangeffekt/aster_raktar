<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#filter">
Filter
</button>

    <!-- Modal -->
@if (Request::is('products*'))
    @include('Product/filter')
@elseif (Request::is('arrivals*'))
<div class="modal fade" id="filter" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Arrival filter</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('arrivals.index') }}" method="GET">
                    <div class="form-group"><label>Brand</label>
                        <select name="suplier_id" id="brand_id" class="form-select">
                            <option>-- Please choose --</option>
                            @foreach($Supliers as $Suplier)
                                <option value="{{ $Suplier->uuid }}"
                                @if(old('suplier_id') && old('suplier_id') == $Suplier->suplier_uuid)
                                    selected
                                @endif
                                >{{ $Suplier->suplier_name }}</option>
                            @endforeach
                        </select>
                        @error('suplier_id')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="">Suplier note number</label>
                        <input type="text" name="suplier_note_number" value="{{ old('suplier_note_number') }}" class="form-control">
                        @error('suplier_note_number')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="">Invoice number</label>
                        <input type="text" name="invoice_number" value="{{ old('invoice_number') }}" class="form-control">
                        @error('invoice_number')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
            </div>
        </div>
    </div>
</div>
@elseif (Request::is('sales*'))
<div class="modal fade" id="filter" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Arrival filter</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('arrivals.index') }}" method="GET">
                    <div class="form-group"><label>Payment type</label>
                        <select name="payment_type" id="payment_type" class="form-select">
                            <option>-- Please choose --</option>
                            @foreach($PaymentTypes as $PaymentType)
                                <option value="{{ $PaymentType->uuid }}"
                                @if(old('PaymentType') && old('PaymentType') == $PaymentType->uuid)
                                    selected
                                @endif
                                >{{ $PaymentType->payment_type }}</option>
                            @endforeach
                        </select>
                        @error('payment_type')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="">Suplier note number</label>
                        <input type="text" name="suplier_note_number" value="{{ old('suplier_note_number') }}" class="form-control">
                        @error('suplier_note_number')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="">Invoice number</label>
                        <input type="text" name="invoice_number" value="{{ old('invoice_number') }}" class="form-control">
                        @error('invoice_number')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif