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
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover align-middle" id="table_riwayat"
                        width="100%">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th>Order ID</th>
                                <th>Tanggal Pembayaran</th>
                                <th>NIM</th>
                                <th>Nama Mahasiswa</th>
                                <th>Jurusan</th>
                                <th>Prodi</th>
                                <th>Jenis Masuk</th>
                                <th>Nominal</th>
                                <th>Semester</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('css')
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            try {
                $('#table_riwayat').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('pembayaran.list') }}",
                        type: 'GET',
                        error: function(xhr, error, thrown) {
                            console.log('DataTables AJAX error:', error, thrown);
                            alert('Terjadi kesalahan saat memuat data. Silakan refresh halaman.');
                        }
                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false,
                            className: 'text-center'
                        },
                        {
                            data: 'order_id',
                            name: 'order_id'
                        },
                        {
                            data: 'tanggal_pembayaran',
                            name: 'tanggal_pembayaran',
                            orderable: true,
                            searchable: true,
                        },
                        {
                            data: 'nim',
                            name: 'nim'
                        },
                        {
                            data: 'mahasiswa_nama',
                            name: 'mahasiswa_nama'
                        },
                        {
                            data: 'jurusan',
                            name: 'jurusan'
                        },
                        {
                            data: 'prodi',
                            name: 'prodi'
                        },
                        {
                            data: 'jenis_masuk',
                            name: 'jenis_masuk'
                        },
                        {
                            data: 'nominal',
                            name: 'nominal'
                        },
                        {
                            data: 'semester',
                            name: 'semester'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        },
                    ]
                });
            } catch (e) {
                console.error('DataTable initialization error:', e);
                alert('Terjadi kesalahan saat menginisialisasi tabel. Silakan refresh halaman.');
            }
        });
    </script>
@endpush
