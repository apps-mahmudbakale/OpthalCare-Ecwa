<!-- Edit User Modal -->
<div wire:ignore.self class="modal fade" id="new-drugs-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-simple modal-edit-user">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-4">
                    <h3 class="mb-2">New Drugs for
                        {{ \App\Models\Patient::find(request()->route()->patient->id)->user->firstname . ' ' . \App\Models\Patient::find(request()->route()->patient->id)->user->lastname }}
                    </h3>
                </div>
                <form action="{{ route('app.pharmacy.store') }}" method="POST" class="row g-3">
                    @csrf
                    <input type="hidden" name="patient_id" value="{{ request()->route()->patient->id }}">
                    <div class="col-12 col-md-12">
                        <label class="form-label"> Store</label>
                        <select name="store_id" id="store" class="form-control">
                            <option value="" selected>Select Store...</option>
                            @foreach (\App\Models\DrugStore::all() as $drugStore)
                                <option value="{{ $drugStore->id }}">{{ $drugStore->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-12">
                        <label class="form-label" for="category_id">Drug Category</label>
                        <select name="category_id" id="category" class="form-control">
                            <option value="" selected>Select Category...</option>
                            @foreach (\App\Models\DrugCategory::all() as $drugCategory)
                                <option value="{{ $drugCategory->id }}">{{ $drugCategory->name }}</option>
                            @endforeach

                        </select>
                    </div>
                    <div class="col-12 col-md-12">
                        <label class="form-label"> Drug</label>
                        <select name="drug_id" id="drug" class="form-control">

                        </select>

                    </div>
                    <div class="col-12 col-md-12">
                        <label class="form-label" for="category_id">Dose</label>
                        <input type="text" name="dose" class="form-control" placeholder="Dose">
                    </div>

                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
                        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--/ Edit User Modal -->

<script>
    var store = document.getElementById('store'),
        category = document.getElementById('category'),
        drugs = document.getElementById('drug');

    category.addEventListener('change', (() => {
        // alert(store.value);
        fetch('/getDrugsbyStore', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Add this line if you're using CSRF protection
                },
                body: JSON.stringify({
                    store: store.value,
                    category: category.value
                }),
            })
            .then(response => response.json())
            .then(data => {
                drugs.innerHTML = '';

                data.forEach(drug => {
                    var option = document.createElement('option');
                    option.value = drug.id;
                    option.text = drug.name; // Assuming 'name' is the display name of the drug
                    drugs.appendChild(option);
                });
            })
            .catch(error => console.error('Error:', error));
    }))
</script>
