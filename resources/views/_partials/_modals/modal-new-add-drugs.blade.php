<!-- Edit User Modal -->
<div wire:ignore.self class="modal fade" id="new-add-drugs-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-simple modal-edit-user">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-4">
                    <h3 class="mb-2">New Drug
                    </h3>
                </div>
                <form action="{{ route('app.drugs-add.store') }}" method="POST" class="row g-3">

                    @csrf
                    <div class="col-12 col-md-12">
                        <label class="form-label" for="store_id">Drug Store</label>
                        <select name="store_id" id="store_id" class="form-control">
                            <option value="" selected>Select Store...</option>
                            @foreach (\App\Models\DrugStore::all() as $drugStore)
                                <option value="{{ $drugStore->id }}">{{ $drugStore->name }}</option>
                            @endforeach

                        </select>
                    </div>
                    <div class="col-12 col-md-12">
                        <label class="form-label"> Name</label>
                        <input type="text" name="name" class="form-control" placeholder="New Drug " />
                    </div>
                    <div class="col-12 col-md-12">

                        <input class="form-check-input input-filter" type="checkbox" id="select-active"
                            data-value="active" checked>
                        <label class="form-check-label" for="select-active">Active</label>
                        <div>
                            <small>Allow this drug to be prescribed to patients.</small>
                        </div>
                    </div>
                    <div class="col-12 col-md-12">
                        <label class="form-label"> Quantity </label>
                        <input type="number" name="quantity" class="form-control" placeholder="0" />

                    </div>
                    <div class="col-12 col-md-12">
                        <label class="form-label" for="category_id">Drug Category</label>
                        <select name="category_id" id="category_id" class="form-control">
                            <option value="" selected>Select Category...</option>
                            @foreach (\App\Models\DrugCategory::all() as $drugCategory)
                                <option value="{{ $drugCategory->id }}">{{ $drugCategory->name }}</option>
                            @endforeach

                        </select>
                    </div>
                    <div class="col-12 col-md-12">
                        <label class="form-label"> Default Price</label>
                        <input type="number" name="price" class="form-control" placeholder="0" />
                        <div>
                            <small>Amount to charge private plan patients for a unit of this item.</small>
                        </div>
                    </div>
                    <div class="col-12 col-md-12">
                        <label class="form-label"> Expiry Date</label>
                        <input type="date" name="expiry_date" class="form-control" />
                    </div>
                    <div class="col-12 col-md-12">
                        <label class="form-label"> Threshold</label>
                        <input type="number" name="threshold" class="form-control" placeholder="0" />
                        <div>
                            <small>Low Stock Threshold.</small>
                        </div>
                    </div>
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
                        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                            aria-label="Close">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--/ Edit User Modal -->
