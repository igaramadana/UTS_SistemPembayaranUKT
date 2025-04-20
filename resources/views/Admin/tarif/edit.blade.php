@empty($ukt)
    <!-- Modal error jika data tidak ditemukan -->
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white">Kesalahan</h5>
                <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x" class="text-white"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="bi bi-exclamation-triangle-fill"></i> Data tidak ditemukan</h5>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i> Tutup
                </button>
            </div>
        </div>
    </div>
@else
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-white">Edit Data Tarif UKT</h5>
                <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x" class="text-white"></i>
                </button>
            </div>
            <form id="formEditUKT" data-id="{{ $ukt->ukt_id }}">
                @csrf
                @method('PUT')
                <div class="modal-body py-4">
                    <div class="form-body">
                        <div class="row g-3">
                            <div class="col-12 mb-2">
                                <label for="edit_jurusan" class="form-label fw-bold">Jurusan</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-warning text-white">
                                        <i class="bi bi-building"></i>
                                    </span>
                                    <select class="form-select" id="edit_jurusan" name="jurusan_id" required>
                                        <option value="" disabled>-- Pilih Jurusan --</option>
                                        @foreach ($jurusans as $jurusan)
                                            <option value="{{ $jurusan->jurusan_id }}"
                                                {{ $prodi->jurusan_id == $jurusan->jurusan_id ? 'selected' : '' }}>
                                                {{ $jurusan->jurusan_nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="invalid-feedback" id="edit_jurusan_error"></div>
                            </div>
                            <div class="col-12 mb-2">
                                <label for="edit_prodi" class="form-label fw-bold">Program Studi</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-warning text-white">
                                        <i class="bi bi-book"></i>
                                    </span>
                                    <select class="form-select" id="edit_prodi" name="prodi_id" required>
                                        <option value="" disabled>-- Pilih Prodi --</option>
                                        @foreach ($prodis as $p)
                                            <option value="{{ $p->prodi_id }}"
                                                {{ $ukt->prodi_id == $p->prodi_id ? 'selected' : '' }}>
                                                {{ $p->prodi_nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="invalid-feedback" id="edit_prodi_error"></div>
                            </div>
                            <div class="col-12 mb-2">
                                <label for="edit_jenis_masuk" class="form-label fw-bold">Jenis Masuk</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-warning text-white">
                                        <i class="bi bi-door-open"></i>
                                    </span>
                                    <select class="form-select" id="edit_jenis_masuk" name="jenis_masuk" required>
                                        <option value="" disabled>-- Pilih Jenis Masuk --</option>
                                        <option value="SNBP/SNBT" {{ $ukt->jenis_masuk == 'SNBP/SNBT' ? 'selected' : '' }}>
                                            SNBP/SNBT</option>
                                        <option value="mandiri" {{ $ukt->jenis_masuk == 'mandiri' ? 'selected' : '' }}>
                                            Mandiri</option>
                                    </select>
                                </div>
                                <div class="invalid-feedback" id="edit_jenis_masuk_error"></div>
                            </div>
                            <div class="col-12 mb-2">
                                <label for="edit_nominal_ukt" class="form-label fw-bold">Nominal UKT</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-warning text-white">
                                        <i class="bi bi-cash"></i>
                                    </span>
                                    <input type="text" id="edit_nominal_ukt" class="form-control" name="nominal_ukt"
                                        value="{{ $ukt->nominal_ukt }}" placeholder="Masukkan Nominal UKT" required>
                                </div>
                                <div class="invalid-feedback" id="edit_nominal_ukt_error"></div>
                                <small class="text-muted">Contoh: 5000000 (tanpa tanda titik atau koma)</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-warning">
                        <i class="bi bi-check-circle me-1"></i> Perbarui
                    </button>
                </div>
            </form>
        </div>
    </div>

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

            // Filter prodi based on selected jurusan
            $('#edit_jurusan').change(function() {
                const jurusanId = $(this).val();
                const prodiSelect = $('#edit_prodi');

                prodiSelect.html('<option value="" disabled>-- Pilih Prodi --</option>');

                if (jurusanId) {
                    @foreach ($prodis as $p)
                        if ('{{ $p->jurusan_id }}' === jurusanId) {
                            prodiSelect.append(
                                `<option value="{{ $p->prodi_id }}">{{ $p->prodi_nama }}</option>`);
                        }
                    @endforeach
                }
            });

            $('#formEditUKT').submit(function(e) {
                e.preventDefault();

                const uktId = $(this).data('id');
                const updateUrl = "{{ route('settings.update', ':id') }}".replace(':id', uktId);

                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').text('');

                $.ajax({
                    url: updateUrl,
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.success) {
                            $('#myModal').modal('hide');
                            showToast('Data tarif UKT berhasil diperbarui', 'success');
                            $('#table_ukt').DataTable().ajax.reload();
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
