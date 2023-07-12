<table class="table-all" border="1">
    <thead>
        <tr>
            <th><b>No</b></th>
            <th><b>Username</b></th>
            <th><b>Email</b></th>
            <th><b>Kode</b></th>
            <th><b>Title</b></th>
            <th><b>Value</b></th>
            <th><b>Pajak 6%</b></th>
            <th><b>Jumlah Transfer</b></th>
            <th><b>Verifikasi Transfer Penarikan</b></th>
            <th><b>Tanggal</b></th>
        </tr>
    </thead>
    <tbody>
        @php $no = 1; @endphp
        @foreach ($withdraws as $withdraw)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $withdraw->username }}</td>
                <td>{{ $withdraw->members->email ?? '-' }}</td>
                <td>{{ $withdraw->code }}</td>
                <td>{{ $withdraw->title }}</td>
                <td>{{ $withdraw->value }}</td>
                <td>{{ ($withdraw->value) * 6/100}}</td>
                <td>{{($withdraw->value - ($withdraw->value) * 6/100)}}</td>
                @if($withdraw->publish == '1')
                    <td>Sukses</td>
                @else
                    <td>Menunggu Konfirmasi</td>
                @endif
                <td>{{ $withdraw->created_at }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
