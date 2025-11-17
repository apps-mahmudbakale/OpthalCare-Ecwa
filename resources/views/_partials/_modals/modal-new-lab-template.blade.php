<div class="modal fade" id="new-lab-template" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-simple modal-edit-user">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                <div class="text-center mb-4">
                    <h3 class="mb-2">New Lab Template</h3>
                </div>

                <form action="{{ route('app.lab-template.store') }}" method="POST" class="row g-3">
                    @csrf

                    <div class="col-12 col-md-12">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Laboratory Test Category"
                            required>
                    </div>

                    <!-- REPEATER START -->
                    <div class="col-12">
                        <label class="form-label fw-bold">Test Parameters</label>

                        <div id="lab-parameters-wrapper">

                            <!-- Single Row Template -->
                            <div class="row g-2 mb-2 lab-parameter-row">
                                <div class="col-md-6">
                                    <select name="parameters[]" class="form-control">
                                        <option value="">-- Select Parameter --</option>
                                        @foreach (\App\Models\LabParameter::all() as $parameter)
                                            <option value="{{ $parameter->id }}">{{ $parameter->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-5">
                                    <input type="text" name="references[]" class="form-control"
                                        placeholder="Reference (e.g 12 - 16 g/dL)">
                                </div>

                                <div class="col-md-1 text-start">
                                    <button type="button" class="btn btn-danger btn-sm remove-row">&times;</button>
                                </div>
                            </div>

                        </div>

                        <!-- ADD MORE BUTTON -->
                        <button type="button" id="add-parameter" class="btn btn-primary btn-sm mt-2">
                            + Add Parameter
                        </button>
                    </div>
                    <!-- REPEATER END -->

                    <div class="col-12 text-center mt-3">
                        <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
                        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<!-- JS For Adding/Removing Rows -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const wrapper = document.getElementById('lab-parameters-wrapper');
        const addBtn = document.getElementById('add-parameter');

        // Add new row
        addBtn.addEventListener('click', function() {
            let newRow = wrapper.querySelector('.lab-parameter-row').cloneNode(true);
            newRow.querySelectorAll('input').forEach(i => i.value = '');
            newRow.querySelector('select').value = '';
            wrapper.appendChild(newRow);
        });

        // Remove row
        wrapper.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-row')) {
                let rows = wrapper.querySelectorAll('.lab-parameter-row');
                if (rows.length > 1) {
                    e.target.closest('.lab-parameter-row').remove();
                }
            }
        });
    });
</script>
