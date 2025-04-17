@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col-sm text-start">
                        <h5 class="card-title mb-0">{{ $page->title }}</h5>
                    </div>
                    <div class="col-sm text-end">
                        <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                            data-bs-target="#border-less">
                            <i class="bi bi-plus-circle me-1"></i> Tambah Data
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover align-middle" id="table_prodi"
                        width="100%">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th>Kode Prodi</th>
                                <th>Nama Prodi</th>
                                <th>Nama Jurusan</th>
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

    <!-- Modal Tambah -->
    <div class="modal fade text-left modal-borderless" id="border-less" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-white">Tambah Data Prodi</h5>
                    <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x" class="text-white"></i>
                    </button>
                </div>
                <form id="formTambahProdi" action="{{ route('prodi.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="jurusan_id">Jurusan</label>
                                        <select name="jurusan_id" id="jurusan_id" class="form-control" required>
                                            <option value="">-- Pilih Jurusan --</option>
                                            @foreach ($jurusan as $list)
                                                <option value="{{ $list->jurusan_id }}">{{ $list->jurusan_nama }}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback" id="jurusan_kode_error"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="prodi_kode">Prodi Kode</label>
                                        <input type="text" id="prodi_kode" class="form-control" name="prodi_kode"
                                            placeholder="Masukkan Prodi Kode" required maxlength="5">
                                        <div class="invalid-feedback" id="prodi_kode_error"></div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="prodi_nama">Prodi Nama</label>
                                        <input type="text" id="prodi_nama" class="form-control" name="prodi_nama"
                                            placeholder="Masukkan Prodi Nama" required maxlength="50">
                                        <div class="invalid-feedback" id="prodi_nama_error"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                            <i class="bi bi-x"></i> Tutup
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Confirmation Modal --}}
    <div id="myModal" class="modal fade text-left modal-borderless" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel1" aria-hidden="true"></div>
@endsection

@push('css')
@endpush

@push('scripts')
    <script>
        function modalAction(url = '') {
            $('#myModal').load(url, function() {
                $('#myModal').modal('show');
            });
        }
        $(document).ready(function() {
            // Fungsi untuk menampilkan notifikasi Toastify
            function showToast(message, type = 'success') {
                const toastConfig = {
                    text: message,
                    duration: 3000,
                    close: true,
                    gravity: "top",
                    position: "right",
                    stopOnFocus: true,
                };

                // Sesuaikan warna berdasarkan jenis notifikasi
                switch (type) {
                    case 'success':
                        toastConfig.backgroundColor = "#4fbe87";
                        break;
                    case 'error':
                        toastConfig.backgroundColor = "#ff3333";
                        break;
                    case 'warning':
                        toastConfig.backgroundColor = "#ff9966";
                        break;
                    default:
                        toastConfig.backgroundColor = "#4fbe87";
                }

                Toastify(toastConfig).showToast();
            }

            $('#table_prodi').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('prodi.list') }}",
                    type: 'GET'
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                    {
                        data: 'prodi_kode',
                        name: 'prodi_kode'
                    },
                    {
                        data: 'prodi_nama',
                        name: 'prodi_nama'
                    },
                    {
                        data: 'jurusan.jurusan_nama',
                        name: 'jurusan.jurusan_nama'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
            });

            // Handle form submission
            $('#formTambahProdi').submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var url = form.attr('action');

                // Reset error state
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').text('');

                $.ajax({
                    type: "POST",
                    url: url,
                    data: form.serialize(),
                    dataType: 'json',
                    success: function(response) {
                        $('#border-less').modal('hide');
                        $('#table_prodi').DataTable().ajax.reload();
                        form[0].reset();

                        showToast('Data Program studi berhasil ditambahkan', 'success');
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            $.each(errors, function(key, value) {
                                $('#' + key).addClass('is-invalid');
                                $('#' + key + '_error').text(value[0]);
                            });

                            showToast('Terdapat kesalahan pada input data', 'error');
                        } else {
                            showToast('Terjadi kesalahan saat menyimpan data: ' + (xhr
                                .responseJSON?.message || ''), 'error');
                        }
                    }
                });
            });

            // Reset form ketika modal ditutup
            $('#border-less').on('hidden.bs.modal', function() {
                $('#formTambahProdi')[0].reset();
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').text('');
            });
        });
    </script>
@endpush
