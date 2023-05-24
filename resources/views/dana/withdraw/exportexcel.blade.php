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
        @foreach ($withdraws as $withdraw)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $withdraw->username }}</td>
                <td>{{ $withdraw->status }}</td>
                <td>{{ $withdraw->code }}</td>
                <td>{{ $withdraw->title }}</td>
                <td>Rp. {{ $withdraw->value }}</td>
                <td>{{ $withdraw->created_at }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
