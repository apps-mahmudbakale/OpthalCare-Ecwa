<!-- Edit Drug Modal -->
<div wire:ignore.self class="modal fade" id="editDrugModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-simple modal-edit-user">
        <div class="modal-content p-3 p-md-5">

            <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>

                <div class="text-center mb-4">
                    <h3 class="mb-2">Edit Drug</h3>
                </div>

                <form wire:submit.prevent="updateDrugs" class="row g-3">

                    <!-- Drug Name -->
                    <div class="col-12">
                        <label class="form-label">Name</label>
                        <input type="text" wire:model.defer="DrugName" class="form-control">
                    </div>

                    <!-- Drug Category -->
                    <div class="col-12">
                        <label class="form-label">Category</label>
                        <select wire:model="DrugCategory" class="form-control">
                            <option value="">Select Category...</option>
                            @foreach (\App\Models\DrugCategory::all() as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Drug Price -->
                    <div class="col-12">
                        <label class="form-label">Price</label>
                        <input type="number" wire:model.defer="DrugPrice" class="form-control">
                    </div>

                    <!-- Submit -->
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                            Cancel
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
