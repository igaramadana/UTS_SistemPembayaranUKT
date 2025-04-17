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
            @empty($prodi)
            <div class="alert alert-danger">
                <h5><i class="bi bi-exclamation-triangle-fill"></i> Data tidak ditemukan</h5>
            </div>
            @else
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover align-middle" id="table_role"
                    width="100%">
                    <tr>
                        <th>ID Prodi</th>
                        <td>{{ $prodi->prodi_id }}</td>
                    </tr>
                    <tr>
                        <th>Jurusan</th>
                        <td>{{ $prodi->jurusan->jurusan_nama }}</td>
                    </tr>
                    <tr>
                        <th>Kode Prodi</th>
                        <td>{{ $prodi->prodi_kode }}</td>
                    </tr>
                    <tr>
                        <th>Nama Prodi</th>
                        <td>{{ $prodi->prodi_nama }}</td>
                    </tr>
                </table>
            </div>
            @endempty

            <a href="{{ route('prodi.index') }}" class="btn btn-sm btn-primary mt-2">Kembali</a>
        </div>
    </div>
</section>
@endsection
