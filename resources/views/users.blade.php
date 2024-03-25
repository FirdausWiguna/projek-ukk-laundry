@extends('sbadmin')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Halaman Data User</h1>
            </div>

        </div>
    </div><!-- /.container-fluid -->
    </section>
  
    <!-- Main content -->
    <section class="content">
  
    <!-- Default box -->
    <div class="card elevation-2">
        <div class="card-header">
        <h3 class="card-title">Data User</h3>
        </div>
        <div class="card-body">
            {{-- <form action="{{ route('user.index') }}" method="get">
                <div class="input-group">
                    <input type="search" name="search" class="form-control" placeholder="Masukan Nama user" value="{{ $vcari }}">
                    <button type="submit" class="btn btn-primary shadow">Cari</button>
                    <a href="{{ route('user.index') }}">
                        <button type="button" class="btn btn-danger shadow">Reset</button>
                    </a>
                </div>
            </form> --}}

            @if($message = Session::get('success'))
            <div class="alert alert-success">{{ $message }}</div>
            @endif
            <a href="{{ route('users.create') }}" class="btn btn-success shadow">Tambah Data</a>
            {{-- <a href="{{ url('user/pdf') }}" class="btn btn-warning shadow">Unduh PDF</a> --}}
            <br><br>
            <table id="myTable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Nama Lengkap</th>
                        <th>Username</th>
                        <th>Roles</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
               <tbody>
                @if (count($usersM) > 0)
                @foreach ($usersM as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->role }}</td>
                    <td>
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-warning shadow">Edit</a>
                            @csrf
                            @method('delete')
                            <a href="{{ route('users.changepassword', $user->id) }}" class="btn btn-sm btn-success shadow">Change Password</a>
                            <button type="submit" class="btn btn-sm btn-danger shadow" onclick="return confirm('Konfirmasi Hapus Data !?');">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="5">Data Tidak Ditemukan</td>
                </tr>
                @endif
               </tbody>
            </table>
            <br>
            {{-- {!! $user->withQueryString()->links('pagination::bootstrap-5') !!} --}}
        </div>
    </div>
    <!-- /.card -->
  
</section>
<!-- /.content -->
@endsection