
<table class="table-all" border="1">
    <thead>
        <tr>
            <th>No</th>
            <th>Username</th>
            <th>Nama</th>
            <th>Nama Bank</th>
            <th>No. Rekening</th>
            <th>Email</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @php $no = 1; @endphp
        @foreach ($membersaccounts as $memberaccount)
        <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $memberaccount->username}}</td>
            <td>{{ $memberaccount->account_name}}</td>
            <td>{{ $memberaccount->bank_name}}</td>
            <td>{{ $memberaccount->account_number}}</td>
            <td>{{ $memberaccount->members->email ?? '-'}}</td>
            @if($memberaccount->publish == '1')
                <td>Verifikasi</td>
            @else
                <td>Belum Verifikasi</td>
            @endif
        </tr>
        @endforeach
    </tbody>
</table>
