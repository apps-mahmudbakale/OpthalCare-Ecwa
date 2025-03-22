<table>
  <thead>
  <tr>
    <th>Name</th>
    <th>Ward</th>
    <th>Price</th>
    <th>Available</th>
  </tr>
  </thead>
  <tbody>
  @foreach ($beds as $bed)
  <tr>
    <td>{{ $bed->name }}</td>
    <td>{{ $bed->ward->name }}</td>
    <td>{{ $bed->price }}</td>
    <td>{{ $bed->available ? 'true' : 'false' }}</td>
  </tr>
  @endforeach
  </tbody>
</table>
