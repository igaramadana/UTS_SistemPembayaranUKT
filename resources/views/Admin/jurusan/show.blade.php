@extends('layouts.app')

@section('content')
<section class="section">
    <div class="card">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col-sm text-start">
                    <h5 class="card-title mb-0">{{ $page->title }}</h5>
                </div>
            </div>
        </div>
        <div class="card-body">
            @empty($jurusan)
            <div class="alert alert-danger">
                <h5><i class="bi bi-exclamation-triangle-fill"></i> Data tidak ditemukan</h5>
            </div>
            @else
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover align-middle" id="table_role"
                    width="100%">
                    <tr>
                        <th>ID Jurusan</th>
                        <td>{{ $jurusan->jurusan_id }}</td>
                    </tr>
                    <tr>
                        <th>Kode Jurusan</th>
                        <td>{{ $jurusan->jurusan_kode }}</td>
                    </tr>
                    <tr>
                        <th>Nama Jurusan</th>
                        <td>{{ $jurusan->jurusan_nama }}</td>
                    </tr>
                </table>
            </div>
            @endempty

            <a href="{{ route('jurusan.index') }}" class="btn btn-sm btn-primary mt-2">Kembali</a>
        </div>
    </div>
</section>
@endsection
