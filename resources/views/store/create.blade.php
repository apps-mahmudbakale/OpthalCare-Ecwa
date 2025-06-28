@extends('layouts/layoutMaster')

@section('title', 'Pharmacy')

@section('vendor-style')
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
@endsection

@section('content')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<div class="card">
  <div class="px-3 py-4">
    <div class="text-center mb-4">
      <h3 class="mb-2">Request Drugs From Store</h3>
    </div>

    <form id="drug-request-form" action="{{ route('app.store-request.store') }}" method="POST">
      @csrf
      <div id="drug-request-container">
        <div class="drug-request-group border rounded p-3 mb-3">
          <div class="form-group mb-2">
            <label>Store</label>
            <select name="store_id[]" class="form-control store-select" required>
              <option value="">Choose...</option>
              @foreach(\App\Models\DrugStore::all() as $store)
              <option value="{{ $store->id }}">{{ $store->name }}</option>
              @endforeach
            </select>
          </div>

          <div class="form-group mb-2">
            <label>Category</label>
            <select name="category_id[]" class="form-control category-select" required>
              <option value="">Choose...</option>
              @foreach(\App\Models\DrugCategory::all() as $category)
              <option value="{{ $category->id }}">{{ $category->name }}</option>
              @endforeach
            </select>
          </div>

          <div class="form-group mb-2">
            <label>Drug</label>
            <select name="drug_id[]" class="form-control drug-select" required>
              <option value="">Choose Drug...</option>
            </select>
          </div>

          <div class="form-group mb-3">
            <label>Required Quantity</label>
            <input name="qty[]" type="number" class="form-control qty-input" placeholder="Enter quantity" required>
            <small class="text-muted stock-info"></small>
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
        <button type="submit" class="btn btn-primary">Submit</button>
        <button type="reset" class="btn btn-secondary">Cancel</button>
      </div>
    </form>
  </div>
</div>

<script>
  $(document).ready(function () {
    // Add new drug request group
    $('#add-drug-request').click(function () {
      const $clone = $('.drug-request-group').first().clone();
      $clone.find('input, select').val('');
      $clone.find('.stock-info').text('');
      $('#drug-request-container').append($clone);
    });

    // Remove a drug request group
    $(document).on('click', '.remove-group', function () {
      if ($('.drug-request-group').length > 1) {
        $(this).closest('.drug-request-group').remove();
      }
    });

    // Load drugs based on store and category
    $(document).on('change', '.store-select, .category-select', function () {
      const $group = $(this).closest('.drug-request-group');
      const storeId = $group.find('.store-select').val();
      const categoryId = $group.find('.category-select').val();
      const $drugSelect = $group.find('.drug-select');

      if (storeId && categoryId) {
        $drugSelect.prop('disabled', true).html('<option>Loading...</option>');

        $.ajax({
          url: "{{ route('get.drugs.by.store') }}",
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
          },
          contentType: 'application/json',
          data: JSON.stringify({
            store_id: storeId,
            category_id: categoryId
          }),
          success: function (data) {
            $drugSelect.empty().append('<option value="">Choose Drug...</option>');
            if (data.length > 0) {
              $.each(data, function (index, drug) {
                $drugSelect.append(`<option value="${drug.id}" data-quantity="${drug.stock || 0}">${drug.name}</option>`);
              });
            } else {
              $drugSelect.append('<option value="">No drugs found</option>');
            }
            $drugSelect.prop('disabled', false);
          },
          error: function () {
            $drugSelect.html('<option value="">Error loading drugs</option>').prop('disabled', false);
          }
        });
      } else {
        $group.find('.drug-select').html('<option value="">Choose Drug...</option>');
      }
    });

    // Update stock info when drug is selected
    $(document).on('change', '.drug-select', function () {
      const $group = $(this).closest('.drug-request-group');
      const stock = $(this).find(':selected').data('quantity') || 0;
      const $qtyInput = $group.find('.qty-input');
      $qtyInput.attr('max', stock);
      $group.find('.stock-info').text(`Max available: ${stock}`);
    });

    // Optionally log inputs for debugging
    $('#drug-request-form').on('submit', function () {
      console.clear();
      console.log("🚀 Submitting Drug Request:");

      $('.drug-request-group').each(function (index) {
        const store = $(this).find('.store-select').val();
        const category = $(this).find('.category-select').val();
        const drug = $(this).find('.drug-select').val();
        const qty = $(this).find('.qty-input').val();

        console.log(`--- Group ${index + 1} ---`);
        console.log('Store ID:', store);
        console.log('Category ID:', category);
        console.log('Drug ID:', drug);
        console.log('Quantity:', qty);
      });
    });
  });
</script>
@endsection
