<h1>Daftar Transaksi</h1>
<span>Tanggal Print: {{ date('d/m/Y') }}</span><br>
<span>Waktu Print: {{date('H:i:s') }}</span><br>
<table width="100%" border="1" cellpadding="5" cellspacing="0">
    <tr>
      <th>No</th>
      <th>Nomor Unik</th>
      <th>Nama Pelanggan</th>
      <th>Nama Produk</th>
      <th>Harga Produk</th>
      <th>Total Beli</th>
      <th>Total Harga</th>
      <th>Uang Bayar</th>
      <th>Uang Kembali</th>
      <th>Tanggal</th>
    </tr>
    @foreach ($transactionsM as $key => $transactions)
    <tr>
      <td>{{ $key + 1}}</td>
      <td>{{ $transactions->nomor_unik }}</td>
      <td>{{ $transactions->nama_pelanggan }}</td>
      <td>{{ $transactions->nama_produk }}</td>
      <td>Rp.{{number_format ($transactions->harga_produk) }}</td>
      <td>{{ $transactions->qty }} KG</td>
      <td>Rp.{{number_format ($transactions->total_harga) }}</td>
      <td>Rp.{{number_format ($transactions->uang_bayar) }}</td>
      <td>Rp.{{number_format ($transactions->uang_kembali) }}</td>
      <td>{{ $transactions->createtrans }}</td> 
    </tr>    
    @endforeach
  </table>