@php
use App\Models\Patient;
use App\Models\Admission;

$patientId = null;
$route = request()->route();

if ($route) {
    if ($route->parameter('patient')) {
        $param = $route->parameter('patient');
        $patientId = is_object($param) ? $param->id : $param;
    } elseif ($route->parameter('admission')) {
        $param = $route->parameter('admission');
        $admission = is_object($param) ? $param : Admission::find($param);
        $patientId = $admission?->patient_id;
    }
}

$patient = Patient::find($patientId);
$user = $patient?->user;
@endphp

<!-- Edit User Modal -->
<div wire:ignore.self class="modal fade" id="new-documents-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-simple modal-edit-user">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-4">
                    <h3 class="mb-2">New Documents for
                        {{ $user->firstname ?? '' }} {{ $user->lastname ?? '' }}
                    </h3>
                </div>
                <form wire:submit.prevent="updateAntenatal" class="row g-3">

                    
                      <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
                        <a href="{{ $patientId ? route('app.patient.draw', $patientId) : '#' }}" class="btn btn-label-secondary" target="_blank">Draw</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--/ Edit User Modal -->
