<table class="table-all" border="1">
    <thead>
        <tr>
            <th>No</th>
            <th>Order Kode</th>
            <th>Order Kode Baleo</th>
            <th>Username</th>
            <th>Nama Penerima</th>
            <th>Nomor Resi</th>
            <th>Ongkir</th>
            <th>Komisi Affiliasi Produk</th>
            <th>Harga</th>
            <th>Sub Total</th>
            <th>Total</th>
            <th>Nomor HP</th>
            <th>Alamat</th>
            <th>Status Baleo</th>
            <th>Status</th>
            <th>Kurir</th>
            <th>Tanggal Pemesanan</th>
            <th>Tanggal Pembayaran</th>
        </tr>
    </thead>
    <tbody>
        @php $no = 1; @endphp
        @foreach ($orders as $order)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $order->code }}</td>
                <td>{{ $order->baleo_order_code }}</td>
                <td>{{ $order->username }}</td>
                <td>{{ $order->customer_name }}</td>
                <td>{{ $order->resi }}</td>
                <td>{{ $order->shipping_cost }}</td>
                <td>{{ $order->fee }}</td>
                <td>{{ $order->affilio_subtotal }}</td>
                <td>{{ $order->subtotal }}</td>
                <td>{{ $order->total }}</td>
                <td>{{ $order->phone }}</td>
                <td>{{ $order->address }}</td>
                <td>{{ $order->baleomol_status }}</td>
                <td>{{ $order->status }}</td>
                <td>{{ $order->shipping_courier }}-{{ $order->shipping_service }}</td>
                <td>{{ $order->date_created }}</td>
                <td>{{ $order->date_paid }}</td>

            </tr>
        @endforeach
    </tbody>

</table>
