<h2 class="text-center">Import ICD</h2>
<form action="{{ route('app.import-icd10') }}" method="POST" class="row g-3" enctype="multipart/form-data">
  @csrf
  <div class="col-12 col-md-12">
    <label class="form-label"> Csv</label>
    <input type="file" name="csv" class="form-control" placeholder="ICD Csv" />
  </div>
  <div class="col-12 text-center">
    <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
    <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
            aria-label="Close">Cancel</button>
  </div>
</form>
