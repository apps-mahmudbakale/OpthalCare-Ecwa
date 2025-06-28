<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

<div class="text-center mb-4">
  <h3 class="mb-2">View Store Request</h3>
</div>

<form action="{{ route('app.store-request.update', 1) }}" method="POST">
  @csrf
  @method('PUT')

  <table class="table table-striped">
    <thead class="table-light">
    <tr>
      <th>Drug/Generic</th>
      <th>Store</th>
      <th>Category</th>
      <th>Qty</th>
      <th>Status</th>
    </tr>
    </thead>
    <tbody>
    @foreach($requests as $request)
    @if(is_object($request))
    <input type="hidden" name="ref" value="{{$request->ref}}">
    <tr>
      {{-- Hidden Inputs for Submission --}}
      <input type="hidden" name="drug_id[]" value="{{ $request->drug?->id }}">
      <input type="hidden" name="store_id[]" value="{{ $request->store?->id }}">
      <input type="hidden" name="category_id[]" value="{{ $request->drug->category?->id }}">
      <input type="hidden" name="qty[]" value="{{ $request->qty }}">

      {{-- Display Data --}}
      <td>
        <span class="badge bg-primary">{{ $request->drug?->name ?? 'N/A' }}</span>
      </td>
      <td>{{ $request->store->name ?? 'N/A' }}</td>
      <td>{{ $request->drug->category->name ?? 'N/A' }}</td>
      <td>{{ $request->qty ?? 'N/A' }}</td>
      <td>{{ $request->status ?? 'N/A' }}</td>
    </tr>
    @endif
    @endforeach
    </tbody>
  </table>
  <div class="mt-3 text-center">
    <button type="submit" class="btn btn-primary">Approve</button>
  </div>
</form>

