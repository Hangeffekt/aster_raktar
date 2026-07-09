<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#filter">
Filter
</button>

    <!-- Modal -->
@if (Request::is('products*'))
<div class="modal fade" id="filter" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Products filter</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('products.index') }}" method="GET">
                    <div class="form-group"><label>Brand</label>
                        <select name="brand_id" id="brand_id" class="form-select">
                            <option>-- Please choose --</option>
                            @foreach($Brands as $Brand)
                                <option value="{{ $Brand->brand_id }}"
                                @if(old('brand_id') && old('brand_id') == $Brand->brand_id)
                                    selected
                                @endif
                                >{{ $Brand->brand_name }}</option>
                            @endforeach
                        </select>
                        @error('brand_id')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group"><label>Type</label>
                        <input type="text" name="product_name" id="" value="{{ old('product_name') }}" class="form-control">
                        @error('product_name')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group"><label>Tax</label>
                        <select name="tax_id" id="" class="form-select">
                            <option>-- Please choose --</option>
                            @foreach($Taxes as $Tax)
                                <option value="{{ $Tax->tax_id }}"
                                @if(old('tax_id') && old('tax_id') == $Tax->tax_id)
                                    selected
                                @endif
                                >{{ $Tax->tax_value }}</option>
                            @endforeach
                        </select>
                        @error('tax_id')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Sale price</label>
                        <input type="number" name="sale_price" id="" value="{{ old('sale_price') }}" class="form-control">
                        @error('sale_price')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Catalog</label>
                        <select name="catalog_id" id="" class="form-select">
                            <option value="">-- Please choose --</option>
                            @foreach($Catalogs as $Catalog)
                                <option value="{{ $Catalog->catalog_id }}"
                                @if(old('catalog_id') && old('catalog_id') == $Catalog->catalog_id)
                                    selected
                                @endif
                                >{{ $Catalog->catalog_name }}</option>
                            @endforeach
                        </select>
                        @error('catalog_id')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>EAN</label>
                        <input type="number" name="ean" id="" value="{{ old('ean') }}" class="form-control">
                        @error('ean')
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