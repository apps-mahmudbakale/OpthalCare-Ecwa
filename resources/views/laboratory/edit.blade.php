<h3 class="mb-2 text-center">Update Lab for
  {{ \App\Models\Patient::find($lab->patient_id)->user->firstname }}
  {{ \App\Models\Patient::find($lab->patient_id)->user->lastname }}
</h3>

<form action="{{ route('app.lab.update', $lab->id) }}" method="POST" class="row g-3">
  @csrf
  @method('PUT')

  <input type="hidden" name="patient_id" value="{{ $lab->patient_id }}">
  <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

  <div class="col-12 col-md-12">
    <label class="form-label">Lab Test</label>
    <select name="test_id" class="form-control">
      <option selected value="{{ $lab->test_id }}">
        {{ \App\Models\Laboratory::find($lab->test_id)->name }}
      </option>
      @foreach (\App\Models\Laboratory::all() as $laboratory) {{-- use $laboratory, not $lab --}}
      <option value="{{ $laboratory->id }}">{{ $laboratory->name }}</option>
      @endforeach
    </select>
  </div>

  <div class="col-12 col-md-12">
    <label class="form-label">Priority</label>
    <select name="priority" class="form-control">
      <option selected value="{{ $lab->priority }}">{{ $lab->priority }}</option>
      <option value="Low">Low</option>
      <option value="Medium">Medium</option>
      <option value="High">High</option>
      <option value="Urgent">Urgent</option>
    </select>
  </div>

  <div class="col-12 col-md-12">
    <label class="form-label">Request Note</label>
    <textarea name="request_note" class="form-control" cols="30" rows="5">{{ $lab->request_note }}</textarea> {{-- fixed field name --}}
  </div>

  <div class="col-12 text-center">
    <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
    <button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn btn-label-secondary">Close</button>
  </div>
</form>
