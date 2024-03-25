@extends('sbadmin')
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <!-- Page Heading -->
        <h2 class="h3 mb-4 text-gray-800">Halaman Transaksi</h2>
    </div>

    <section class="content">

    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Tambah Data Transaksi</h5>
        </div>
        <div class="card-body">
            <a href="{{ route('transactions.index') }}" class="btn btn-secondary">Kembali</a>
            <br><br>

            <form action="{{ route('transactions.store') }}" method="POST">
                @csrf
                <div>
                    <label>Nomor Unik</label>
                    <input name="nomor_unik" type="number" class="form-control" value="{{ random_int(1000000000,9999999999); }}" readonly>
                    @error('nomor_unik')
                    <p>{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label>Nama Pelanggan</label>
                    <input name="nama_pelanggan" type="text" class="form-control" placeholder="Ex. Atep">
                    @error('nama_pelanggan')
                    <p>{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label>Nama Produk + Harga Produk</label>
                    <select name="id_produk" id="id_produk" class="form-control" required>
                        <option value="">-Pilih Produk-</option>
                        @foreach ($productsM as $products)
                        <option value="{{ $products->id}}" data-harga="{{ $products->harga_produk }}">{{ $products->nama_produk}} - {{ $products->harga_produk}}</option>
                        @endforeach
                    </select>
                    @error('id_produk')
                    <p>{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label>Total Beli</label>
                    <input name="qty" id="qty" type="number" class="form-control" placeholder="Ex. 2">
                    @error('qty')
                    <p>{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label>Harga Total</label>
                    <input id="total_harga" name="total_harga" type="text" class="form-control" readonly>
                </div>
                <div>
                    <label>Uang Bayar</label>
                    <input id="uang_bayar" name="uang_bayar" type="text" class="form-control" placeholder="Ex. 50000">
                    @error('uang_bayar')
                    <p>{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label>Uang Kembali</label>
                    <input id="uang_kembali" name="uang_kembali" type="text" class="form-control" readonly>
                    @error('uang_kembali')
                    <p>{{ $message }}</p>
                    @enderror
                </div>
                <br>
                <input type="submit" name="submit" class="btn btn-success" value="Tambah" />
            </form>
        </div>
    </div>

</section> 

<script>
    // Ambil nilai total harga saat nilai berubah
    document.getElementById("qty").addEventListener("input", function() {
        // Ambil harga produk dari dropdown yang dipilih
        var hargaProduk = parseFloat(document.querySelector('select[name="id_produk"] option:checked').getAttribute('data-harga'));
        // Ambil nilai qty
        var qty = parseFloat(document.getElementById("qty").value);
        // Hitung total harga
        var totalHarga = hargaProduk * qty;
        // Set nilai total harga
        document.getElementById("total_harga").value = totalHarga;
    });

    // Ambil nilai total harga saat nilai dropdown berubah
    document.getElementById("id_produk").addEventListener("change", function() {
        // Ambil harga produk dari dropdown yang dipilih
        var hargaProduk = parseFloat(document.querySelector('select[name="id_produk"] option:checked').getAttribute('data-harga'));
        // Ambil nilai qty
        var qty = parseFloat(document.getElementById("qty").value);
        // Hitung total harga
        var totalHarga = hargaProduk * qty;
        // Set nilai total harga
        document.getElementById("total_harga").value = totalHarga;
    });
</script>

<script>
    // Ambil nilai uang bayar saat nilai berubah
    document.getElementById("uang_bayar").addEventListener("input", function() {
        // Ambil nilai uang bayar
        var uangBayar = parseFloat(document.getElementById("uang_bayar").value);
        // Ambil nilai total harga
        var totalHarga = parseFloat(document.getElementById("total_harga").value);
        // Hitung dan set nilai uang kembali
        var uangKembali = uangBayar - totalHarga;
        // Pastikan uang kembali tidak negatif
        if (uangKembali >= 0) {
            document.getElementById("uang_kembali").value = uangKembali;
        } else {
            // Jika uang bayar kurang dari total harga, set uang kembali menjadi 0
            document.getElementById("uang_kembali").value = 0;
        }
    });
</script>


@endsection
