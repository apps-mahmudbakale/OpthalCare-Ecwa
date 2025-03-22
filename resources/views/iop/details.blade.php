<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
<div class="text-center mb-4">
    <h3 class="mb-2">Intra Ocular Pressure Chart for {{ $iOP->patient->user->firstname }}
        {{ $iOP->patient->user->lastname }}</h3>
    <p>Recorded on {{ $iOP->created_at->diffForHumans() }}
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
            <td width="50%">Non-Contact</td>
            <td>{{ $iOP->right }}</td>
            <td>{{ $iOP->left }}</td>
        </tr>

    </tbody>
</table>
