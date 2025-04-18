@extends('layouts.app')

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
                                    <h4 class="mb-0 fw-bold"><i class="bi bi-person-badge me-2"></i>{{ $page->title }}</h4>
                                </div>
                                <div>
                                    <a href="{{ route('mahasiswa.index') }}" class="btn btn-primary btn-sm">
                                        <i class="bi bi-arrow-left me-1"></i> Kembali
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="card-body p-4">
                            <div class="row g-4">
                                <!-- Profile Column -->
                                <div class="col-lg-4">
                                    <!-- Profile Image -->
                                    <div class="text-center mb-4">
                                        <div class="position-relative d-inline-block">
                                            <img src="{{ $avatar }}" alt="Profile"
                                                 class="rounded-circle shadow border border-4 border-primary"
                                                 style="width: 180px; height: 180px; object-fit: cover;">
                                        </div>

                                        <h3 class="mt-3 fw-bold">{{ $mahasiswa->mahasiswa_nama }}</h3>
                                        <span class="badge bg-primary rounded-pill">{{ $mahasiswa->nim }}</span>
                                    </div>

                                    <!-- Profile Stats -->
                                    <div class="d-flex justify-content-center mb-4">
                                        <div class="text-center mx-3">
                                            <div class="fs-5 fw-bold text-primary">{{ $mahasiswa->angkatan }}</div>
                                            <div class="text-muted small">Angkatan</div>
                                        </div>
                                        <div class="text-center mx-3">
                                            <div class="fs-5 fw-bold text-primary">{{ $mahasiswa->prodi->prodi_nama }}</div>
                                            <div class="text-muted small">Program Studi</div>
                                        </div>
                                    </div>

                                    <!-- Contact Info Card -->
                                    <div class="card shadow-sm mb-4">
                                        <div class="card-body">
                                            <!-- Email -->
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="bg-light bg-opacity-25 rounded p-2 me-3">
                                                    <i class="bi bi-envelope-fill text-primary fs-4"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">Email</h6>
                                                    <p class="text-muted mb-0 text-break">{{ $user->email }}</p>
                                                </div>
                                            </div>
                                            <hr class="my-2">

                                            <!-- Phone -->
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="bg-light bg-opacity-25 rounded p-2 me-3">
                                                    <i class="bi bi-telephone-fill text-primary fs-4"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">No. Telepon</h6>
                                                    <p class="text-muted mb-0">{{ $mahasiswa->no_telepon }}</p>
                                                </div>
                                            </div>
                                            <hr class="my-2">

                                            <!-- Gender -->
                                            <div class="d-flex align-items-center">
                                                <div class="bg-light bg-opacity-25 rounded p-2 me-3">
                                                    <i class="bi bi-gender-ambiguous text-primary fs-4"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">Jenis Kelamin</h6>
                                                    <p class="text-muted mb-0">{{ $mahasiswa->jenis_kelamin }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Detail Column -->
                                <div class="col-lg-8">
                                    <div class="card shadow-sm h-100">
                                        <div class="card-header">
                                            <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Informasi Detail</h5>
                                        </div>
                                        <div class="card-body">
                                            <!-- Academic Information -->
                                            <div class="row mb-4">
                                                <div class="col-md-6">
                                                    <h6 class="text-primary fw-bold mb-3">Data Akademik</h6>
                                                    <ul class="list-unstyled">
                                                        <li class="mb-2 d-flex justify-content-between">
                                                            <span class="fw-medium">NIM:</span>
                                                            <span>{{ $mahasiswa->nim }}</span>
                                                        </li>
                                                        <li class="mb-2 d-flex justify-content-between">
                                                            <span class="fw-medium">Program Studi:</span>
                                                            <span>{{ $mahasiswa->prodi->prodi_nama }}</span>
                                                        </li>
                                                        <li class="mb-2 d-flex justify-content-between">
                                                            <span class="fw-medium">Angkatan:</span>
                                                            <span>{{ $mahasiswa->angkatan }}</span>
                                                        </li>
                                                    </ul>
                                                </div>

                                                <!-- Personal Information -->
                                                <div class="col-md-6">
                                                    <h6 class="text-primary fw-bold mb-3">Data Pribadi</h6>
                                                    <ul class="list-unstyled">
                                                        <li class="mb-2 d-flex justify-content-between">
                                                            <span class="fw-medium">Nama Lengkap:</span>
                                                            <span>{{ $mahasiswa->mahasiswa_nama }}</span>
                                                        </li>
                                                        <li class="mb-2 d-flex justify-content-between">
                                                            <span class="fw-medium">Jenis Kelamin:</span>
                                                            <span>{{ $mahasiswa->jenis_kelamin }}</span>
                                                        </li>
                                                        <li class="mb-2 d-flex justify-content-between">
                                                            <span class="fw-medium">No. Telepon:</span>
                                                            <span>{{ $mahasiswa->no_telepon }}</span>
                                                        </li>
                                                        <li class="d-flex justify-content-between">
                                                            <span class="fw-medium">Email:</span>
                                                            <span class="text-break">{{ $user->email }}</span>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>

                                            <!-- Address Section -->
                                            <div class="mt-4">
                                                <h6 class="text-primary fw-bold mb-3">Alamat</h6>
                                                <div class="card p-3 bg-light">
                                                    <div class="d-flex">
                                                        <i class="bi bi-geo-alt-fill text-primary me-2"></i>
                                                        <span>{{ $mahasiswa->mahasiswa_alamat }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
