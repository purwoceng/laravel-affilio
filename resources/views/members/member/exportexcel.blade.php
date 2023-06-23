<table class="table-all" border="1">
    <thead>
        <tr><center>
            <th><b>No</b></th>
            <th><b>Username</b></th>
            <th><b>Nama</b></th>
            <th><b>Tipe Member</b></th>
            <th><b>Referral</b></th>
            <th><b>No. HP</b></th>
            <th><b>Email</b></th>
            <th><b>Kota</b></th>
            <th><b>Provinsi</b></th>
        </center></tr>
    </thead>
    <tbody>
        @php $no = 1; @endphp
        @foreach ($members as $member)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $member->username }}</td>
                <td>{{ $member->name }}</td>
                <td>{{ $member->member_type->type }}</td>
                <td>{{ $member->referral }}</td>
                <td>{{ $member->phone }}</td>
                <td>{{ $member->email }}</td>
                <td>{{ $member->member_addresses->city_name ?? '-'}}</td>
                <td>{{ $member->member_addresses->province_name ?? '-'}}</td>
            </tr>
        @endforeach
    </tbody>
</table>
