<table class="table-all" border="1">
    <thead>
        <tr>
            <th>No</th>
            <th>Username</th>
            <th>Nama</th>
            <th>Tipe Member</th>
            <th>Referral</th>
            <th>No. HP</th>
            <th>Email</th>
            {{-- <th>Kota</th>
            <th>Provinsi</th> --}}
        </tr>
    </thead>
    <tbody>
        @php $no = 1; @endphp
        @foreach ($members as $member)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $member->username }}</td>
                <td>{{ $member->name }}</td>
                <td>{{ $member->member_type_id }}</td>
                <td>{{ $member->referral }}</td>
                <td>{{ $member->phone }}</td>
                <td>{{ $member->email }}</td>
                {{-- <td>{{ $member->city_name }}</td>
                <td>{{ $member->province_name }}</td> --}}
            </tr>
        @endforeach
    </tbody>
</table>
