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
                    <table class="table table-bordered table-striped table-hover align-middle" id="table_ukt"
                        width="100%">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th>Jurusan</th>
                                <th>Prodi</th>
                                <th>Jenis Masuk</th>
                                <th>Nominal</th>
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
                    <h5 class="modal-title text-white">Tambah Data Tarif UKT</h5>
                    <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x" class="text-white"></i>
                    </button>
                </div>
                <form id="formTambahUKT" action="{{ route('settings.store') }}" method="POST">
                    @csrf
                    <div class="modal-body py-4">
                        <div class="form-body">
                            <div class="row g-3">
                                <div class="col-12 mb-2">
                                    <label for="jurusan" class="form-label fw-bold">Jurusan</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-primary text-white">
                                            <i class="bi bi-building"></i>
                                        </span>
                                        <select class="form-select" id="jurusan" name="jurusan_id" required>
                                            <option value="" selected disabled>-- Pilih Jurusan --</option>
                                            @foreach ($jurusans as $jurusan)
                                                <option value="{{ $jurusan->jurusan_id }}">
                                                    {{ $jurusan->jurusan_nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 mb-2">
                                    <label for="prodi" class="form-label fw-bold">Program Studi</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-primary text-white">
                                            <i class="bi bi-book"></i>
                                        </span>
                                        <select class="form-select" id="prodi" name="prodi_id" required>
                                            <option value="" selected disabled>-- Pilih Prodi --</option>
                                            @foreach ($prodis as $prodi)
                                                <option value="{{ $prodi->prodi_id }}">{{ $prodi->prodi_nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 mb-2">
                                    <label for="jenis_masuk" class="form-label fw-bold">Jenis Masuk</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-primary text-white">
                                            <i class="bi bi-door-open"></i>
                                        </span>
                                        <select class="form-select" id="jenis_masuk" name="jenis_masuk" required>
                                            <option value="" selected disabled>-- Pilih Jenis Masuk --</option>
                                            <option value="SNBP/SNBT">SNBP/SNBT</option>
                                            <option value="mandiri">Mandiri</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 mb-2">
                                    <label for="nominal_ukt" class="form-label fw-bold">Nominal UKT</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-primary text-white">
                                            <i class="bi bi-cash"></i>
                                        </span>
                                        <input type="text" id="nominal_ukt" class="form-control" name="nominal_ukt"
                                            placeholder="Masukkan Nominal UKT" required>
                                    </div>
                                    <div class="invalid-feedback" id="nominal_ukt_error"></div>
                                    <small class="text-muted">Contoh: 5000000 (tanpa tanda titik atau koma)</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle me-1"></i> Tutup
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-1"></i> Simpan
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

            @if (Session::has('toast_message'))
                showToast(
                    "{{ Session::get('toast_message') }}",
                    "{{ Session::get('toast_type', 'success') }}"
                );
            @endif

            $('#table_ukt').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('settings.list') }}",
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
                        data: 'prodi.jurusan.jurusan_nama',
                        name: 'prodi.jurusan.jurusan_nama'
                    },
                    {
                        data: 'prodi.prodi_nama',
                        name: 'prodi.prodi_nama'
                    },
                    {
                        data: 'jenis_masuk',
                        name: 'jenis_masuk'
                    },
                    {
                        data: 'nominal_ukt',
                        name: 'nominal_ukt'
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
            $('#formTambahUKT').submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var url = form.attr('action');

                $.ajax({
                    type: "POST",
                    url: url,
                    data: form.serialize(),
                    success: function(response) {
                        $('#border-less').modal('hide');
                        $('#table_ukt').DataTable().ajax.reload();
                        form[0].reset();

                        showToast('Data role berhasil ditambahkan', 'success');
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
                            showToast('Terjadi kesalahan saat menyimpan data', 'error');
                        }
                    }
                });
            });



            // Reset form ketika modal ditutup
            $('#myModal').on('hidden.bs.modal', function() {
                $('#formTambahUKT')[0].reset();
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').text('');
            });
        });

        document.getElementById('jurusan').addEventListener('change', function() {
            const jurusanId = this.value;
            const prodiSelect = document.getElementById('prodi');

            prodiSelect.innerHTML = '<option value="" selected disabled>-- Pilih Prodi --</option>';
            if (jurusanId) {
                prodiSelect.disabled = false;
                @foreach ($prodis as $prodi)
                    if ('{{ $prodi->jurusan_id }}' === jurusanId) {
                        const option = document.createElement('option');
                        option.value =
                            '{{ $prodi->prodi_id }}';
                        option.textContent = '{{ $prodi->prodi_nama }}';
                        prodiSelect
                            .appendChild(option);
                    }
                @endforeach
            } else {
                prodiSelect.disabled = true;
            }
        });
    </script>
@endpush
