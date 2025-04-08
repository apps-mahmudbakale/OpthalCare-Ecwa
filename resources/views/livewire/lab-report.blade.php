<div>
  <div class="card">
    <!-- .card-header -->
    <div class="card-header">
      <form class="filterForm d-flex justify-content-between">
        <input type="hidden" name="csrfmiddlewaretoken" value="j3cQmVrbruQAyVXWdDbt2X1ZKfgYpbXRucLyrWZeHk1fnN86UIwAJlnBtqtqczVv">
        <div class="form-group flex-fill ml-2">
          <label class="mb-0" for="id_category">Filter By Category</label>
          <select wire:model="category_id" id="id_category" class="custom-select form-control">
            <option value="">- All -</option>
            @foreach($categories as $category)
            <option value="{{ $category->id }}">{{ strtoupper($category->name) }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group flex-fill ml-2">
          <label class="mb-0" for="id_status">Filter By Request Status</label>
          <select wire:model="status" id="id_status" name="status" class="custom-select form-control filter">
            <option value="">- All -</option>
            <option>Pending</option>
            <option>Specimen Collected</option>
            <option>Result Ready</option>
            <option>Cancelled</option>

          </select>
        </div>
        <div class="form-group flex-fill ml-2">
          <input type="hidden" name="start" class="filter sr-only">
          <input type="hidden" name="stop" class="filter sr-only">
          <label for="reportrange" class="mb-0">Filter By Request Date</label>
          <div id="reportrange" class="form-control d-flex custom-select">
            <i class="mt-1 fa fa-calendar"></i>&nbsp;
            <span class="text-nowrap">11/24/2024 - 11/24/2024</span>
          </div>
        </div>
        <div class="form-group flex-fill- ml-3 no-label">
          <button class="btn btn-primary  px-3" style="margin-top: 1.26rem" type="button" id="export-btn">
            <i class="fa fa-download"></i>
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
          <th>Investigation</th><th>Category</th><th># of Requests</th>
        </tr>
        </thead>
        <tbody>
        <!-- tr -->
        @foreach($labReports as $report)
        <tr>
          <td>{{$report->test->name}}</td>
          <td>{{$report->test->category->name}}</td>
          <td>{{ $report->request_count }}</td>
        </tr>
        @endforeach
        </tbody><!-- /tbody -->
      </table><!-- /.table -->
      <hr class="my-2">


      <div class="d-flex justify-content-around">

        <ul class="pagination">

          <li class="page-item disabled">
            <a class="page-link" href="javascript:"><span class="oi oi-arrow-left"></span> Previous</a>
          </li>


          <li class="page-item active">

            <span class="page-link" href="javascript:"> 1 - 10 of 623</span>
          </li>


          <li class="page-item">
            <a class="page-link" href="javascript:" data-page="2" data-href="?page=2">Next <span class="oi oi-arrow-right"></span></a>
          </li>

        </ul>
        <input type="hidden" class="sr-only filter" name="page" value="1">

      </div>


    </div><!-- /.table-responsive -->
  </div>
</div>
