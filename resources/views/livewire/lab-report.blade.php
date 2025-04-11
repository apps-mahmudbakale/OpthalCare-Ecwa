<div>
  <div class="card">
    <!-- Filter Header -->
    <div class="card-header">
      <form class="filterForm d-flex justify-content-between align-items-end flex-wrap">
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
          <select wire:model="status" id="id_status" class="custom-select form-control">
            <option value="">- All -</option>
            <option value="Pending">Pending</option>
            <option value="Specimen Collected">Specimen Collected</option>
            <option value="Result Ready">Result Ready</option>
            <option value="Cancelled">Cancelled</option>
          </select>
        </div>

        <div class="form-group flex-fill ml-2">
          <label class="mb-0">Start Date</label>
          <input wire:model="startDate" type="date" class="form-control">
        </div>

        <!-- End Date -->
        <div class="form-group flex-fill ml-2">
          <label class="mb-0">End Date</label>
          <input wire:model="endDate" type="date" class="form-control">
        </div>

        <div class="form-group flex-fill ml-2 no-label">
          <button wire:click="export" class="btn btn-primary px-3 mt-4" type="button" id="export-btn">
            <i class="fa fa-download"></i>
          </button>
        </div>
      </form>
    </div><!-- /.card-header -->

    <!-- Table -->
    <div class="table-responsive">
      <table class="table table-sm table-striped">
        <thead>
        <tr>
          <th>Investigation</th>
          <th>Category</th>
          <th># of Requests</th>
        </tr>
        </thead>
        <tbody>
        @forelse($labReports as $report)
        <tr>
          <td>{{ $report->test->name }}</td>
          <td>{{ $report->test->category->name }}</td>
          <td>{{ $report->request_count }}</td>
        </tr>
        @empty
        <tr>
          <td colspan="3" class="text-center">No lab reports found.</td>
        </tr>
        @endforelse
        </tbody>
      </table>

      <!-- Pagination -->
      <div class="d-flex justify-content-between align-items-center px-3 py-2">
        <div>
          Showing {{ $labReports->firstItem() }} to {{ $labReports->lastItem() }} of {{ $labReports->total() }} entries
        </div>
        <div>
          {{ $labReports->links() }}
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  $(function () {
    $('#daterange').daterangepicker({
      opens: 'left'
    }, function (start, end, label) {
      console.log("Selected date range: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
    });
  });
</script>
