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
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <!-- Modal Header -->
            <div class="modal-header text-white">
                <h5 class="modal-title">
                    <i class="bi bi-exclamation-octagon-fill me-2"></i>
                    Konfirmasi Penghapusan
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body p-4">
                <div class="d-flex flex-column align-items-center text-center mb-4">
                    <!-- Avatar -->
                    <div class="mb-3">
                        <img src="{{ $avatar }}" alt="User Avatar"
                            class="rounded-circle border border-3 border-danger" width="80">
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
                <button type="submit" id="confirmDelete" data-id="{{ $users->user_id }}" class="btn btn-danger">
                    <i class="bi bi-trash me-1"></i>
                    Hapus
                </button>
            </div>
        </div>
    </div>
    <script>
        $(document).on('click', '#confirmDelete', function() {
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

            const userId = $(this).data('id');
            const deleteUrl = "{{ route('user.delete', ':id') }}".replace(':id', userId);

            $.ajax({
                url: deleteUrl,
                type: 'DELETE',
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.success) {
                        $('#myModal').modal('hide');
                        showToast('Data user berhasil dihapus', 'success');
                        $('#table_users').DataTable().ajax.reload();
                    }
                },
                error: function(xhr) {
                    $('#myModal').modal('hide');
                    let errorMessage = 'Terjadi kesalahan saat menghapus data';

                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }

                    showToast(errorMessage, 'error');
                }
            });
        });

        $('#myModal').on('hidden.bs.modal', function() {
            $(this).empty();
        });
    </script>
@endempty
