<div class="modal fade" id="filter" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Products filter</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('products.index') }}" method="GET">
                    <div class="form-group">
                        <label>Brand</label>
                        <select name="brand_uuid" id="brand_uuid" class="form-select">
                            <option>-- Please choose --</option>
                            @foreach($Brands as $Brand)
                                <option value="{{ $Brand->uuid }}"
                                @if(old('brand_uuid') && old('brand_uuid') == $Brand->brand_uuid)
                                    selected
                                @endif
                                >{{ $Brand->brand_name }}</option>
                            @endforeach
                        </select>
                        @error('brand_uuid')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Type</label>
                        <input type="text" name="product_name" id="" value="{{ old('product_name') }}" class="form-control">
                        @error('product_name')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Tax</label>
                        <select name="tax_uuid" id="tax_uuid" class="form-select">
                            <option>-- Please choose --</option>
                            @foreach($Taxes as $Tax)
                                <option value="{{ $Tax->uuid }}"
                                @if(old('tax_uuid') && old('tax_uuid') == $Tax->uuid)
                                    selected
                                @endif
                                >{{ $Tax->tax_value }}</option>
                            @endforeach
                        </select>
                        @error('tax_uuid')
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
                        <select name="catalog_uuid" id="catalog_uuid" class="form-select">
                            <option value="">-- Please choose --</option>
                            @foreach($Catalogs as $Catalog)
                                <option value="{{ $Catalog->uuid }}"
                                @if(old('catalog_uuid') && old('catalog_uuid') == $Catalog->uuid)
                                    selected
                                @endif
                                >{{ $Catalog->catalog_name }}</option>
                            @endforeach
                        </select>
                        @error('catalog_uuid')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>EAN</label>
                        <input type="number" name="ean" id="" value="{{ old('ean') }}" class="form-control" autofocus>
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