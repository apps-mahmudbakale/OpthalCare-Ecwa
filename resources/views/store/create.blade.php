@extends('layouts/layoutMaster')

@section('title', 'Pharmacy')

@section('vendor-style')
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/editor.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/css/theme.css') }}" />
@endsection

@section('page-style')
<link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/app-calendar.css') }}" />
@endsection

@section('vendor-script')
<script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
@endsection

@section('page-script')
<script src="{{ asset('assets/js/app-calendar.js') }}"></script>
@endsection

@section('content')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<div class="card">
  <div class="px-3 py-4">
    <div class="text-center mb-4">
      <h3 class="mb-2">Request Drugs From Store</h3>
    </div>

    <form action="{{ route('app.payments.new-enroll') }}" method="POST">
      @csrf

      <div id="drug-request-container">
        <div class="drug-request-group border rounded p-3 mb-3">
          <div class="form-group mb-2">
            <label>Store</label>
            <select name="store_id[]" class="custom-select form-control" required>
              <option value="">Choose...</option>
                @foreach(\App\Models\DrugStore::all() as $store)
                  <option value="{{$store->id}}">{{$store->name}}</option>
                @endforeach
            </select>
          </div>

          <div class="form-group mb-2">
            <label>Category</label>
            <select name="category_id[]" class="custom-select category-select form-control" required>
              <option value="">Choose...</option>
              @foreach(\App\Models\DrugCategory::all() as $category)
              <option value="{{$category->id}}">{{$category->name}}</option>
              @endforeach
            </select>
          </div>

          <div class="form-group mb-2">
            <label>Drug</label>
            <select name="drug_id[]" class="custom-select form-control" required>
              <option value="">Choose...</option>
              {{-- Add drug options --}}
              <option value="1">Paracetamol</option>
              <option value="2">Amoxicillin</option>
            </select>
          </div>

          <div class="form-group mb-3">
            <label>Required Quantity</label>
            <input name="qty[]" type="number" class="form-control" required placeholder="Enter quantity">
          </div>

          <div class="text-end">
            <button type="button" class="btn btn-danger btn-sm remove-group">Remove</button>
          </div>
        </div>
      </div>

      <div class="mb-3 text-center">
        <button type="button" class="btn btn-outline-primary" id="add-drug-request">Add Another Drug</button>
      </div>

      <div class="text-center">
        <button type="submit" class="btn btn-primary me-2">Submit</button>
        <button type="reset" class="btn btn-secondary">Cancel</button>
      </div>
    </form>
  </div>
</div>

<script>
  $(document).ready(function () {
    $('#add-drug-request').click(function () {
      let clone = $('.drug-request-group').first().clone();
      clone.find('input, select').val(''); // Clear values
      $('#drug-request-container').append(clone);
    });

    $(document).on('click', '.remove-group', function () {
      if ($('.drug-request-group').length > 1) {
        $(this).closest('.drug-request-group').remove();
      }
    });

    const storeId = $('.store-select').val();
    const categoryId = $('.category-select').val();
    const $drugSelect = $('.drug-select');
    // Fetch drugs when both store and category are selected
    $(document).on('change', '.category-select', function() {
      if (storeId && categoryId) {
        function fetchDrugs($group) {
          const storeId = $group.find('.store-select').val();
          const categoryId = $group.find('.category-select').val();
          const $drugSelect = $group.find('.drug-select');

          if (storeId && categoryId) {
            $.ajax({
              url: '/getDrugsbyStore',
              type: 'POST',
              contentType: 'application/json',
              data: JSON.stringify({
                store_id: storeId,
                category_id: categoryId,
                _token: '{{ csrf_token() }}'
              }),
              success: function (data) {
                $drugSelect.empty().append('<option value="">Choose Drug...</option>');
                if (data.length > 0) {
                  $.each(data, function (index, drug) {
                    $drugSelect.append(`<option value="${drug.id}">${drug.name}</option>`);
                  });
                } else {
                  $drugSelect.append('<option value="">No drugs available</option>');
                }
              }
            });
          } else {
            $drugSelect.html('<option value="">Choose Drug...</option>');
          }
      }
    })

  });
</script>
@endsection
