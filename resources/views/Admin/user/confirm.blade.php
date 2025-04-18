@empty($users)
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kesalahan</h5>
                <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="bi bi-exclamation-triangle-fill"></i> Data tidak ditemukan</h5>
                </div>
            </div>
            <div class="modal-footer">
                <a href="{{ url('/user') }}" class="btn btn-warning"><i class="bx bx-x d-block d-sm-none"></i>
                    Kembali</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/user/' . $users->user_id . '/delete') }}" method="POST" id="form-delete">
        @csrf
        @method('DELETE')

        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <!-- Modal Header -->
                <div class="modal-header text-white">
                    <h5 class="modal-title">
                        <i class="bi bi-exclamation-octagon-fill me-2"></i>
                        Konfirmasi Penghapusan
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body p-4">
                    <div class="d-flex flex-column align-items-center text-center mb-4">
                        <!-- Avatar -->
                        <div class="mb-3">
                            <img src="{{ $avatar }}" alt="User Avatar" class="rounded-circle border border-3 border-danger" width="80">
                        </div>

                        <!-- Warning Message -->
                        <div class="alert alert-danger bg-light-danger border-0 mb-3 w-100">
                            <h6 class="fw-bold mb-0">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                Anda akan menghapus data user berikut:
                            </h6>
                        </div>

                        <!-- User Details -->
                        <table class="table table-borderless table-sm w-100">
                            <tbody>
                                <tr>
                                    <td class="fw-bold text-end" width="30%">Role:</td>
                                    <td>{{ $users->role->role_nama }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-end">Email:</td>
                                    <td>{{ $users->email }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="text-center text-muted small">
                        <i class="bi bi-info-circle me-1"></i>
                        Data yang dihapus tidak dapat dikembalikan
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i>
                        Batal
                    </button>
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash me-1"></i>
                        Hapus
                    </button>
                </div>
            </div>
        </div>
    </form>
    <script>
        $(document).ready(function() {
            function showToast(message, type = 'success') {
                const toastConfig = {
                    text: message,
                    duration: 3000,
                    close: true,
                    gravity: "top",
                    position: "right",
                    stopOnFocus: true,
                };

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
            $('#form-delete').submit(function(e) {
                e.preventDefault();
                var form = $(this);

                $.ajax({
                    url: form.attr('action'),
                    type: 'DELETE',
                    data: form.serialize(),
                    success: function(response) {
                        if (response.success) {
                            $('#myModal').modal('hide');
                            showToast('Data user berhasil dihapus', 'success');

                            // Reload datatable
                            $('#table_users').DataTable().ajax.reload();
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            $.each(errors, function(key, value) {
                                $('#' + key).addClass('is-invalid');
                                $('#' + key + '_error').text(value[0]);
                            });

                            showToast('Terdapat kesalahan pada hapus data', 'error');
                        } else {
                            showToast('Terjadi kesalahan saat menyimpan data', 'error');
                        }
                    }
                });
            });
        });
    </script>
@endempty
