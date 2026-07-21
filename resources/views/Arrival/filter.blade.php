<div class="modal fade" id="filter" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Suplier filter</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('arrivals.index') }}" method="GET">
                    <div class="form-group">
                        <label>Status</label>
                        <select name="arrival_status" id="arrival_status" class="form-select">
                            <option></option>
                                <option value="PENDING">PENDING</option>
                                <option value="COMPLETED">COMPLETED</option>
                                <option value="STORNOED">STORNOED</option>
                                <option value="STORNO">STORNO</option>
                        </select>
                        @error('arrival_status')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="">Suplier name</label>
                        <select name="suplier_uuid" id="" class="form-select">
                            <option>-- Kérjük válasszon --</option>
                            @foreach($Supliers as $Suplier)
                                <option value="{{ $Suplier->uuid }}"
                                @if(old('suplier_uuid') && old('suplier_uuid') == $Suplier->uuid)
                                    selected
                                @endif
                                >{{ $Suplier->suplier_name }}</option>
                            @endforeach
                        </select>
                        @error('suplier_uuid')
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
                    <x-calendar></x-calendar>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
            </div>
        </div>
    </div>
</div>