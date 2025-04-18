<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Akademik</title>
    <link rel="stylesheet" crossorigin href="{{ url('template/assets/compiled/css/app.css') }}">
    <link rel="stylesheet" crossorigin href="{{ url('template/assets/compiled/css/app-dark.css') }}">
    {{-- Auth Page --}}
    <link rel="stylesheet" crossorigin href="{{ url('template/assets/compiled/css/auth.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card shadow-lg">
                    <div class="card-header bg-primary text-white text-center py-4">
                        <div class="d-flex justify-content-center mb-3">
                            <i class="fas fa-user-shield fa-4x"></i>
                        </div>
                        <h2 class="mb-0 text-white">LOGIN SYSTEM</h2>
                    </div>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="card-body p-4 p-md-5">
                        <form action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <div class="input-group">
                                    <span class="input-group-text border-end-0">
                                        <i class="fas fa-envelope text-primary"></i>
                                    </span>
                                    <input type="email" class="form-control border-start-0" id="email"
                                        name="email" placeholder="Email" required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <div class="input-group">
                                    <span class="input-group-text border-end-0">
                                        <i class="fas fa-lock text-primary"></i>
                                    </span>
                                    <input type="password" id="password" name="password"
                                        class="form-control border-start-0" placeholder="Password" required>
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remember">
                                    <label class="form-check-label" for="remember">Remember me</label>
                                </div>
                                <a href="#" class="text-decoration-none">Forgot password?</a>
                            </div>

                            <button type="submit" class="btn btn-primary btn-lg w-100 mb-3">
                                <i class="fas fa-sign-in-alt me-2"></i> Login
                            </button>
                        </form>
                    </div>
                    <div class="card-footer text-center py-3">
                        Don't have an account? <a href="{{ route('register') }}"
                            class="text-decoration-none fw-bold">Register here</a>
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
    </script>
</body>

</html>
