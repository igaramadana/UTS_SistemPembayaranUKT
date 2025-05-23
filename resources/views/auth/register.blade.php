<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Sistem Akademik</title>
    <link rel="stylesheet" crossorigin href="{{ url('template/assets/compiled/css/app.css') }}">
    <link rel="stylesheet" crossorigin href="{{ url('template/assets/compiled/css/app-dark.css') }}">
    {{-- Auth Page --}}
    <link rel="stylesheet" crossorigin href="{{ url('template/assets/compiled/css/auth.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <div class="container">
        <div class="row justify-content-center align-items-center py-5">
            <div class="col-md-10 col-lg-8">
                <div class="card shadow-lg">
                    <div class="card-header bg-primary text-white text-center py-4">
                        <div class="d-flex justify-content-center mb-3">
                            <i class="fas fa-user-plus fa-4x"></i>
                        </div>
                        <h2 class="mb-0 text-white">REGISTER MAHASISWA</h2>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('register.post') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <!-- Data Akun -->
                            <div class="mb-4">
                                <h5 class="border-bottom pb-2 text-primary">
                                    <i class="fas fa-user-circle me-2"></i>Informasi Akun
                                </h5>

                                <div class="mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text border-end-0">
                                            <i class="fas fa-envelope text-primary"></i>
                                        </span>
                                        <input type="email" class="form-control border-start-0" id="email"
                                            name="email" placeholder="Email" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6 mb-3 mb-md-0">
                                        <div class="input-group">
                                            <span class="input-group-text border-end-0">
                                                <i class="fas fa-lock text-primary"></i>
                                            </span>
                                            <input type="password" class="form-control border-start-0" id="password"
                                                name="password" placeholder="Password" required>
                                            <button class="btn btn-outline-secondary" type="button"
                                                id="togglePassword">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-text border-end-0">
                                                <i class="fas fa-lock text-primary"></i>
                                            </span>
                                            <input type="password" class="form-control border-start-0"
                                                id="confirmPassword" name="password_confirmation"
                                                placeholder="Konfirmasi Password" required>
                                            <button class="btn btn-outline-secondary" type="button"
                                                id="toggleConfirmPassword">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Data Mahasiswa -->
                            <div class="mb-4">
                                <h5 class="border-bottom pb-2 text-primary">
                                    <i class="fas fa-id-card me-2"></i>Data Mahasiswa
                                </h5>

                                <div class="mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text border-end-0">
                                            <i class="fas fa-id-badge text-primary"></i>
                                        </span>
                                        <input type="text" class="form-control border-start-0" name="nim"
                                            placeholder="Nomor Induk Mahasiswa" required>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text border-end-0">
                                            <i class="fas fa-user text-primary"></i>
                                        </span>
                                        <input type="text" class="form-control border-start-0" name="mahasiswa_nama"
                                            placeholder="Nama Lengkap" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6 mb-3 mb-md-0">
                                        <div class="input-group">
                                            <span class="input-group-text border-end-0">
                                                <i class="fas fa-university text-primary"></i>
                                            </span>
                                            <select class="form-select border-start-0" id="jurusan" name="jurusan_id"
                                                required>
                                                <option value="" selected disabled>-- Pilih Jurusan --</option>
                                                @foreach ($jurusans as $jurusan)
                                                    <option value="{{ $jurusan->jurusan_id }}">
                                                        {{ $jurusan->jurusan_nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-text border-end-0">
                                                <i class="fas fa-graduation-cap text-primary"></i>
                                            </span>
                                            <select class="form-select border-start-0" id="prodi" name="prodi_id"
                                                required>
                                                <option value="" selected disabled>-- Pilih Prodi --</option>
                                                @foreach ($prodis as $prodi)
                                                    <option value="{{ $prodi->prodi_id }}">{{ $prodi->prodi_nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6 mb-3 mb-md-0">
                                        <div class="input-group">
                                            <span class="input-group-text border-end-0">
                                                <i class="fas fa-calendar-alt text-primary"></i>
                                            </span>
                                            <select class="form-select border-start-0" id="angkatan" name="angkatan"
                                                required>
                                                <option value="" selected disabled>-- Pilih Angkatan --</option>
                                                <option value="2025">2025</option>
                                                <option value="2024">2024</option>
                                                <option value="2023">2023</option>
                                                <option value="2022">2022</option>
                                                <option value="2021">2021</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-text border-end-0">
                                                <i class="fas fa-phone text-primary"></i>
                                            </span>
                                            <input type="text" class="form-control border-start-0"
                                                name="no_telepon" placeholder="8xxxxxxxxxx" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6 mb-3 mb-md-0">
                                        <div class="input-group">
                                            <span class="input-group-text border-end-0">
                                                <i class="fas fa-home text-primary"></i>
                                            </span>
                                            <input type="text" class="form-control border-start-0"
                                                name="mahasiswa_alamat" placeholder="Alamat" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-text border-end-0">
                                                <i class="fas fa-venus-mars text-primary"></i>
                                            </span>
                                            <select class="form-select border-start-0" name="jenis_kelamin" required>
                                                <option value="" selected disabled>-- Pilih Jenis Kelamin --
                                                </option>
                                                <option value="Laki-laki">Laki-laki</option>
                                                <option value="Perempuan">Perempuan</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-user-plus me-2"></i> Register
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-center py-3">
                        Sudah memiliki akun? <a href="{{ route('login') }}" class="text-decoration-none fw-bold">Login
                            disini</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ url('template/assets/static/js/components/dark.js') }}"></script>
    <script src="{{ url('template/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ url('template/assets/compiled/js/app.js') }}"></script>
    <script>
        // Toggle password
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const icon = this.querySelector('i');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });

        // Toggle confirm password
        document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('confirmPassword');
            const icon = this.querySelector('i');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });

        document.getElementById('jurusan').addEventListener('change', function() {
            const jurusanId = this.value;
            const prodiSelect = document.getElementById('prodi');

            // Reset prodi dropdown
            prodiSelect.innerHTML = '<option value="" selected disabled>-- Pilih Prodi --</option>';

            if (jurusanId) {
                // Enable prodi dropdown
                prodiSelect.disabled = false;

                // Filter prodis based on jurusan_id
                @foreach ($prodis as $prodi)
                    if ('{{ $prodi->jurusan_id }}' === jurusanId) {
                        const option = document.createElement('option');
                        option.value = '{{ $prodi->prodi_id }}';
                        option.textContent = '{{ $prodi->prodi_nama }}';
                        prodiSelect.appendChild(option);
                    }
                @endforeach
            } else {
                prodiSelect.disabled = true;
            }
        });
    </script>
</body>

</html>
