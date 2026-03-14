<h2 class="text-center">Import HMO Plans</h2>
<form action="{{ route('app.hmo-plans.import.post') }}" method="POST" class="row g-3" enctype="multipart/form-data">
    @csrf
    <div class="col-12 col-md-12">
        <label class="form-label">Upload Excel/CSV File</label>
        <input type="file" name="csv" class="form-control" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required />
        <small class="text-muted mt-1 d-block">Required Columns: Name, HMO Group Name. Optional: Enrollment Amount, Signup Amount, Max Members, Is Insurance.</small>
    </div>
    <div class="col-12 text-center mt-4">
        <button type="submit" class="btn btn-primary me-sm-3 me-1">Import Plans</button>
        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
    </div>
</form>
