<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
<div class="text-center mb-4">
  <h3 class="mb-2">Import Ophthicals</h3>
  <p class="text-muted">Upload an Excel file to import ophthical items</p>
</div>
<form action="{{ route('app.antenatal.import.post') }}" method="POST" enctype="multipart/form-data" class="row g-3">
  @csrf
  <div class="col-12">
    <label class="form-label">Excel File</label>
    <input type="file" name="csv" class="form-control" accept=".xlsx,.xls,.csv" required />
    <div class="form-text">
      Upload an Excel file with columns: Name, Price, Qty, Dispense_Qty
    </div>
  </div>
  <div class="col-12 text-center">
    <button type="submit" class="btn btn-primary me-sm-3 me-1">Import</button>
    <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
            aria-label="Close">Cancel</button>
  </div>
</form>
