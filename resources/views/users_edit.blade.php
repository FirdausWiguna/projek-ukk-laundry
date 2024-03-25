@extends('sbadmin')
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <!-- Page Heading -->
        <h2 class="h3 mb-4 text-gray-800">Halaman User</h2>
    </div>

    <section class="content">

    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Edit Data User</h5>
        </div>
        <div class="card-body">
            <a href="{{ route('users.index') }}" class="btn btn-secondary">Kembali</a>
            <br><br>

            <form action="{{ route('users.update', $users->id) }}" method="POST">
                @csrf
                @method('put')
                <div class="form-group">
                    <label>Username</label>
                    <input name="username" type="text" class="form-control" value="{{ $users->username }}" readonly>
                    @error('username')
                        <p>{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input name="name" type="text" class="form-control" placeholder="Ex. Eben" value="{{ $users->name }}">
                    @error('name')
                        <p>{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Role</label>
                    <select name="role" class="form-control">
                        <option>Pilih Role</option>
                        @if($users->role == 'admin')
                        <option value="admin" selected>Admin</option>
                        <option value="kasir">Kasir</option>
                        <option value="owner">Owner</option>
                        @endif
    
                        @if($users->role == 'kasir') 
                        <option value="admin">Admin</option>
                        <option value="kasir" selected>Kasir</option>
                        <option value="owner">Owner</option>
                        @endif
    
                        @if($users->role == 'owner') 
                        <option value="admin">Admin</option>
                        <option value="kasir">Kasir</option>
                        <option value="owner" selected>Owner</option>
                        @endif
                    </select>
                    @error('role')
                        <p>{{ $message }}</p>
                    @enderror
                </div>
                <input type="submit" name="submit" class="btn btn-success" value="Edit">
            </form>
        </div>
    </div>
</section> 
@endsection
