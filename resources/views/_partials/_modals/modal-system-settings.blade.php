<!-- Edit User Modal -->
<div class="modal fade" id="editSystem" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-simple modal-edit-user">
    <div class="modal-content p-3 p-md-5">
      <div class="modal-body">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="text-center mb-4">
          <h3 class="mb-2">System Settings/Information</h3>
        </div>
        <form action="{{ route('app.update.system.settings') }}" method="POST" enctype="multipart/form-data" class="row g-3">
            @csrf
          <div class="col-12 col-md-12">
            <label class="form-label" for="modalEditUserFirstName">Clinic Name</label>
            <input type="text" value="{{ $system->clinic_name }}" name="clinic_name" class="form-control" placeholder="St. Paul Hospital" />
          </div>
          <div class="col-12 col-md-12">
            <label class="form-label" for="modalEditUserLastName">Clinic Logo</label>
            <input type="file" name="logo" class="form-control" placeholder="Doe" />
          </div>
          <div class="col-12">
            <label class="form-label" for="modalEditUserName">Clinic Favicon</label>
            <input type="file" id="modalEditUserName" name="favicon" class="form-control" placeholder="john.doe.007" />
          </div>
          <div class="col-12 col-md-12">
            <label class="form-label" for="modalEditUserEmail">Address</label>
            <textarea name="address" id="" cols="30" rows="10" class="form-control">{{ $system->address }}</textarea>
          </div>
          <div class="col-12 col-md-12">
            <label class="form-label" for="modalEditUserStatus">Footer</label>
            <input type="text" value="{{$system->footer}}" name="footer" class="form-control">
          </div>
          <div class="col-12 text-center">
            <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
            <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!--/ Edit User Modal -->
