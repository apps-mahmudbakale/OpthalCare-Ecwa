<!-- Edit User Modal -->
<div wire:ignore.self class="modal fade" id="new-imaging-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-simple modal-edit-user">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-4">
                    <h3 class="mb-2">New Imaging for
                        {{ \App\Models\Patient::find(request()->route()->patient->id)->user->firstname }}
                    </h3>
                </div>
                <form action="{{ route('app.radiology.store') }}" method="POST" class="row g-3">
                    @csrf
                    <input type="hidden" name="patient_id" value="{{ request()->route()->patient->id }}">
                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                    <div class="col-12 col-md-12">
                        <label class="form-label">Imaging Services</label>
                        <select name="imaging_id" id="" class="form-control">
                            <option value="">----</option>
                            @foreach (\App\Models\Radiology::all() as $imaging)
                                <option value="{{ $imaging->id }}">{{ $imaging->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-12">
                        <label class="form-label"> Priority</label>
                        <select name="priority" id="" class="form-control">
                            <option value="">---</option>
                            <option value="Low">Low</option>
                            <option value="Medium">Medium</option>
                            <option value="High">High</option>
                            <option value="Urgent">Urgent</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-12">
                        <label class="form-label">Request Note</label>
                        <textarea name="request_note" class="form-control" id="" cols="30" rows="10"></textarea>
                    </div>
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
                        <button data-bs-dismiss="modal" aria-label="Close"
                            class="btn btn-label-secondary">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--/ Edit User Modal -->
