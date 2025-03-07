<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
<div class="text-center mb-4">
    <h3 class="mb-2">View Prescription</h3>
    <div class="alert alert-primary d-flex align-items-center" role="alert">
        <span class="alert-icon text-primary me-2">
            <i class="ti ti-user ti-xs"></i>
        </span>
        <p class="mt-3 ml-5">{{ $request->patient->user->firstname }} {{ $request->patient->user->firstname }}
          [{{ app(App\Settings\SystemSettings::class)->number_prefix ?: 'HRN' }}{{ $request->patient->hospital_no }}]</p>
    </div>
</div>
<table class="table table-striped">
    <thead class="table-light">
        <th>Drug/Generic</th>
        <th>Dose</th>
        <th>Collected By</th>
    </thead>
    <tbody>
        <tr>
            <td>
                <span class="badge badge-lg bg-primary mb-1">

                    {{ $request->drug->name }}

                </span>
            </td>
            <td>{{ $request->dose }}</td>
            <td>{{ $request->collected_by }}</td>
        </tr>
    </tbody>
</table>
