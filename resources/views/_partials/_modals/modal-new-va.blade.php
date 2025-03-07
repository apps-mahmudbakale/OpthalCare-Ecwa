<!-- Edit User Modal -->
<div wire:ignore.self class="modal fade" id="new-va-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-simple modal-edit-user">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-4">
                    <h3 class="mb-2">Record Vision Acuity Test for
                        {{ \App\Models\Patient::find(request()->route()->patient->id)->user->firstname }}
                        {{ \App\Models\Patient::find(request()->route()->patient->id)->user->lastname }}
                    </h3>
                </div>
                <form action="{{ route('app.vision-acuity.store') }}" method="POST" class="row g-3">
                    @csrf
                    <input type="hidden" name="patient_id" value="{{ request()->route()->patient->id }}">
                    <table class="table table-striped">
                        <thead class="table-dark">
                            <th></th>
                            <th>RIGHT EYE (RE)</th>
                            <th>LEFT EYE (LE)</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td width="50%">Uncorrected VA</td>
                                <td><input type="text" name="right" class="form-control"></td>
                                <td><input type="text" name="left" class="form-control"></td>
                            </tr>
                            <tr>
                                <td width="50%">PINHOLE </td>
                                <td><input type="text" name="right_pinhole" class="form-control"></td>
                                <td><input type="text" name="left_pinhole" class="form-control"></td>
                            </tr>
                            <tr>
                                <td width="50%">VA With Glasses</td>
                                <td><input type="text" name="right_glasses" class="form-control"></td>
                                <td><input type="text" name="left_glasses" class="form-control"></td>
                            </tr>
                        </tbody>
                        <input type="hidden" name="disablities" value="{{ request()->route()->patient->id }}">
                    </table>
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
