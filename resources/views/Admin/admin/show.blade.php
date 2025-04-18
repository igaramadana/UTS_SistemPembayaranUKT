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
                                    <a href="{{ route('admin.index') }}" class="btn btn-primary btn-sm">
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

                                        <h3 class="mt-3 fw-bold">{{ $admin->admin_nama }}</h3>
                                        <span class="badge bg-primary rounded-pill">Admin</span>
                                    </div>

                                    <!-- Profile Stats -->
                                    <div class="d-flex justify-content-center mb-4">
                                        <div class="text-center mx-3">
                                            <div class="fs-5 fw-bold text-primary">{{ $user->role->role_nama }}</div>
                                            <div class="text-muted small">Role</div>
                                        </div>
                                        <div class="text-center mx-3">
                                            <div class="fs-5 fw-bold text-primary">{{ $admin->created_at->format('d M Y') }}</div>
                                            <div class="text-muted small">Bergabung</div>
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
                                            <!-- Admin Information -->
                                            <div class="row mb-4">
                                                <div class="col-md-6">
                                                    <h6 class="text-primary fw-bold mb-3">Data Admin</h6>
                                                    <ul class="list-unstyled">
                                                        <li class="mb-2 d-flex justify-content-between">
                                                            <span class="fw-medium">ID Admin:</span>
                                                            <span>{{ $admin->admin_id }}</span>
                                                        </li>
                                                        <li class="mb-2 d-flex justify-content-between">
                                                            <span class="fw-medium">Nama Lengkap:</span>
                                                            <span>{{ $admin->admin_nama }}</span>
                                                        </li>
                                                        <li class="mb-2 d-flex justify-content-between">
                                                            <span class="fw-medium">Tanggal Dibuat:</span>
                                                            <span>{{ $admin->created_at->format('d M Y H:i') }}</span>
                                                        </li>
                                                    </ul>
                                                </div>

                                                <!-- Account Information -->
                                                <div class="col-md-6">
                                                    <h6 class="text-primary fw-bold mb-3">Data Akun</h6>
                                                    <ul class="list-unstyled">
                                                        <li class="mb-2 d-flex justify-content-between">
                                                            <span class="fw-medium">Email:</span>
                                                            <span class="text-break">{{ $user->email }}</span>
                                                        </li>
                                                        <li class="mb-2 d-flex justify-content-between">
                                                            <span class="fw-medium">Role:</span>
                                                            <span>{{ $user->role->role_nama }}</span>
                                                        </li>
                                                        <li class="mb-2 d-flex justify-content-between">
                                                            <span class="fw-medium">Tanggal Registrasi:</span>
                                                            <span>{{ $user->created_at->format('d M Y H:i') }}</span>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>

                                            <!-- Additional Info Section -->
                                            <div class="mt-4">
                                                <h6 class="text-primary fw-bold mb-3">Informasi Tambahan</h6>
                                                <div class="card p-3 bg-light">
                                                    <div class="d-flex">
                                                        <i class="bi bi-info-circle-fill text-primary me-2"></i>
                                                        <span>Admin ini memiliki akses penuh ke sistem sesuai dengan role yang ditentukan.</span>
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
