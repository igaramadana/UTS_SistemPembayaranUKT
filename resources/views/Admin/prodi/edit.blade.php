@empty($prodi)
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
                <h5 class="modal-title">Edit Data Prodi</h5>
                <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <form id="form-prodi" data-id="{{ $prodi->prodi_id }}">
                @csrf
                @method('PUT')
                <div class="modal-body">
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
                        <label for="edit_prodi_kode">Prodi Kode <span class="text-danger">*</span></label>
                        <input type="text" id="edit_prodi_kode" class="form-control" name="prodi_kode"
                            value="{{ $prodi->prodi_kode }}" placeholder="Masukkan Prodi Kode" required maxlength="5">
                        <div class="invalid-feedback" id="edit_prodi_kode_error"></div>
                    </div>
                    <div class="form-group">
                        <label for="edit_prodi_nama">Prodi Nama <span class="text-danger">*</span></label>
                        <input type="text" id="edit_prodi_nama" class="form-control" name="prodi_nama"
                            value="{{ $prodi->prodi_nama }}" placeholder="Masukkan Prodi Nama" required maxlength="50">
                        <div class="invalid-feedback" id="edit_prodi_nama_error"></div>
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

            $('#form-prodi').submit(function(e) {
                e.preventDefault();

                const prodiId = $(this).data('id');
                const editUrl = "{{ route('prodi.update', ':id') }}".replace(':id', prodiId);

                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').text('');

                $.ajax({
                    url: editUrl,
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.success) {
                            $('#myModal').modal('hide');
                            showToast('Data prodi berhasil diubah', 'success');
                            $('#table_prodi').DataTable().ajax.reload();
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
