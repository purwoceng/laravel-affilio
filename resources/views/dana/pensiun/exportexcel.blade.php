<table class="table-all" border="1">
    <thead>
        <tr>
            <th>No</th>
            <th>Username</th>
            <th>Status</th>
            <th>Kode</th>
            <th>Title</th>
            <th>Value</th>
            <th>Tanggal</th>
        </tr>
    </thead>
    <tbody>
        @php $no = 1; @endphp
        @foreach ($pensiuns as $pensiun)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $pensiun->username }}</td>
                <td>{{ $pensiun->status }}</td>
                <td>{{ $pensiun->code }}</td>
                <td>{{ $pensiun->title }}</td>
                <td>Rp. {{ $pensiun->value }}</td>
                <td>{{ $pensiun->created_at }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
