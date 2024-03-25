@extends('sbadmin')
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <!-- Page Heading -->
        <h2 class="h3 mb-4 text-gray-800">Halaman Produk</h2>
    </div>


    <section class="content">

    <div class="card">
        <div class="card elevation-2">
            <div class="card-header">
                <h3 class="card-title">Data Produk</h3>
            </div>
            <div class="card-body">
                {{-- @if (Auth::user()->role == 'admin')
                <form action="{{ route('products.index') }}" method="get">
                    <div class="input-group">
                        <input type="name" type="search" name="search" class="form-control" placeholder="Masukan Nama Products" value="{{ $vcari }}">
                        <mr-1>
                        <button type="submit" class="btn btn-primary shadow">Cari</button>
                        <a href="{{ route('products.index') }}">
                            <button type="button" class="btn btn-danger shadow">Reset</button>
                        </a>
                    </div>
                </form>
                <br>
                @endif --}}
    
                @if($message = Session::get('success'))
                <div class="alert alert-success">{{ $message }}</div>
                @endif
                @if (Auth::user()->role == 'admin')
                <a href="{{ route('products.create') }}" class="btn btn-success shadow">Tambah Produk</a>
                @endif
                <a href="{{ url('products/pdf') }}" class="btn btn-warning shadow" target="_blank">Unduh PDF</a>
                <br><br>
                <table id="myTable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Nama Produk</th>
                            <th>Harga Produk</th>
                            <th>Kategori</th>
                            @if (Auth::user()->role == 'owner')
                            <th>Tanggal Masuk</th>
                            @endif
                            @if (Auth::user()->role == 'admin')
                            <th>Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($productsM) > 0)
                    @foreach ($productsM as $products)
                    <tr>
                        <td>{{ $products->nama_produk }}</td>
                        <td>Rp.{{number_format($products->harga_produk) }}</td>
                        <td>{{ $products->kategori }}</td>
                        @if (Auth::user()->role == 'owner')
                        <td>{{ $products->created_at }}</td>
                        @endif
                        @if (Auth::user()->role == 'admin')
                        <td>
                            <form action="{{ route('products.destroy', $products->id) }}" method="POST">
                                <a href="{{ route('products.edit', $products->id) }}" class="btn btn-sm btn-warning shadow">Edit</a>
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-sm btn-danger shadow" onclick="return confirm('Konfirmasi Hapus Data !?');">Hapus</button>
                            </form>
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
            </div>
    </div>

</section> 
@endsection
