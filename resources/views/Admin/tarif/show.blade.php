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
                @empty($ukt)
                    <div class="alert alert-danger">
                        <h5><i class="bi bi-exclamation-triangle-fill"></i> Data tidak ditemukan</h5>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover align-middle" id="table_ukt"
                            width="100%">
                            <tr>
                                <th>ID</th>
                                <td>{{ $ukt->ukt_id }}</td>
                            </tr>
                            <tr>
                                <th>Jurusan</th>
                                <td>{{ $prodi->jurusan->jurusan_nama }}</td>
                            </tr>
                            <tr>
                                <th>Prodi</th>
                                <td>{{ $prodi->prodi_nama }}</td>
                            </tr>
                            <tr>
                                <th>Jenis Masuk</th>
                                <td>{{ $ukt->jenis_masuk }}</td>
                            </tr>
                            <tr>
                                <th>Nominal</th>
                                <td>Rp. {{ number_format($ukt->nominal_ukt, 0, ',', '.') }}</td>
                            </tr>
                        </table>
                    </div>
                @endempty
                <a href="{{ route('settings.index') }}" class="btn btn-sm btn-primary mt-2">Kembali</a>
            </div>
        </div>
    </section>
@endsection
