<!-- Edit Drug Modal -->
<div wire:ignore.self class="modal fade" id="edit-drug-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-simple modal-edit-user">
        <div class="modal-content p-3 p-md-5">

            <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                <div class="text-center mb-4">
                    <h3 class="mb-2">Update Drug</h3>
                </div>

                <form action="{{ route('app.settings.pharmacy.update', $drug->id) }}" method="POST" class="row g-3">
                    @csrf
                    @method('PUT')

                    <!-- Store -->
                    <div class="col-12 col-md-12">
                        <label class="form-label" for="store_id">Drug Store</label>
                        <select name="store_id" id="store_id" class="form-control">
                            <option selected value="{{ $drug->store->id }}">{{ $drug->store->name }}</option>
                            @foreach (\App\Models\DrugStore::all() as $drugStore)
                                <option value="{{ $drugStore->id }}">{{ $drugStore->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Name -->
                    <div class="col-12 col-md-12">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $drug->name) }}"
                            placeholder="Drug Name" />
                    </div>

                    <!-- Active -->
                    <div class="col-12 col-md-12">
                        <input class="form-check-input" type="checkbox" name="is_active" id="select-active"
                            {{ $drug->is_active ? 'checked' : '' }}>
                        <label class="form-check-label" for="select-active">Active</label>
                        <div><small>Allow this drug to be prescribed to patients.</small></div>
                    </div>

                    <!-- Quantity -->
                    <div class="col-12 col-md-12">
                        <label class="form-label">Quantity</label>
                        <input type="number" name="quantity" class="form-control"
                            value="{{ old('quantity', $drug->quantity) }}" placeholder="0" />
                    </div>

                    <!-- Category -->
                    <div class="col-12 col-md-12">
                        <label class="form-label" for="category_id">Drug Category</label>
                        <select name="category_id" id="category_id" class="form-control">
                            <option value="">Select Category...</option>
                            @foreach (\App\Models\DrugCategory::all() as $drugCategory)
                                <option value="{{ $drugCategory->id }}"
                                    {{ $drugCategory->id == $drug->category_id ? 'selected' : '' }}>
                                    {{ $drugCategory->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Default Price -->
                    <div class="col-12 col-md-12">
                        <label class="form-label">Default Price</label>
                        <input type="number" name="price" class="form-control"
                            value="{{ old('price', $drug->price) }}" placeholder="0" />
                        <small>Amount charged per unit.</small>
                    </div>

                    <!-- Expiry -->
                    <div class="col-12 col-md-12">
                        <label class="form-label">Expiry Date</label>
                        <input type="date" name="expiry_date" class="form-control"
                            value="{{ old('expiry_date', $drug->expiry_date) }}" />
                    </div>

                    <!-- Threshold -->
                    <div class="col-12 col-md-12">
                        <label class="form-label">Threshold</label>
                        <input type="number" name="threshold" class="form-control"
                            value="{{ old('threshold', $drug->threshold) }}" placeholder="0" />
                        <small>Low stock threshold.</small>
                    </div>

                    <!-- Buttons -->
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary me-sm-3 me-1">Update</button>
                        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                            Cancel
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>
<!-- End Edit Drug Modal -->
