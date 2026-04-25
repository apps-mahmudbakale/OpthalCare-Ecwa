<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

<div class="text-center mb-4">
  <h3 class="mb-2">Update Laboratory Template</h3>
</div>

@php
  // Load parameters once
  $parameters = \App\Models\LabParameter::all();
  
  function auto_fill_edit() {
    $output ='';
    $parameters = \App\Models\LabParameter::all();
    
    foreach($parameters as $parameter){
      $output .= '<option value='.$parameter->id.'>'.$parameter->name.'</option>';
    }
    
    return $output;
  }
@endphp

<form action="{{ route('app.lab-template.update', $template->id) }}" method="POST" class="row g-3" id="edit_template_form">
  @csrf
  @method('PUT')
  
  <div class="col-12">
    <label for="template_name" class="form-label">Name</label>
    <input type="text" 
           id="template_name"
           name="name" 
           value="{{ old('name', $template->name) }}" 
           class="form-control"
           required>
  </div>
  
  <div class="col-12 table-responsive">
    <table class="table table-bordered" id="edit_item_table">
      <thead>
        <tr>
          <th>Parameter</th>
          <th>Reference</th>
          <th>
            <button type="button" name="add" class="btn btn-success btn-sm add-edit-row">
              <i class="fa fa-plus-circle"></i>
            </button>
          </th>
        </tr>
      </thead>
      <tbody>
        {{-- Load existing rows --}}
        @foreach ($template->items as $item)
          <tr>
            <td>
              <input type="hidden" name="item_ids[]" value="{{ $item->id }}">
              <select name="parameters[]" class="form-control parameter">
                <option value="">Select Parameter...</option>
                @foreach ($parameters as $param)
                  <option value="{{ $param->id }}"
                    {{ $param->id == $item->lab_parameter_id ? 'selected' : '' }}>
                    {{ $param->name }}
                  </option>
                @endforeach
              </select>
            </td>
            <td>
              <input type="text" 
                     class="form-control reference"
                     name="references[]" 
                     value="{{ $item->reference }}"
                     placeholder="Reference">
            </td>
            <td>
              <button type="button" class="btn btn-danger btn-sm remove-edit-row">
                <i class="fa fa-minus-circle"></i>
              </button>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  
  <div class="col-12 text-center mt-3">
    <button type="submit" class="btn btn-primary me-sm-3 me-1">
      <i class="ti ti-check me-1"></i> Update Template
    </button>
    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
      <i class="ti ti-x me-1"></i> Cancel
    </button>
  </div>
</form>

<script>
  $(document).ready(function(){
    // Add new row
    $(document).on('click', '.add-edit-row', function(){
      var html = '';
      html +='<tr>';
      html +='<td><select name="parameters[]" class="form-control parameter"><option value="">Select Parameter...</option><?php echo auto_fill_edit();?></select></td>';
      html +='<td><input class="form-control reference" type="text" name="references[]" placeholder="Reference"> </td>';
      html += '<td><button type="button" class="btn btn-danger btn-sm remove-edit-row"><i class="fa fa-minus-circle"></i></button></td>';
      html += '</tr>';
      
      $('#edit_item_table tbody').append(html);
    });
    
    // Remove row
    $(document).on('click', '.remove-edit-row', function(){
      $(this).closest('tr').remove();
    });
    
    // Handle form submission via AJAX
    $('#edit_template_form').on('submit', function(e) {
      e.preventDefault();
      
      var formData = $(this).serialize();
      var actionUrl = $(this).attr('action');
      
      $.ajax({
        url: actionUrl,
        type: 'POST',
        data: formData,
        success: function(response) {
          $('#global-modal').modal('hide');
          
          Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: 'Template updated successfully!',
            timer: 2000
          }).then(() => {
            location.reload();
          });
        },
        error: function(xhr) {
          var message = xhr.responseJSON?.message || 'Failed to update template.';
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: message
          });
        }
      });
    });
  });
</script>
