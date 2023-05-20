
<table class="table-all" border="1">
    <thead>
        <tr>
            <th>No</th>
            <th>Username</th>
            <th>Status</th>
            <th>Kode Penarikan</th>
            <th>Title</th>
            <th>Value</th>
            <th>Tanggal</th>
        </tr>
    </thead>
    <tbody>
        @php $no = 1; @endphp
        @foreach ($funds as $fund)
        <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $fund->username}}</td>
            <td>{{ $fund->status}}</td>
            <td>{{ $fund->code}}</td>
            <td>{{ $fund->is_active}}</td>
            <td>{{ $fund->title}}</td>
            <td>Rp. {{ $fund->value}}</td>
            <td>{{ $fund->created_at}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
