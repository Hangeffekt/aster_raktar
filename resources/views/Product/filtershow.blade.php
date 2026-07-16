<div class="modal fade" id="filter" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Products filter</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('products.show', $Product->uuid) }}" method="GET">
                    <div class="form-group">
                        <label>Transaction type</label>
                        <select name="transaction_type" id="transaction_type" class="form-select">
                            <option></option>
                                <option value="IN">IN</option>
                                <option value="OUT">OUT</option>
                                <option value="TRANSFER">TRANSFER</option>
                                <option value="ADJUSTMENT">ADJUSTMENT</option>
                                <option value="SETTLE">SETTLE</option>
                        </select>
                        @error('transaction_type')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Transaction status</label>
                        <select name="transaction_status" id="transaction_status" class="form-select">
                            <option></option>
                                <option value="PENDING">PENDING</option>
                                <option value="COMPLETED">COMPLETED</option>
                                <option value="STORNOED">STORNOED</option>
                                <option value="STORNO">STORNO</option>
                        </select>
                        @error('transaction_status')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Net price</label>
                        <input type="number" name="net_price" id="" value="{{ old('net_price') }}" class="form-control">
                        @error('net_price')
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
                        <label>Qty</label>
                        <input type="number" name="qty" id="" value="{{ old('qty') }}" class="form-control" autofocus>
                        @error('qty')
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