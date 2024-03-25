@extends('sbadmin')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Halaman Log</h1>
            </div>

        </div>
    </div><!-- /.container-fluid -->
    </section>
  
    <!-- Main content -->
    <section class="content">
  
    <!-- Default box -->
    <div class="card elevation-2">
        <div class="card-header">
        <h3 class="card-title">Log</h3>
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
            <div class="table-responsive">
            <table id="myTable" class="table table-striped table-bordered text-nowrap">
                <thead>
                    <tr>
                        <th style="text-align: center; vertical-align: middle;">No</th>
                        <th>Nama User</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th>Aktivitas</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <?php $no_log=1
                ?>
                @foreach ($LogM as $Log)
                    <tr>
                        <td style="text-align: center; vertical-align: middle;">{{ $no_log }}</td>
                        <td>{{ $Log->name }}</td>
                        <td>{{ $Log->username }}</td>
                        <td>{{ $Log->role }}</td>
                        <td>{{ $Log->activity }}</td>
                        <td>{{ $Log->created_at }}</td>
                    </tr>
                    <?php $no_log++
                    ?>
                @endforeach
            </table>
        </div>
            <br>
            {{-- {!! $LogM->withQueryString()->links('pagination::bootstrap-5') !!} --}}
        </div>
    </div>
    <!-- /.card -->
  
</section>
<!-- /.content -->
@endsection