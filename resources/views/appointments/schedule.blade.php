 <div class="modal-body">
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    <div class="text-center">
      <h3 class="mb-2">Schedule Appointment</h3>
    </div>
   <form method="post" action="{{route('app.appointments.store')}}" id="new-appointment-form">
     @csrf
     <div class="alert alert-danger d-none"></div>
     <input type="hidden" id="patient_id" name="patient_id" value="{{ $patient->id }}">
     <div class="modal-body">
       <div class="row">
         <div class="form-group col-md-12">
           <label for="id_patient_selected">
             Patient<span class="align-middle fa-2x- text-danger"> *</span>
           </label>
           <input type="hidden" name="patient_id" value="{{$patient->id}}">
           <input type="text" name="patient_name"
                  value="{{ $patient->user->firstname . ' ' . $patient->user->middlename . ' ' . $patient->user->lastname }}"
                  readonly disabled class="form-control">
         </div>
         <div class="form-group col-md-12"> <label for="id_group">
             Appointment Type<span class="align-middle fa-2x- text-danger"> *</span> </label>
           <select name="appointment_type_id" class="selectpicker form-control" data-style="custom-select"
                   autocomplete="off" required="" id="id_group" tabindex="-98">
             <option value="" selected="">---------</option>
             @foreach(\App\Models\AppointmentType::all() as $type)
             <option value="{{$type->id}}">{{$type->name}}</option>
             @endforeach
           </select>
         </div>
       </div>
       <div class="row">
         <div class="form-group col-md-6"> <label for="id_start">
             Start<span class="align-middle fa-2x- text-danger"> *</span> </label>
           <input type="date" class="form-control" name="appointment_start_date" id="">
         </div>
         <div class="form-group col-md-6"> <label for="id_end">
             End<span class="align-middle fa-2x- text-danger"> *</span> </label>
           <input type="date" class="form-control" name="appointment_end_date" id="">
         </div>

       </div>

     </div>
     <div class="modal-footer">
       <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">Close</button>
       <button type="submit" class="btn btn-primary">Schedule</button>
     </div>
   </form>
  </div>

