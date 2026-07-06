<button class="btn btn-warning" id="add_item">Add item</button>
@if($errors->any())
    {!! implode('', $errors->all('<div>:message</div>')) !!}
@endif
<div class="add_item_box modal" id="add_item_box">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add item control panel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="add_item_box_close"></button>
            </div>
            <div class="modal-body">
                <div class="accordion" id="accordionSearch">
                    <button class="btn btn-info" type="button" data-bs-toggle="collapse" data-bs-target="#SearchPanel" aria-expanded="true" aria-controls="SearchPanel">
                        Search
                    </button>
                    <button class="btn btn-info" type="button" data-bs-toggle="collapse" data-bs-target="#AdvancedSearchPanel" aria-expanded="true" aria-controls="AdvancedSearchPanel">
                        Advenced search
                    </button>
                    <div id="SearchPanel" class="accordion-collapse collapse show" aria-labelledby="headingSearch" data-bs-parent="#accordionSearch">
                        <form id="Product-Search" data-url="{{route('productsearch')}}">
                            <div class="mb-3">
                                <label for="">Ean</label>
                                <input type="number" name="ean" class="form-control">
                                <div class="col-12 alert alert-success ean_alert">Incorrect ean code!</div>
                            </div>
                            <input type="submit" value="Search" class="btn btn-success" >
                        </form>
                    </div>
                    <div id="AdvancedSearchPanel" class="accordion-collapse collapse" aria-labelledby="headingAdvancedSearchPanel" data-bs-parent="#accordionSearch">
                        <form id="Product-Search-Advanced" data-url="{{route('advancedproductsearch')}}">
                            <div class="mb-3">
                                <label for="">Name</label>
                                <input type="text" name="product_name" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="">Brand</label>
                                <select name="brand_id" class="form-select">
                                    <option value="">-- Kérlek válassz --</option>
                                    @if(count($Brands) != 0)
                                        @foreach($Brands as $Brand)
                                            <option value="{{ $Brand->brand_id }}">{{ $Brand->brand_name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="">Catalog</label>
                                <select name="catalog_id" class="form-select">
                                    <option value="">-- Kérlek válassz --</option>
                                    @if(count($Catalogs) != 0)
                                        @foreach($Catalogs as $Catalog)
                                            <option value="{{ $Catalog->catalog_id }}">{{ $Catalog->catalog_name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" name="witoutzeroqty">
                                <label class="form-check-label" for="flexSwitchCheckDefault">Without zero qty</label>
                            </div>
                            <input type="submit" value="Search" class="btn btn-success">
                        </form>
                    </div>
                    <div id="product_list" data-url="@if(Request::is('arrivals/*/edit')){{route('arrivalitem.store')}}
                                                    @elseif(Request::is('sales/*/edit')){{route('cart.store')}}
                                                    @elseif(Request::is('transfer/*/edit')){{route('transferitem.store')}}
                                                    @endif"
                                                    data-bs-target="@if(Request::is('arrivals/*/edit')){{ $editArrival->uuid }}
                                                    @elseif(Request::is('sales/*/edit')){{ $Sale->uuid }}
                                                    @elseif(Request::is('transfer/*/edit')){{ $Transfer->uuid }}
                                                    @endif"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="add_item_setting_box modal" id="add_item_setting_box">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="add_item_setting_box_close"></button>
            </div>
            <div class="modal-body">
                <form action="">
                    @csrf
                    <div class="mb-3">
                        <label for="">Net price</label>
                        <input type="text" name="net_price" class="form-control" value="">
                    </div>
                    <div class="mb-3">
                        <label for="">Sale price</label>
                        <input type="text" name="sale_price" class="form-control" value="">
                    </div>
                    <div class="mb-3">
                        <label for="">Qty</label>
                        <input type="text" name="qty" class="form-control" value="1">
                    </div>
                    <input type="submit" value="Save" class="btn btn-success">
                </form>
            </div>
        </div>
    </div>
</div>