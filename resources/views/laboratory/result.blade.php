<div class="text-center mb-4">
  <h3 class="mb-2">Add Lab Result</h3>
</div>
{{dd($labRequest)}}
<form method="post" action="" class="row g-3">
  @csrf
  <div class="col-12 col-md-12">
    <label class="form-label"> Result</label>
    <textarea name="" class="form-control" id="" cols="30" rows="10"></textarea>
  </div>
  <div class="col-12 text-center">
    <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
    <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
            aria-label="Close">Cancel</button>
  </div>
</form>
