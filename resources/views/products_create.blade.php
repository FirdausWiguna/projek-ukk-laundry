@extends('sbadmin')
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <!-- Page Heading -->
        <h2 class="h3 mb-4 text-gray-800">Halaman Produk</h2>
    </div>

    <section class="content">

    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Menambah Data Produk</h5>
        </div>
        <div class="card-body">
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Kembali</a>
            <br><br>

            <form action="{{ route('products.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Nama Produk</label>
                <input name="nama_produk" type="text" class="form-control" placeholder="Ex. So Klin">
                @error('nama_produk')
                    <p>{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group">
                <label>Kategori</label>
                <select name="kategori" class="form-control">
                    <option>Pilih Kategori Laundry</option>
                    <option value="kiloan">Kiloan</option>
                    <option value="sprei">Sprei</option>
                    <option value="selimut">Selimut</option>
                </select>
                @error('kategori')
                    <p>{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group">
                <label>Harga Produk</label>
                <input name="harga_produk" type="number" class="form-control" placeholder="Ex. 10000">
                @error('harga_produk')
                    <p>{{ $message }}</p>
                @enderror
            </div>
            <input type="submit" name="submit" class="btn btn-success" value="Tambah">
            </form>
        </div>
    </div>

</section> 
@endsection
