<!DOCTYPE html>
<html>
<head>
    <title>Invoice Transaksi #{{ $transaksi->id_trans }}</title>
    <style>
        body {
            font-family: 'Courier New', monospace;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 400px;
            margin: 0 auto;
            padding: 10px;
        }
        .header {
            text-align: center;
        }
        .content {
            margin-top: 20px;
            font-size: 14px;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 12px;
        }
        .barcode {
            text-align: center;
            margin-top: 20px;
        }
        .divider {
            border-top: 1px dashed #000;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h3 style="font-size: 24px;">Laundry FW</h3>
            <h2 style="font-size: 18px;">Jl.Sumenep, Subang</h2>

            <div class="divider"></div>
            <p style="font-size: 18px;">Invoice Transaksi</p>
            <p style="font-size: 14px;">Tanggal: {{ date('d/m/Y H:i:s') }}</p>
        </div>
        <div class="content">
            <p style="font-size: 14px;">Nomor Unik: {{ $transaksi->nomor_unik }}</p>
            <div class=></div>
            <p style="font-size: 14px;">Nama Pelanggan: {{ $transaksi->nama_pelanggan }}</p>
            <div class=></div>
            <p style="font-size: 14px;">Nama Produk: {{ $transaksi->nama_produk }}</p>
            <div class=></div>
            <div class=></div>
            <p style="font-size: 14px;">Total Beli: {{ $transaksi->qty }} KG</p>
            <div class=></div>
            <div class=""></div>
            <p style="font-size: 14px;">Total Harga: Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</p>
            <div class=""></div>
            <div class=""></div>
            <p style="font-size: 14px;">Uang Bayar: Rp {{ number_format($transaksi->uang_bayar, 0, ',', '.') }}</p>
            <div class=""></div>
            <p style="font-size: 14px;">Uang Kembali: Rp {{ number_format($transaksi->uang_kembali, 0, ',', '.') }}</p>
            <div class=""></div>
        </div>
        <div class="footer">
            <div class="divider"></div>
            <p style="font-size: 14px;">Terima Kasih Anda Telah Belanja Di Laundry FW</p>
            <p style="font-size: 14px;">Barang Yang Sudah Dibeli Tidak bisa dikembalikan!</p>
        </div>
    </div>
</body>
</html>