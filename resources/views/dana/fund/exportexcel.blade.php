
<table class="table-all" border="1">
    <thead>
        <tr>
            <th>No</th>
            <th>Kode Order</th>
            <th>Username</th>
            <th>Status</th>
            <th>Kode Penarikan</th>
            <th>Status Bonus Dana</th>
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
            <td>{{ $fund->order_code}}</td>
            <td>{{ $fund->username}}</td>
            <td>{{ $fund->status}}</td>
            <td>{{ $fund->code}}</td>
            {{-- <td>{{ $fund->is_active}}</td> --}}
            @if($fund->is_active == '1')
                <td>Bonus</td>
            @else
                <td>Calon Bonus</td>
            @endif
            <td>{{ $fund->title}}</td>
            <td>{{ $fund->value}}</td>
            <td>{{ $fund->created_at}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
