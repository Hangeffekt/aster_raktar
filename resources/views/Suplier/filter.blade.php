<div class="modal fade" id="filter" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Suplier filter</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('supliers.index') }}" method="GET">
                    <div class="form-group mb-3">
                        <label for="">Company name</label>
                        <input type="text" name="suplier_name" class="form-control"  value="{{ old('suplier_name') }}">
                        @error('suplier_name')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Zip code</label>
                        <input type="text" name="suplier_zip_code" class="form-control"  value="{{ old('suplier_zip_code') }}">
                        @error('suplier_zip_code')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Town</label>
                        <input type="text" name="suplier_settlement" class="form-control"  value="{{ old('suplier_settlement') }}">
                        @error('suplier_settlement')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Address</label>
                        <input type="text" name="suplier_address" class="form-control"  value="{{ old('suplier_address') }}">
                        @error('suplier_address')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Tax number</label>
                        <input type="text" name="suplier_tax_number" class="form-control"  value="{{ old('suplier_tax_number') }}">
                        @error('suplier_tax_number')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Phone</label>
                        <input type="text" name="suplier_phone" class="form-control"  value="{{ old('suplier_phone') }}">
                        @error('suplier_phone')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Email</label>
                        <input type="text" name="suplier_email" class="form-control"  value="{{ old('suplier_email') }}">
                        @error('suplier_email')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
            </div>
        </div>
    </div>
</div>