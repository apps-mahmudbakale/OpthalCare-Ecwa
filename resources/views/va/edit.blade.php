 <div class="text-center mb-4">
          <h3 class="mb-2">Update Visual Acuity Test for
            {{ \App\Models\Patient::find($patient)->user->firstname }}
            {{ \App\Models\Patient::find($patient)->user->lastname }}
          </h3>
        </div>
        <form action="{{ route('app.vision-acuity.update', $va->id) }}" method="POST" class="row g-3">
          @method('PUT')
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
              <td><input type="text" name="right" value="{{$va->right ?? " "}}" class="form-control"></td>
              <td><input type="text" name="left" value="{{$va->left ?? " "}}" class="form-control"></td>
            </tr>
            <tr>
              <td width="50%">PINHOLE </td>
              <td><input type="text" name="right_pinhole" value="{{$va->right_pinhole ?? " "}}" class="form-control"></td>
              <td><input type="text" name="left_pinhole" value="{{$va->left_pinhole ?? " "}}" class="form-control"></td>
            </tr>
            <tr>
              <td width="50%">VA With Glasses</td>
              <td><input type="text" name="right_glasses" value="{{$va->right_glasses ?? " "}}" class="form-control"></td>
              <td><input type="text" name="left_glasses" value="{{$va->left_glasses ?? " "}}" class="form-control"></td>
            </tr>
            </tbody>
          </table>
          <label for="comments">Comments</label>
          <textarea name="comment" id="" cols="30" rows="10" class="form-control">{{$va->comment ?? ""}}</textarea>
          <div class="col-12 text-center">
            <button type="submit" class="btn btn-primary me-sm-3 me-1">Update</button>
            <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                    aria-label="Close">Cancel</button>
          </div>
        </form>

