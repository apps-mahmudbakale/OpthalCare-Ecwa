<div>
    <table class="table">
        <thead class="thead-light">
            <tr>
                <th></th>
                <th>Date of Visit</th>
                <th>Speciality</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($visits as $visit)
                <tr>
                    <td></td>
                    <td>{{ $visit->created_at->diffForHumans() }}</td>
                    <td>{{ $visit->speciality }}</td>
                    <td>{{ $visit->status }}</td>
                </tr>
            @endforeach
        </tbody>

    </table>
</div>
