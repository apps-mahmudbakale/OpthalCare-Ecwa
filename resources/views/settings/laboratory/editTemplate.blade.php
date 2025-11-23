@extends('layouts/layoutMaster')

@section('title', 'Edit Procedure Category')

@section('vendor-style')
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
@endsection

@section('vendor-script')
  <script src="{{ asset('assets/vendor/libs/cleavejs/cleave.js') }}"></script>
  <script src="{{ asset('assets/vendor/libs/cleavejs/cleave-phone.js') }}"></script>
  <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
  <script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
  <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection

@section('page-script')
  <script src="{{ asset('assets/js/form-layouts.js') }}"></script>
@endsection

@section('content')
  <h4 class="fw-bold py-3 mb-4">
    <span class="text-muted fw-light">Laboratory Test Settings</span>
  </h4>

  @php
    // Load parameters once
    $parameters = \App\Models\LabParameter::all();
  @endphp

  <div class="row">
    <div class="col-12 mb-4">
      <div class="card">
        <div class="card-header">
          <h5 class="mb-0">Update Laboratory Template</h5>
        </div>

        <div class="card-body">
          <form action="{{ route('app.lab-template.update', $template->id) }}" method="POST" class="row g-3" id="insert_form">
            @csrf
            @method('PUT')
            <div class="form-group">
              <label for="">Name</label>
              <input type="text" name="name" value="{{old('name', isset($template) ? $template->name : '')}}" class="form-control">
            </div>
            <div class="col-12 table-responsive">
              <table class="table table-bordered" id="item_table">
                <tr>
                  <th>Parameter</th>
                  <th>Reference</th>
                  <th>
                    <button type="button" name="add" class="btn btn-success btn-sm add">
                      <i class="fa fa-plus-circle"></i>
                    </button>
                  </th>
                </tr>

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
                      <input type="text" class="form-control reference"
                             name="references[]" value="{{ $item->reference }}">
                    </td>

                    <td>
                      <button type="button" class="btn btn-danger btn-sm remove">
                        <i class="fa fa-minus-circle"></i>
                      </button>
                    </td>
                  </tr>
                @endforeach

              </table>
            </div>

            <div class="col-12">
              <button type="submit" class="btn btn-primary">Update Template</button>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>

  <script>
    $(document).ready(function(){
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
      // Add new row
      $(document).on('click', '.add', function(){
        var html = '';
        html +='<tr>';
        html +='<td><select name="parameters[]" class="form-control parameter"><option value="">Select Parameter...</option><?php echo auto_fill();?></select></td>';
        html +='<td><input class="form-control reference" type="text" name="references[]" placeholder="Reference"> </td>';
        html += '<td><button type="button" name="remove" class="btn btn-danger btn-sm  remove"><i class="fa fa-minus-circle"></i></button></td>';

        $('#item_table').append(html);
      });

      // Remove row
      $(document).on('click', '.remove', function(){
        $(this).closest('tr').remove();
      });

    });
  </script>
@endsection
