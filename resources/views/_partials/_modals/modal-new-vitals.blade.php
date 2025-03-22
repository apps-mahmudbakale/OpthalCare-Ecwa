<!-- Edit User Modal -->
<div wire:ignore.self class="modal fade" id="new-vitals-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-simple modal-edit-user">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-4">
                    <h3 class="mb-2">Record Vital Signs for
                        {{ \App\Models\Patient::find(request()->route()->patient->id)->user->firstname }}
                    </h3>
                </div>
                <form action="{{ route('app.vitals.store') }}" method="POST" class="row g-3">
                    @csrf
                    <input type="hidden" name="patient_id" value="{{ request()->route()->patient->id }}">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-striped" id="vitalSignsTable">
                                <thead>
                                    <tr>
                                        <th scope="col">Parameter</th>
                                        <th scope="col">Value</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">
                                            <?php
                                            $parameter_options = array(
                                            "" => "---------",
                                            "Temperature" => "Temperature",
                                            "Pulse" => "Pulse",
                                            "Weight" => "Weight",
                                            "Blood Pressure" => "Blood Pressure",
                                            "Fundus Height" => "Fundus Height",
                                            "Glucose" => "Glucose",
                                            "Head Circumference" => "Head Circumference",
                                            "Height" => "Height",
                                            "Length of Arm" => "Length of Arm",
                                            "MUAC" => "MUAC",
                                            "Mid-Arm Circumference" => "Mid-Arm Circumference",
                                            "PCV" => "PCV",
                                            "Pain Scale" => "Pain Scale",
                                            "Protein" => "Protein",
                                            "Respiration" => "Respiration",
                                            "SpO2" => "SpO2",
                                            "Surface Area" => "Surface Area",
                                            "Urine" => "Urine",
                                            "BMI" => "BMI",
                                            "EWS" => "EWS",
                                            "BSA" => "BSA",
                                            "Dilation" => "Dilation",
                                            "Fetal Heart Rate" => "Fetal Heart Rate"
                                            );
                                            ?>
                                            <select class="form-select" name="parameter[]" aria-label="Parameter">
                                                <?php foreach ($parameter_options as $value => $text): ?>
                                                <option value="<?php echo $value; ?>"><?php echo $text; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </th>
                                        <td><input type="text" name="value[]" class="form-control"></td>
                                        <td>
                                            <button type="button" class="btn btn-danger btn-sm delete-row">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <button type="button" class="btn btn-primary mt-2" id="addMoreBtn">Add More
                                Reading</button>


                        </div>
                    </div>



                    <script>
                        $(document).ready(function() {
                            $('#addMoreBtn').click(function() {
                                var newRow = $('<tr></tr>');
                                newRow.append(
                                    '<td><select class="form-select" name="parameter[]" aria-label="Parameter">@foreach ($parameter_options as $value => $text)<option value="{{ $value }}">{{ $text }}</option>@endforeach</select></td>'
                                );
                                newRow.append('<td><input type="text" name="value[]" class="form-control"></td>');
                                newRow.append(
                                    '<td><button type="button" class="btn btn-danger btn-sm delete-row"><span aria-hidden="true">&times;</span></button></td>'
                                );
                                $('#vitalSignsTable tbody').append(newRow);
                            });

                            $(document).on('click', '.delete-row', function() {
                                $(this).closest('tr').remove();
                            });
                        });
                    </script>



                    <div class="col-12 text-center">
                        <button type="button" data-bs-dismiss="modal" aria-label="Close"
                            class="btn btn-secondary text-black">Close</button>
                        <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--/ Edit User Modal -->
