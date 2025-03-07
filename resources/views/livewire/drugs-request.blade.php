<div>
    <table class="table">
        <thead class="thead-light">
            <tr>
                <th>Date of Request</th>
                <th>Drug/Generic</th>
                <th>User</th>
                <th>Status</th>
                <th>---</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($requests as $request)
                <tr>
                    <td>{{ $request->created_at->diffForHumans() }}</td>
                    <td>{{ $request->drug->name }}</td>
                    <td>{{ $request->user->firstname . ' ' . $request->user->latstname }}</td>
                    <td>{{ $request->status }}</td>
                    <td></td>
                </tr>
            @endforeach
        </tbody>

    </table>
</div>
