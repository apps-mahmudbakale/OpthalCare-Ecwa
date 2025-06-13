<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
<div class="text-center mb-4">
  <h3 class="mb-2">New HMO Group</h3>
</div>
<form wire:submit.prevent="updateHmo"  method="POST" class="row g-3">
  @csrf
  <div class="col-12 col-md-12">
    <label class="form-label"> Name</label>
    <input type="text"  name="name" wire:model.prevent="HmoName" class="form-control" placeholder="AXA MANSARD" />
  </div>
  <div class="col-12 col-md-12">
    <label class="form-label"> Email</label>
    <input type="text"  name="email" wire:model.prevent="HmoEmail" class="form-control" placeholder="**@**.com" />
  </div>
  <div class="col-12 col-md-12">
    <label class="form-label"> Phone</label>
    <input type="text"  name="phone" wire:model.prevent="HmoPhone" class="form-control" placeholder="+234*****" />
  </div>
  <div class="col-12 col-md-12">
    <label class="form-label">Address</label>
    <textarea name="address" id="" cols="30" wire:model.prevent="HmoAddress" rows="10" class="form-control"></textarea>
  </div>
  <div class="col-12 text-center">
    <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
    <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
  </div>
</form>
