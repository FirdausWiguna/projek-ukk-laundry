@extends('sbadmin')
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <!-- Page Heading -->
        <h2 class="h3 mb-4 text-gray-800">Halaman Data Transaksi</h2>
    </div>


    <section class="content">

    <div class="card">
        <div class="card elevation-2">
            <div class="card-header">
                <h3 class="card-title">Data Transaksi</h3>
            </div>
        <div class="card-body">
            @if (Auth::user()->role == 'owner')
            <form action="{{ route('transactions.index') }}" method="get" class="form-inline">
                <div class="form-group mx-2">
                    <label for="start_date" class="mr-2">Tanggal Awal:</label>
                    <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                </div>
                <div class="form-group mx-2">
                    <label for="end_date" class="mr-2">Tanggal Akhir:</label>
                    <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i> 
                </button>
                <a href="{{ route('transactions.index') }}" class="btn btn-danger">
                    <i class="fas fa-undo"></i> 
                </a>
            </form>
            @endif
            <br>

            @if($message = Session::get('success'))
            <div class="alert alert-success">{{ $message }}</div>
            @endif
            @if (Auth::user()->role == 'kasir')
            <a href="{{ route('transactions.create') }}" class="btn btn-success shadow">Tambah Transaksi</a>
            @endif
            @if (Auth::user()->role !== 'admin')
            <a href="{{ url('transactions/pdf') }}" class="btn btn-warning shadow" target="_blank">Unduh PDF</a>  
            @endif 
            @if (Auth::user()->role == 'owner')
            <a href="{{ url('transactions/tgl') }}" class="btn btn-warning shadow">Unduh PDF Pertanggal</a>   
            @endif
            <br><br>
            <table id="myTable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Nomor Unik</th>
                        <th>Nama Pelanggan</th>
                        <th>Nama Produk</th>
                        <th>Harga Produk</th>
                        <th>Total Beli</th>
                        <th>Total Harga</th>
                        <th>Uang Bayar</th>
                        <th>Uang Kembali</th>
                        <th>Tanggal</th> 
                        <th>Status Pengambilan</th> <!-- Tambahkan kolom baru -->
                        @if (Auth::user()->role !== 'owner')
                        <th>Aksi</th>
                        @endif                   
                    </tr>
                </thead>
                <tbody>
                    @if (count($transactionsM) > 0)
                    @foreach ($transactionsM as $transaksi)
                    <tr>
                        <td>{{ $transaksi->nomor_unik}}</td>
                        <td>{{ $transaksi->nama_pelanggan}}</td>
                        <td>{{ $transaksi->nama_produk}}</td>
                        <td>Rp.{{number_format($transaksi->harga_produk)}}</td>
                        <td>{{ $transaksi->qty }} KG</td>
                        <td>Rp.{{number_format($transaksi->total_harga)}}</td>
                        <td>Rp.{{number_format($transaksi->uang_bayar)}}</td>
                        <td>Rp.{{number_format($transaksi->uang_kembali)}}</td>
                        <td>{{$transaksi->createtrans}}</td>
                        <td>
                            @if ($transaksi->status_pengambilan)
                                <span style="display: inline-block; vertical-align: middle;">Sudah Diambil</span>
                                <i class="fas fa-check-circle text-success" style="margin-left: 5px;"></i>
                            @else
                                <span style="display: inline-block; vertical-align: middle;">Belum Diambil</span>
                                <i class="fas fa-times-circle text-danger" style="margin-left: 5px;"></i>
                            @endif
                        </td>                        
                        @if (Auth::user()->role !== 'owner')  
                        <td>
                            <div class="d-flex">
                                @if (Auth::user()->role == 'kasir')
                                <form action="{{ route('transactions.updatestatus', $transaksi->id_trans) }}" method="POST" class="mr-2">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-sm btn-primary">
                                        Ubah Status
                                    </button>
                                </form>
                                @endif
                                @if (Auth::user()->role == 'kasir')
                                <a href="{{ url('transactions/pdf2', $transaksi->id_trans) }}" class="btn btn-sm btn-primary shadow mr-2" target="_blank"><i class=""></i>  Cetak Struk</a>
                                @endif
                                @if (Auth::user()->role == 'admin')
                                <form action="{{ route('transactions.destroy', $transaksi->id_trans) }}" method="POST" class="mr-2">
                                    <a href="{{ route('transactions.edit', $transaksi->id_trans) }}" class="btn btn-sm btn-success shadow">Edit</a>
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Konfirmasi Hapus Data !?');">Hapus</button>
                                </form>
                                @endif
                            </div>
                        </td> 
                        @endif
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="3">Data Tidak Ditemukan</td>
                    </tr>
                    @endif
                </tbody>
            </table>
            <br>
            {{-- {!! $transaksiM->withQueryString()->links('pagination::bootstrap-5') !!} --}}
        </div>
    </div>
    <!-- /.card -->
  
</section>



<!-- /.content -->
@endsection