<table class="table-all" border="1">
    <thead>
        <tr><h6>
            <th><b>No</b></th>
            <th><b>Order Kode</b></th>
            <th><b>Order Kode Baleo</b></th>
            <th><b>Kode Pembayaran</b></th>
            <th><b>Username</b></th>
            <th><b>Nama Penerima</b></th>
            <th><b>Nomor Resi</b></th>
            <th><b>Ongkir</b></th>
            <th><b>Komisi Affiliasi Produk</b></th>
            <th><b>Harga</b></th>
            <th><b>Sub Total</b></th>
            <th><b>Total</b></th>
            <th><b>Nomor HP</b></th>
            <th><b>Alamat</b></th>
            <th><b>Status Baleo</b></th>
            <th><b>Status</b></th>
            <th><b>Kurir</b></th>
            <th><b>Tanggal Pemesanan</b></th>
            <th><b>Tanggal Pembayaran</b></th>
        </h6></tr>
    </thead>
    <tbody>
        @php $no = 1; @endphp
        @foreach ($orders as $order)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $order->code }}</td>
                <td>{{ $order->baleo_order_code }}</td>
                <td>{{ $order->invoice_code }}</td>
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
