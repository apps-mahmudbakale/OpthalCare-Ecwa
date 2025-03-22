<div class="modal fade" id="modal-lg">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">System Settings</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('app.update.system.settings') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        Clinic Name
                        <input type="text" name="clinic_name" value="{{ $system->clinic_name }}"
                            class="form-control">
                    </div>
                    <div class="form-group">
                        Clinic Logo
                        <input type="file" name="logo" value="" class="form-control">
                    </div>
                    <div class="form-group">
                        Clinic Logo
                        <input type="file" name="favicon" value="" class="form-control">
                    </div>
                    <div class="form-group">
                        Address
                        <textarea class="form-control" rows="10" name="address">{{ $system->address }}</textarea>
                    </div>
                    <div class="form-group">
                        Footer
                        <input type="text" class="form-control" name="footer" value="{{ $system->footer }}">
                    </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>