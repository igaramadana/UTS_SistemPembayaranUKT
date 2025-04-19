@empty($role)
    <!-- Modal error jika data tidak ditemukan -->
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
                <a href="{{ url('/role') }}" class="btn btn-warning"><i class="bx bx-x d-block d-sm-none"></i>
                    Kembali</a>
            </div>
        </div>
    </div>
@else
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Data Role</h5>
                <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <form id="formEditRole" data-id="{{ $role->role_id }}">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_role_code">Role Kode <span class="text-danger">*</span></label>
                        <input type="text" id="edit_role_code" class="form-control" name="role_code"
                            value="{{ $role->role_code }}" placeholder="Masukkan Role Kode" required maxlength="5">
                        <div class="invalid-feedback" id="edit_role_code_error"></div>
                    </div>
                    <div class="form-group">
                        <label for="edit_role_nama">Role Nama <span class="text-danger">*</span></label>
                        <input type="text" id="edit_role_nama" class="form-control" name="role_nama"
                            value="{{ $role->role_nama }}" placeholder="Masukkan Role Nama" required maxlength="50">
                        <div class="invalid-feedback" id="edit_role_nama_error"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Batal</span>
                    </button>
                    <button type="submit" class="btn btn-primary ms-1">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Simpan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#formEditRole').submit(function(e) {
                e.preventDefault();

                const roleId = $(this).data('id');
                const editUrl = "{{ route('role.update', ':id') }}".replace(':id', roleId);

                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').text('');

                $.ajax({
                    url: editUrl,
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.success) {
                            $('#myModal').modal('hide');
                            $('#table_role').DataTable().ajax.reload();
                            showToast(response.message || 'Data role berhasil diubah', 'success');
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            $.each(errors, function(key, value) {
                                $('#edit_' + key).addClass('is-invalid');
                                $('#edit_' + key + '_error').text(value[0]);
                            });
                            showToast('Terdapat kesalahan pada input data', 'error');
                        } else if (xhr.status === 404) {
                            showToast(xhr.responseJSON.message || 'Data role tidak ditemukan', 'error');
                            $('#myModal').modal('hide');
                        } else {
                            showToast('Terjadi kesalahan saat menyimpan data', 'error');
                        }
                    }
                });
            });

            $('#myModal').on('hidden.bs.modal', function() {
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').text('');
            });
        });

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
    </script>
@endempty
