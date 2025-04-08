
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="text-center mb-4">
          <h3 class="mb-2">Update Intra Ocular Pressure Chart for
            {{ \App\Models\Patient::find($patient)->user->firstname }}
            {{ \App\Models\Patient::find($patient)->user->lastname }}
          </h3>
        </div>
        <form action="{{ route('app.iop.update', $iop) }}" method="POST" class="row g-3">
          @csrf
          @method('PUT')
          <input type="hidden" name="patient_id" value="{{ $patient }}">
          <table class="table table-striped">
            <thead class="table-dark">
            <th></th>
            <th>RIGHT EYE (RE)</th>
            <th>LEFT EYE (LE)</th>
            </thead>
            <tbody>
            <tr>
              <td width="50%">Non-Contact</td>
              <td><input type="text" name="right" value="{{$iop->right ?? ""}}" class="form-control"></td>
              <td><input type="text" name="left" value="{{$iop->left ?? "" }}" class="form-control"></td>
            </tr>
            </tbody>
          </table>
          <div class="col-12 text-center">
            <button type="submit" class="btn btn-primary me-sm-3 me-1">Update</button>
            <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                    aria-label="Close">Cancel</button>
          </div>
        </form>
