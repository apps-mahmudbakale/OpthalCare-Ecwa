<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Category</th>
            <th>Price</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($labs as $lab)
            <tr>
                <td>{{ $lab->name }}</td>
                <td>{{ $lab->category->name }}</td>
                <td>{{ $lab->price }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
