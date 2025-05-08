<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
<div class="text-center mb-4">
    <h3 class="mb-2">View Prescription</h3>
    <div class="alert alert-primary d-flex align-items-center" role="alert">
        <span class="alert-icon text-primary me-2">
            <i class="ti ti-user ti-xs"></i>
        </span>
      @php
      $firstRequest = $requests->first();
      $patient = $firstRequest?->patient;
      $user = $patient?->user;
      $hospitalNo = $patient?->hospital_no;
      $prefix = app(App\Settings\SystemSettings::class)->number_prefix ?? 'HRN';
      @endphp

      @if($user && $hospitalNo)
      <p class="mt-3 ml-5">
        {{ $user->firstname }} {{ $user->lastname }}
        [{{ $prefix }}{{ $hospitalNo }}]
      </p>
      @else
      <p class="mt-3 ml-5 text-red-500">Patient information not available.</p>
      @endif

    </div>
</div>
<table class="table table-striped">
    <thead class="table-light">
        <th>Drug/Generic</th>
        <th>QTY</th>
        <th>Dose</th>
        <th>Collected By</th>
    </thead>
    <tbody>
    @foreach($requests as $request)
    @if(is_object($request))
    <tr>
      <td>
                <span class="badge badge-lg bg-primary mb-1">
                    {{ $request->drug?->name ?? 'N/A' }}
                </span>
      </td>
      <td>{{ $request->qty ?? 'N/A' }}</td>
      <td>{{ $request->dose ?? 'N/A' }}</td>
      <td>{{ $request->collected_by ?? 'N/A' }}</td>
    </tr>
    @endif
    @endforeach

    </tbody>
</table>
