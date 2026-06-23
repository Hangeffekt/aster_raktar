@extends('index')

@section("content")
<form action="{{ route('products.store') }}" method="post">
    @csrf
    <div class="form-group"><label>Brand</label>
        <select name="brand_id" id="brand_id" class="form-select">
            <option>-- Kérjük válasszon --</option>
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
    <div class="form-group"><label>Típus</label>
        <input type="text" name="product_name" id="" value="{{ old('product_name') }}" class="form-control">
        @error('product_name')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group"><label>Tax</label>
        <select name="tax_id" id="" class="form-select">
            <option>-- Kérjük válasszon --</option>
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
        <label>Eladási ár</label>
        <input type="number" name="sale_price" id="" value="{{ old('sale_price') }}" class="form-control">
	    <div id="warning-eladasiar" class="warning-eladasiar">Figyelem, lehetséges magas érték</div>
        @error('sale_price')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label>Kategória</label>
        <select name="catalog_id" id="" class="form-select">
            <option value="">-- Kérjük válasszon --</option>
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
        <label>Vonalkód</label>
        <input type="number" name="ean" id="" value="{{ old('ean') }}" class="form-control">
        @error('ean')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <input type="submit" value="Mentés" class="btn btn-success">
</form>
@endsection