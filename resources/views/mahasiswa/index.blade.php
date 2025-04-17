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
                    <table class="table table-bordered table-striped table-hover align-middle" id="table_mahasiswa"
                        width="100%">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th>Foto Profile</th>
                                <th>NIM</th>
                                <th>Nama Lengkap</th>
                                <th>Email</th>
                                <th>Angkatan</th>
                                <th>Alamat</th>
                                <th>No. HP</th>
                                <th>Jenis Kelamin</th>
                                <th>Prodi</th>
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
                    <h5 class="modal-title text-white">Tambah Data Mahasiswa</h5>
                    <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x" class="text-white"></i>
                    </button>
                </div>
                <form id="formTambahMahasiswa" action="{{ route('mahasiswa.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-body">
                            <div class="row">
                                <!-- User Account Section -->
                                <div class="col-md-6">
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <div class="form-group mb-3">
                                                <label for="email">Email</label>
                                                <input type="email" id="email" class="form-control" name="email"
                                                    placeholder="Masukkan Email" required>
                                                <div class="invalid-feedback" id="email_error"></div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="password">Password</label>
                                                <input type="password" id="password" class="form-control" name="password"
                                                    placeholder="Masukkan Password" required minlength="8">
                                                <div class="invalid-feedback" id="password_error"></div>
                                            </div>
                                            <div class="form-group">
                                                <label for="password_confirmation">Konfirmasi Password</label>
                                                <input type="password" id="password_confirmation" class="form-control"
                                                    name="password_confirmation" placeholder="Konfirmasi Password" required>
                                                <div class="invalid-feedback" id="password_confirmation_error"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Student Information Section -->
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="form-group mb-3">
                                                <label for="nim">NIM</label>
                                                <input type="text" id="nim" class="form-control" name="nim"
                                                    placeholder="Masukkan NIM" required>
                                                <div class="invalid-feedback" id="nim_error"></div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="mahasiswa_nama">Nama Lengkap</label>
                                                <input type="text" id="mahasiswa_nama" class="form-control"
                                                    name="mahasiswa_nama" placeholder="Masukkan Nama Lengkap" required>
                                                <div class="invalid-feedback" id="mahasiswa_nama_error"></div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="angkatan">Angkatan</label>
                                                <input type="number" id="angkatan" class="form-control" name="angkatan"
                                                    placeholder="Masukkan Tahun Angkatan" required>
                                                <div class="invalid-feedback" id="angkatan_error"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Additional Information -->
                                <div class="col-md-6">
                                    <div class="card mt-1">
                                        <div class="card-body">
                                            <div class="form-group mb-3">
                                                <label for="prodi_id">Program Studi</label>
                                                <select name="prodi_id" id="prodi_id" class="form-control" required>
                                                    <option value="">-- Pilih Prodi --</option>
                                                    @foreach ($prodi as $item)
                                                        <option value="{{ $item->prodi_id }}">{{ $item->prodi_nama }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback" id="prodi_id_error"></div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="jenis_kelamin">Jenis Kelamin</label>
                                                <select name="jenis_kelamin" id="jenis_kelamin" class="form-control"
                                                    required>
                                                    <option value="">-- Pilih Jenis Kelamin --</option>
                                                    <option value="Laki-laki">Laki-laki</option>
                                                    <option value="Perempuan">Perempuan</option>
                                                </select>
                                                <div class="invalid-feedback" id="jenis_kelamin_error"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card mt-1">
                                        <div class="card-body">
                                            <div class="form-group mb-3">
                                                <label for="mahasiswa_alamat">Alamat</label>
                                                <textarea id="mahasiswa_alamat" class="form-control" name="mahasiswa_alamat" placeholder="Masukkan Alamat" required></textarea>
                                                <div class="invalid-feedback" id="mahasiswa_alamat_error"></div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="no_telepon">No. HP</label>
                                                <input type="text" id="no_telepon" class="form-control"
                                                    name="no_telepon" placeholder="Masukkan Nomor Telepon" required>
                                                <div class="invalid-feedback" id="no_telepon_error"></div>
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

            $('#table_mahasiswa').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('mahasiswa.list') }}",
                    type: 'GET',
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
                        data: 'nim',
                        name: 'nim'
                    },
                    {
                        data: 'mahasiswa_nama',
                        name: 'mahasiswa_nama'
                    },
                    {
                        data: 'user.email',
                        name: 'user.email',
                    },
                    {
                        data: 'jenis_kelamin',
                        name: 'jenis_kelamin'
                    },
                    {
                        data: 'mahasiswa_alamat',
                        name: 'mahasiswa_alamat'
                    },
                    {
                        data: 'no_telepon',
                        name: 'no_telepon'
                    },
                    {
                        data: 'jenis_kelamin',
                        name: 'jenis_kelamin'
                    },
                    {
                        data: 'prodi.prodi_nama',
                        name: 'prodi.prodi_nama'
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
            $('#formTambahMahasiswa').submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var url = form.attr('action');

                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').text('');

                $.ajax({
                    type: "POST",
                    url: url,
                    data: form.serialize(),
                    success: function(response) {
                        $('#border-less').modal('hide');
                        $('#table_mahasiswa').DataTable().ajax.reload();
                        form[0].reset();

                        showToast('Data Mahasiswa berhasil ditambahkan', 'success');
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
                            showToast(xhr.responseJSON.message || 'Terjadi kesalahan saat menyimpan data', 'error');
                        }
                    }
                });
            });

            // Reset form ketika modal ditutup
            $('#myModal').on('hidden.bs.modal', function() {
                $('#formTambahRole')[0].reset();
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').text('');
            });
        });
    </script>
@endpush
