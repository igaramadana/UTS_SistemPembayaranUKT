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
                    <table class="table table-bordered table-striped table-hover align-middle" id="table_users"
                        width="100%">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th>Foto Profile</th>
                                <th>Email</th>
                                <th>Role</th>
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

            $('#table_users').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('user.list') }}",
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
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'role.role_nama',
                        name: 'role.role_nama'
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
            $('#formTambahUser').submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var url = form.attr('action');

                $.ajax({
                    type: "POST",
                    url: url,
                    data: form.serialize(),
                    success: function(response) {
                        $('#border-less').modal('hide');
                        $('#table_users').DataTable().ajax.reload();
                        form[0].reset();

                        showToast('Data user berhasil ditambahkan', 'success');
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
                $('#formTambahRole')[0].reset();
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').text('');
            });
        });
    </script>
@endpush
