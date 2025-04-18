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
                    <table class="table table-bordered table-striped table-hover align-middle" id="table_admin"
                        width="100%">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th>Foto Profile</th>
                                <th>Nama Admin</th>
                                <th>Email</th>
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
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-white">Tambah Data Admin</h5>
                    <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                        <i class="bi bi-x text-white"></i>
                    </button>
                </div>
                <form id="formTambahAdmin" action="{{ route('admin.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-body">
                            <div class="row">
                                <!-- User Account Section -->
                                <div class="col-md-6">
                                    <div class="card mb-3">
                                        <div class="card-header">
                                            <h6 class="mb-0"><i class="bi bi-person-badge me-2"></i>Informasi Akun</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group mb-3">
                                                <label for="email">Email <span class="text-danger">*</span></label>
                                                <input type="email" id="email" class="form-control" name="email"
                                                    placeholder="Masukkan Email" required>
                                                <div class="invalid-feedback" id="email_error"></div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="password">Password <span class="text-danger">*</span></label>
                                                <input type="password" id="password" class="form-control" name="password"
                                                    placeholder="Masukkan Password (min 8 karakter)" required
                                                    minlength="8">
                                                <div class="invalid-feedback" id="password_error"></div>
                                            </div>
                                            <div class="form-group">
                                                <label for="password_confirmation">Konfirmasi Password <span
                                                        class="text-danger">*</span></label>
                                                <input type="password" id="password_confirmation" class="form-control"
                                                    name="password_confirmation" placeholder="Konfirmasi Password" required>
                                                <div class="invalid-feedback" id="password_confirmation_error"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Admin Information Section -->
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h6 class="mb-0"><i class="bi bi-person-lines-fill me-2"></i>Informasi Admin
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label for="admin_nama">Nama Lengkap Admin <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" id="admin_nama" class="form-control" name="admin_nama"
                                                    placeholder="Masukkan Nama Lengkap Admin" required maxlength="100">
                                                <div class="invalid-feedback" id="admin_nama_error"></div>
                                            </div>
                                        </div>
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

            $('#table_admin').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.list') }}",
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
                        data: 'foto_profile',
                        name: 'foto_profile',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                    {
                        data: 'admin_nama',
                        name: 'admin_nama'
                    },
                    {
                        data: 'user.email',
                        name: 'user.email'
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
            $('#formTambahAdmin').submit(function(e) {
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
                    success: function(response) {
                        if (response.success) {
                            $('#border-less').modal('hide');
                            $('#table_admin').DataTable().ajax.reload();
                            form[0].reset();
                            showToast(response.message, 'success');
                        } else {
                            showToast(response.message || 'Gagal menyimpan data', 'error');
                        }
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
                            var errorMsg = xhr.responseJSON?.error || xhr.responseJSON
                                ?.message || 'Terjadi kesalahan saat menyimpan data';
                            showToast(errorMsg, 'error');
                            console.error('Error details:', xhr.responseJSON);
                        }
                    }
                });
            });

            // Reset form ketika modal ditutup
            $('#border-less').on('hidden.bs.modal', function() {
                $('#formTambahAdmin')[0].reset();
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').text('');
            });
        });
    </script>
@endpush
