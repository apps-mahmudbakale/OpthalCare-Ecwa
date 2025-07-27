<table>
  <thead>
  <tr>
    <th>Name</th>
    <th>Price</th>
    <th>Quantity</th>
    <th>Dispense Quantity</th>
  </tr>
  </thead>
  <tbody>
  @foreach ($antenatals as $antenatal)
  <tr>
    <td>{{ $antenatal->name }}</td>
    <td>{{ $antenatal->price }}</td>
    <td>{{ $antenatal->qty }}</td>
    <td>{{ $antenatal->dispense_qty }}</td>
  </tr>
  @endforeach
  </tbody>
</table>
