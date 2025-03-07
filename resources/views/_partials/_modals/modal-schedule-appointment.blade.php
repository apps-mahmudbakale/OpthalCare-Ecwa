<!-- Share Project Modal -->
<div class="modal fade" id="schedule-appointment{{ $patient->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-simple modal-enable-otp modal-dialog-centered">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center">
                    <h3 class="mb-2">Schedule Appointment</h3>
                </div>
            </div>
            <form method="post" action="" id="new-appointment-form">
                @csrf
                <div class="alert alert-danger d-none"></div>
                <input type="hidden" id="patient_id" name="patient_id" value="{{ $patient->id }}">
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="id_patient_selected">
                                Patient<span class="align-middle fa-2x- text-danger"> *</span>
                            </label>
                            <input type="text" name="patient_name"
                                value="{{ $patient->user->firstname . ' ' . $patient->user->middlename . ' ' . $patient->user->lastname }}"
                                readonly disabled class="form-control">
                        </div>
                        <div class="form-group col-md-12"> <label for="id_group">
                                Appointment Type<span class="align-middle fa-2x- text-danger"> *</span> </label>
                            <select name="group" class="selectpicker form-control" data-style="custom-select"
                                autocomplete="off" required="" id="id_group" tabindex="-98">
                                <option value="" selected="">---------</option>
                                <option value="3">MEDICAL CHECK UP</option>
                                <option value="1">CONSULTATION</option>
                                <option value="4">PROCEDURE BOOKING</option>
                                <option value="2">CONSULTANT REVIEW</option>

                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6"> <label for="id_start">
                                Start<span class="align-middle fa-2x- text-danger"> *</span> </label>
                            <input type="date" class="form-control" name="start" id="">
                        </div>
                        <div class="form-group col-md-6"> <label for="id_end">
                                End<span class="align-middle fa-2x- text-danger"> *</span> </label>
                            <input type="date" class="form-control" name="end" id="">
                        </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Schedule</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--/ Share Project Modal -->
