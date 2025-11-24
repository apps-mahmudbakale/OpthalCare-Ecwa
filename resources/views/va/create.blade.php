 <div class="text-center mb-4">
          <h3 class="mb-2">Record Visual Acuity Test for
            {{ \App\Models\Patient::find($patient)->user->firstname }}
            {{ \App\Models\Patient::find($patient)->user->lastname }}
          </h3>
        </div>
        <form action="{{ route('app.vision-acuity.store') }}" method="POST" class="row g-3">
          @csrf
          <input type="hidden" name="patient_id" value="{{ $patient }}">
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
            <label for="comments">Comments</label>
            <textarea name="comment" id="" cols="30" rows="10" class="form-control"></textarea>
          </table>
          <div class="col-12 text-center">
            <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
            <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                    aria-label="Close">Cancel</button>
          </div>
        </form>
