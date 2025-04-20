@extends('layouts.mahasiswa_layouts.app')
@section('content')
    <section class="section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12 col-xl-10">
                    <div class="card shadow-lg mb-4">
                        <!-- Card Header -->
                        <div class="card-header text-white py-3">
                            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                                <div class="mb-2 mb-md-0">
                                    <h4 class="mb-0 fw-bold"><i class="bi bi-person-gear me-2"></i>{{ $page->title }}</h4>
                                </div>
                                <div>
                                    <a href="{{ route('mahasiswa.dashboard') }}" class="btn btn-primary btn-sm">
                                        <i class="bi bi-arrow-left me-1"></i> Kembali
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="card-body p-4">
                            <form action="{{ route('mahasiswa.profile.update') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="row g-4">
                                    <!-- Profile Photo Column -->
                                    <div class="col-lg-4">
                                        <div class="card shadow-sm">
                                            <div class="card-header">
                                                <h5 class="mb-0"><i class="bi bi-image me-2"></i>Foto Profil</h5>
                                            </div>
                                            <div class="card-body text-center">
                                                <div class="mb-3">
                                                    <div class="position-relative d-inline-block">
                                                        <img id="preview-image" src="{{ $avatar }}" alt="Profile"
                                                            class="rounded-circle shadow border border-4 border-primary"
                                                            style="width: 180px; height: 180px; object-fit: cover;">
                                                        <div class="position-absolute bottom-0 end-0">
                                                            <label for="foto_profile"
                                                                class="btn btn-sm btn-primary rounded-circle">
                                                                <i class="bi bi-camera-fill"></i>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <input type="file" name="foto_profile" id="foto_profile"
                                                    class="form-control d-none" accept="image/*">
                                                <small class="text-muted d-block mt-2">Klik ikon kamera untuk mengganti
                                                    foto</small>
                                                <small class="text-muted d-block">Format: JPG, JPEG, PNG (Maks. 2MB)</small>
                                                @if ($user->foto_profile)
                                                    <div class="mt-2">
                                                        <a href="{{ route('mahasiswa.profile.delete') }}"
                                                            class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus foto profil?')">
                                                            <i class="bi bi-trash"></i> Hapus Foto
                                                        </a>
                                                    </div>
                                                @endif
                                                @error('foto_profile')
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Profile Details Column -->
                                    <div class="col-lg-8">
                                        <div class="card shadow-sm">
                                            <div class="card-header">
                                                <h5 class="mb-0"><i class="bi bi-person-vcard me-2"></i>Data Pribadi</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="row g-3">
                                                    <!-- Nama Lengkap -->
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="mahasiswa_nama" class="form-label fw-bold">Nama
                                                                Lengkap</label>
                                                            <div class="input-group">
                                                                <span class="input-group-text bg-primary text-white">
                                                                    <i class="bi bi-person-fill"></i>
                                                                </span>
                                                                <input type="text"
                                                                    class="form-control @error('mahasiswa_nama') is-invalid @enderror"
                                                                    id="mahasiswa_nama" name="mahasiswa_nama"
                                                                    value="{{ old('mahasiswa_nama', $mahasiswa->mahasiswa_nama) }}"
                                                                    required>
                                                            </div>
                                                            @error('mahasiswa_nama')
                                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <!-- Email -->
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="email" class="form-label fw-bold">Email</label>
                                                            <div class="input-group">
                                                                <span class="input-group-text bg-primary text-white">
                                                                    <i class="bi bi-envelope-fill"></i>
                                                                </span>
                                                                <input type="email"
                                                                    class="form-control @error('email') is-invalid @enderror"
                                                                    id="email" name="email"
                                                                    value="{{ old('email', $user->email) }}" required>
                                                            </div>
                                                            @error('email')
                                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <!-- No Telepon -->
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="no_telepon" class="form-label fw-bold">No.
                                                                Telepon</label>
                                                            <div class="input-group">
                                                                <span class="input-group-text bg-primary text-white">
                                                                    <i class="bi bi-telephone-fill"></i>
                                                                </span>
                                                                <input type="text"
                                                                    class="form-control @error('no_telepon') is-invalid @enderror"
                                                                    id="no_telepon" name="no_telepon"
                                                                    value="{{ old('no_telepon', $mahasiswa->no_telepon) }}"
                                                                    required>
                                                            </div>
                                                            @error('no_telepon')
                                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <!-- Read-only Fields -->
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="nomor_induk" class="form-label fw-bold">NIM</label>
                                                            <input type="text" class="form-control" id="nomor_induk"
                                                                value="{{ $mahasiswa->nim }}" readonly>
                                                            <small class="text-muted">NIM tidak dapat diubah</small>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="prodi" class="form-label fw-bold">Program
                                                                Studi</label>
                                                            <input type="text" class="form-control" id="prodi"
                                                                value="{{ $mahasiswa->prodi->prodi_nama }}" readonly>
                                                            <small class="text-muted">Program studi tidak dapat
                                                                diubah</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Submit Button -->
                                        <div class="d-flex justify-content-end mt-4">
                                            <a href="{{ route('mahasiswa.dashboard') }}" class="btn btn-light me-2">
                                                <i class="bi bi-x-circle me-1"></i> Batal
                                            </a>
                                            <button type="submit" class="btn btn-primary">
                                                <i class="bi bi-check-circle me-1"></i> Simpan Perubahan
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#foto_profile').change(function() {
                let reader = new FileReader();
                reader.onload = (e) => {
                    $('#preview-image').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            });

            $('label[for="foto_profile"]').click(function() {
                $('#foto_profile').click();
            });
        });
    </script>
@endpush
