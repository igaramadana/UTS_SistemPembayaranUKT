@empty($prodi)
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
                <a href="{{ url('/prodi') }}" class="btn btn-warning"><i class="bx bx-x d-block d-sm-none"></i>
                    Kembali</a>
            </div>
        </div>
    </div>
@else
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Hapus Data Program Studi</h5>
                <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning text-center">
                    <h5><i class="bi bi-exclamation-triangle-fill"></i> Apakah anda ingin menghapus data dibawah
                        ini?</h5>
                </div>
                <table class="table table-sm table-bordered table-striped">
                    <tr>
                        <th>Jurusan:</th>
                        <td>{{ $prodi->jurusan->jurusan_nama }}</td>
                    </tr>
                    <tr>
                        <th>Prodi Kode:</th>
                        <td>{{ $prodi->prodi_kode }}</td>
                    </tr>
                    <tr>
                        <th>Prodi Nama:</th>
                        <td>{{ $prodi->prodi_nama }}</td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary" data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Batal</span>
                </button>
                <button type="submit" id="confirmDelete" data-id="{{ $prodi->prodi_id }}"" class="btn btn-primary ms-1">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Simpan</span>
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
            const prodiId = $(this).data('id');
            const deleteUrl = "{{ route('prodi.delete', ':id') }}".replace(':id', prodiId);

            $.ajax({
                url: deleteUrl,
                type: 'DELETE',
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    $('#myModal').modal('hide');
                    $('#table_prodi').DataTable().ajax.reload();
                    showToast(response.message || 'Data prodi berhasil dihapus', 'success');
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
