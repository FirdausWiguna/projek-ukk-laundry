@extends('sbadmin')
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <!-- Page Heading -->
        <h2 class="h3 mb-4 text-gray-800">Halaman Edit Transaksi</h2>
    </div>

    <section class="content">

    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Edit Data Transaksi</h5>
        </div>
        <div class="card-body">
            <a href="{{ route('transactions.index') }}" class="btn btn-secondary">Kembali</a>
            <br><br>

            <form action="{{ route('transactions.update', $transaksi->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div>
                    <label>Nomor Unik</label>
                    <input name="nomor_unik" type="number" class="form-control" value="{{ $transaksi->nomor_unik }}" readonly>
                    @error('nomor_unik')
                    <p>{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label>Nama Pelanggan</label>
                    <input name="nama_pelanggan" type="text" class="form-control" value="{{ $transaksi->nama_pelanggan }}">
                    @error('nama_pelanggan')
                    <p>{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label>Nama Produk + Harga Produk</label>
                    <select name="id_produk" id="id_produk" class="form-control" required>
                        <option value="">-Pilih Produk-</option>
                        @foreach ($productsM as $products)
                        <option value="{{ $products->id}}" data-harga="{{ $products->harga_produk }}" {{ $transaksi->id_produk == $products->id ? 'selected' : '' }}>{{ $products->nama_produk}} - {{ $products->harga_produk}}</option>
                        @endforeach
                    </select>
                    @error('id_produk')
                    <p>{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label>Total Beli</label>
                    <input name="qty" id="qty" type="number" class="form-control" value="{{ $transaksi->qty }}">
                    @error('qty')
                    <p>{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label>Harga Total</label>
                    <input id="total_harga" name="total_harga" type="text" class="form-control" value="{{ $transaksi->total_harga }}" readonly>
                </div>
                <div>
                    <label>Uang Bayar</label>
                    <input id="uang_bayar" name="uang_bayar" type="text" class="form-control" value="{{ $transaksi->uang_bayar }}" placeholder="Ex. 50000">
                    @error('uang_bayar')
                    <p>{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label>Uang Kembali</label>
                    <input id="uang_kembali" name="uang_kembali" type="text" class="form-control" value="{{ $transaksi->uang_kembali }}" readonly>
                    @error('uang_kembali')
                    <p>{{ $message }}</p>
                    @enderror
                </div>
                <br>
                <input type="submit" name="submit" class="btn btn-success" value="Edit" />
            </form>
        </div>
    </div>

</section> 

<script>
    // Fungsi untuk menghitung total harga
    function hitungTotalHarga() {
        var hargaProduk = parseFloat(document.querySelector('select[name="id_produk"] option:checked').getAttribute('data-harga'));
        var qty = parseFloat(document.getElementById("qty").value);
        var totalHarga = hargaProduk * qty;
        document.getElementById("total_harga").value = totalHarga;
    }

    // Panggil fungsi hitungTotalHarga saat nilai qty atau produk berubah
    document.getElementById("qty").addEventListener("input", hitungTotalHarga);
    document.getElementById("id_produk").addEventListener("change", hitungTotalHarga);

    // Ambil nilai uang bayar saat nilai berubah
    document.getElementById("uang_bayar").addEventListener("input", function() {
        var uangBayar = parseFloat(document.getElementById("uang_bayar").value);
        var totalHarga = parseFloat(document.getElementById("total_harga").value);
        var uangKembali = uangBayar - totalHarga;
        // Pastikan uang kembali tidak negatif
        if (!isNaN(uangKembali) && uangKembali >= 0) {
            document.getElementById("uang_kembali").value = uangKembali;
        } else {
            // Jika uang bayar kurang dari total harga, set uang kembali menjadi 0
            document.getElementById("uang_kembali").value = 0;
        }
    });
</script>


@endsection
