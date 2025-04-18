@empty($jurusan)
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
    <form action="{{ url('/jurusan/' . $jurusan->jurusan_id . '/update') }}" method="POST" id="form-jurusan">
        @csrf
        @method('PUT')

        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data Jurusan</h5>
                    <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_jurusan_kode">Jurusan Kode <span class="text-danger">*</span></label>
                        <input type="text" id="edit_jurusan_kode" class="form-control" name="jurusan_kode"
                            value="{{ $jurusan->jurusan_kode }}" placeholder="Masukkan Jurusan Kode" required maxlength="5">
                        <div class="invalid-feedback" id="edit_jurusan_kode_error"></div>
                    </div>
                    <div class="form-group">
                        <label for="edit_jurusan_nama">Jurusan Nama <span class="text-danger">*</span></label>
                        <input type="text" id="edit_jurusan_nama" class="form-control" name="jurusan_nama"
                            value="{{ $jurusan->jurusan_nama }}" placeholder="Masukkan Jurusan Nama" required maxlength="50">
                        <div class="invalid-feedback" id="edit_jurusan_nama_error"></div>
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

            $('#form-jurusan').submit(function(e) {
                e.preventDefault();

                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').text('');

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'PUT',
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.success) {
                            $('#myModal').modal('hide');
                            showToast('Data jurusan berhasil diubah', 'success');
                            $('#table_jurusan').DataTable().ajax.reload();
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            $.each(errors, function(key, value) {
                                $('#edit_' + key).addClass('is-invalid');
                                $('#edit_' + key + '_error').text(value[0]);
                            });
                            showToast('Terdapat kesalahan pada input data', 'error');
                        } else {
                            showToast('Terjadi kesalahan saat menyimpan data', 'error');
                        }
                    }
                });
            });
        });
    </script>
@endempty
