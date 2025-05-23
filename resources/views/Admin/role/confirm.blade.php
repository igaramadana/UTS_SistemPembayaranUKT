@empty($role)
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
                <a href="{{ url('/role') }}" class="btn btn-warning">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Kembali</span>
                </a>
            </div>
        </div>
    </div>
@else
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Hapus Data Role</h5>
                <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning text-center">
                    <h5><i class="bi bi-exclamation-triangle-fill"></i> Apakah anda yakin ingin menghapus data ini?</h5>
                </div>
                <table class="table table-sm table-bordered table-striped">
                    <tr>
                        <th width="30%">Kode Role:</th>
                        <td>{{ $role->role_code }}</td>
                    </tr>
                    <tr>
                        <th>Nama Role:</th>
                        <td>{{ $role->role_nama }}</td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary" data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Batal</span>
                </button>
                <button type="button" class="btn btn-danger ms-1" id="confirmDelete" data-id="{{ $role->role_id }}">
                    <i class="bx bx-trash d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Hapus</span>
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
            const roleId = $(this).data('id');
            const deleteUrl = "{{ route('role.delete', ':id') }}".replace(':id', roleId);

            $.ajax({
                url: deleteUrl,
                type: 'DELETE',
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    $('#myModal').modal('hide');
                    showToast(response.message || 'Data role berhasil dihapus', 'success');
                    $('#table_role').DataTable().ajax.reload();
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
