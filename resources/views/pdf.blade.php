<h2>Statistik</h2>
<table>
    <thead>
      <tr>
          <th>Kategorie</th>
          <th>Tag</th>
          <th>Woche</th>
          <th>Monat</th>
          <th>Jahr</th>
          <th>Gesamt</th>
      </tr>
    </thead>
    <tbody>
        <tr>
          <td>Bestellungen</td>
            @foreach($stats[0] as $key => $value)
                <td>{{$value}}</td>
            @endforeach
        </tr>
        <tr>
          <td>Umsatz</td>
            @foreach($stats[1] as $key => $value)
                <td>{{$value}}</td>
            @endforeach
        </tr>
        <tr>
          <td>Kunden</td>
            @foreach($stats[2] as $key => $value)
                <td>{{$value}}</td>
            @endforeach
        </tr>
    </tbody>
</table>
