<div class="modal fade" id="new-lab-template" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-simple modal-edit-user">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                <div class="text-center mb-4">
                    <h3 class="mb-2">New Lab Template</h3>
                </div>
              @php
                function auto_fill() {
                  $output ='';
                  $parameters = \App\Models\LabParameter::all();

                  foreach($parameters as $parameter){
                    $output .= '<option value='.$parameter->id.'>'.$parameter->name.'</option>';
                  }

                  return $output;
                }
              @endphp
                <form action="{{ route('app.lab-template.store') }}" method="POST" class="row g-3">
                    @csrf

                    <div class="col-12 col-md-12">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Laboratory Test Category"
                            required>
                    </div>

                    <div class="col-12 table-responsive">
                      <table class="table table-bordered" id="item_table">
                        <tr>
                          <th>Parameter</th>
                          <th>Reference</th>
                          <th><button type="button" name="add" class="btn btn-success btn-sm  add">
                              <i class="fa fa-plus-circle"></i>
                            </button></th>
                        </tr>
                      </table>
                    </div>
                    <div class="col-12 text-center mt-3">
                        <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
                        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script>
  $(document).ready(function(){
    $(document).on('click', '.add', function(){
      var html = '';
      html +='<tr>';
      html +='<td><select name="parameters[]" class="form-control parameter"><option value="">Select Parameter...</option><?php echo auto_fill();?></select></td>';
      html +='<td><input class="form-control reference" type="text" name="references[]" placeholder="Reference"> </td>';
      html += '<td><button type="button" name="remove" class="btn btn-danger btn-sm  remove"><i class="fa fa-minus-circle"></i></button></td>';
      $('#item_table').append(html);
    });

    $(document).on('click', '.remove', function(){
      $(this).closest('tr').remove();
    });
  });
</script>
