<h1>Daftar Produk</h1>
<span>Tanggal Print: {{ date('d/m/Y') }}</span><br>
<span>Waktu Print: {{date('H:i:s') }}</span><br>
<table width="100%" border="1" cellpadding="5" cellspacing="0">
<tr>
    <th>Nama Produk</th>
    <th>Harga Produk</th>
    <th>Kategori</th>
    <th>Tanggal Masuk</th>
</tr>
@foreach ($productsM as $products)
<tr>
    <td>{{ $products->nama_produk }}</td>
    <td>Rp.{{number_format ($products->harga_produk) }}</td>
    <td>{{ $products->kategori }}</td>
    <td>{{ $products->created_at }}</td>
</tr>
@endforeach
</table>