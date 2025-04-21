@extends('layouts.mahasiswa_layouts.app')

@section('content')
    <section class="section">
        <div class="card shadow-sm">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col-sm text-start">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-credit-card-2-front-fill me-2"></i>
                            {{ $page->title }}
                        </h5>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-circle me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header">
                                <h6 class="card-title mb-0">
                                    <i class="bi bi-person-badge me-2"></i>Data Mahasiswa
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-borderless mb-0">
                                        <tr>
                                            <th width="40%">NIM</th>
                                            <td width="60%"><span class="badge bg-secondary">{{ $mahasiswa->nim }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Nama</th>
                                            <td>{{ $mahasiswa->mahasiswa_nama }}</td>
                                        </tr>
                                        <tr>
                                            <th>Jurusan</th>
                                            <td>{{ $mahasiswa->prodi->jurusan->jurusan_nama }}</td>
                                        </tr>
                                        <tr>
                                            <th>Program Studi</th>
                                            <td>{{ $mahasiswa->prodi->prodi_nama }}</td>
                                        </tr>
                                        <tr>
                                            <th>Angkatan</th>
                                            <td>{{ $mahasiswa->angkatan }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header">
                                <h6 class="card-title mb-0">
                                    <i class="bi bi-cash-coin me-2"></i>Informasi UKT
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-borderless mb-0">
                                        <tr>
                                            <th width="40%">Jenis Masuk</th>
                                            <td width="60%">{{ $ukt->jenis_masuk }}</td>
                                        </tr>
                                        <tr>
                                            <th>Nominal UKT</th>
                                            <td>
                                                <span class="badge bg-success fs-6">
                                                    Rp {{ number_format($ukt->nominal_ukt, 0, ',', '.') }}
                                                </span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header">
                                <h6 class="card-title mb-0">
                                    <i class="bi bi-wallet2 me-2"></i>Form Pembayaran UKT
                                </h6>
                            </div>
                            <div class="card-body">
                                <form action="" method="POST" id="formPembayaran">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="semester" class="form-label">Semester</label>
                                        <select class="form-select @error('semester') is-invalid @enderror" id="semester"
                                            name="semester" required>
                                            <option value="" selected disabled>Pilih Semester</option>
                                            @for ($i = 1; $i <= 8; $i++)
                                                <option value="{{ $i }}"
                                                    {{ old('semester') == $i ? 'selected' : '' }}>Semester
                                                    {{ $i }}</option>
                                            @endfor
                                        </select>
                                        @error('semester')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <div class="alert alert-info d-flex align-items-center" role="alert">
                                            <i class="bi bi-info-circle-fill text-center me-2"></i>
                                            <div>
                                                <strong class="text-center">Total yang harus dibayar:</strong>
                                                <span class="fs-5 ms-2 text-center">Rp
                                                    {{ number_format($ukt->nominal_ukt, 0, ',', '.') }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn btn-primary btn-lg" id="btnBayar">
                                            <i class="bi bi-arrow-right-circle me-1"></i>
                                            Lanjutkan Pembayaran
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal Konfirmasi -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="confirmationModalLabel">
                        <i class="bi bi-question-circle me-2"></i>
                        Konfirmasi Pembayaran
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin melanjutkan pembayaran UKT?</p>
                    <table class="table table-sm">
                        <tr>
                            <th>Semester</th>
                            <td id="confirmSemester"></td>
                        </tr>
                        <tr>
                            <th>Nominal</th>
                            <td>
                                <span class="badge bg-success fs-6">
                                    Rp {{ number_format($ukt->nominal_ukt, 0, ',', '.') }}
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i>Batal
                    </button>
                    <button type="button" class="btn btn-primary" id="confirmPay">
                        <i class="bi bi-check-circle me-1"></i>Ya, Lanjutkan
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
    </script>
    <script>
        $(document).ready(function() {
            // Tangani form submission
            $('#formPembayaran').on('submit', function(e) {
                e.preventDefault();

                // Validasi semester
                const semester = $('#semester').val();
                if (!semester) {
                    alert('Silakan pilih semester terlebih dahulu');
                    return;
                }

                // Perbarui data konfirmasi
                $('#confirmSemester').text('Semester ' + semester);

                // Tampilkan modal konfirmasi
                $('#confirmationModal').modal('show');
            });

            // Tangani konfirmasi pembayaran
            $('#confirmPay').on('click', function() {
                const $btn = $(this);
                $btn.prop('disabled', true).html('<i class="bi bi-arrow-repeat me-1"></i> Memproses...');

                $.ajax({
                    url: "{{ route('mahasiswa.pembayaran.pay') }}",
                    method: "POST",
                    data: {
                        semester: $('#semester').val(),
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.status === 'error') {
                            alert(response.message);
                            $btn.prop('disabled', false).html(
                                '<i class="bi bi-check-circle me-1"></i>Ya, Lanjutkan');
                            return;
                        }

                        window.snap.pay(response.snapToken, {
                            onSuccess: function(result) {
                                // Refresh halaman setelah 3 detik untuk memastikan data sudah diupdate
                                setTimeout(function() {
                                    window.location.href =
                                        "{{ route('mahasiswa.pembayaran.status', '') }}/" +
                                        response.order_id;
                                }, 3000);
                            },
                            onPending: function(result) {
                                window.location.href =
                                    "{{ route('mahasiswa.pembayaran.status', '') }}/" +
                                    response.order_id;
                            },
                            onError: function(result) {
                                alert('Pembayaran gagal: ' + JSON.stringify(
                                    result));
                                $btn.prop('disabled', false).html(
                                    '<i class="bi bi-check-circle me-1"></i>Ya, Lanjutkan'
                                );
                            },
                            onClose: function() {
                                $btn.prop('disabled', false).html(
                                    '<i class="bi bi-check-circle me-1"></i>Ya, Lanjutkan'
                                );
                            }
                        });
                    },
                    error: function(xhr) {
                        let error = 'Terjadi kesalahan saat memproses pembayaran';
                        try {
                            const res = JSON.parse(xhr.responseText);
                            error = res.message || error;
                        } catch (e) {
                            console.error(e);
                        }
                        alert(error);
                        $btn.prop('disabled', false).html(
                            '<i class="bi bi-check-circle me-1"></i>Ya, Lanjutkan');
                    }
                });
            });
        });
    </script>
@endpush
