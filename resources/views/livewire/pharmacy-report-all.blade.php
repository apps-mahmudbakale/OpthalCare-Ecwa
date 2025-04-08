<div>
  <div class="card">
    <!-- .card-header -->
    <div class="card-header">
      <form class="filterForm d-flex justify-content-between">
        <input type="hidden" name="csrfmiddlewaretoken" value="eoQrrh0Fb3gbr530oE9TjFkVXLzmi3JCpxp9wiyIrTrQgXea5Ju003GxGWMO5rHg">
        <div class="form-group flex-fill ml-2-">
          <label class="mb-0" for="location_id">Filter By Location</label>
          <select id="location_id" wire:model="store_id" name="store_id" class="custom-select form-control filter">
            <option value="">- All -</option>
            @foreach(\App\Models\DrugStore::all() as $store)
            <option value="{{$store->id}}">{{$store->name}}</option>
            @endforeach
          </select>
        </div>

        <div class="form-group flex-fill- ml-3 no-label">
          <button class="btn btn-primary mt-4 px-3" wire:click="export" type="button" id="export-btn">
            <i class="fa fa-download"></i> Export to File
          </button>
        </div>
      </form>
    </div><!-- /.card-header -->
    <!-- .table-responsive -->
    <div class="table-responsive">
      <!-- .table -->
      <table class="table table-sm- table-striped">
        <!-- thead -->
        <thead>
        <tr>
          <th>Drug/Generic</th>
          <th class="text-right">Quantity</th>
        </tr>
        </thead>
        <tbody>
        <!-- tr -->
      @foreach($all as $drug)
        <tr>
          <td class="align-middle">{{$drug->name}}</td>
          <td class="text-right">{{$drug->quantity}}</td>
        </tr>
      @endforeach

        </tbody><!-- /tbody -->
      </table><!-- /.table -->
      <div class="d-flex justify-content-center mt-3">
        {{ $all->links() }}
      </div>
    </div>
  </div>
</div>
