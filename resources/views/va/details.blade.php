<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
<div class="text-center mb-4">
    <h3 class="mb-2">Vision Acuity For {{ $visionAcuity->patient->user->firstname }}
        {{ $visionAcuity->patient->user->lastname }}</h3>
    <p>Recorded on {{ $visionAcuity->created_at->diffForHumans() }}
    <p>
</div>
<table class="table table-striped">
    <thead class="table-light">
        <th></th>
        <th>RIGHT EYE (RE)</th>
        <th>LEFT EYE (LE)</th>
    </thead>
    <tbody>
        <tr>
            <td width="50%">Uncorrected VA</td>
            <td>{{ $visionAcuity->right }}</td>
            <td>{{ $visionAcuity->left }}</td>
        </tr>
        <tr>
            <td width="50%">PINHOLE </td>
            <td>{{ $visionAcuity->right_pinhole }}</td>
            <td>{{ $visionAcuity->left_pinhole }}</td>
        </tr>
        <tr>
            <td width="50%">VA With Glasses</td>
            <td>{{ $visionAcuity->right_glasses }}</td>
            <td>{{ $visionAcuity->left_glasses }}</td>
        </tr>
    </tbody>
</table>
