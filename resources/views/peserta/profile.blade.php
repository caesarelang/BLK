<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Peserta - {{ config('app.name', 'Laravel') }}</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        body {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 50%, #1e40af 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .navbar {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
        }
        
        .main-content {
            padding: 2rem 0;
        }
        
        .profile-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            border: 0;
        }
        
        .avatar {
            width: 120px;
            height: 120px;
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 50%, #1e40af 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 3rem;
            margin: 0 auto 1.5rem;
        }
        
        .form-control {
            border-radius: 12px;
            border: 2px solid #e9ecef;
            padding: 12px 16px;
            font-size: 16px;
        }
        
        .form-control:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 0.25rem rgba(59, 130, 246, 0.15);
        }
        
        .btn-primary-custom {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 50%, #1e40af 100%);
            border: none;
            border-radius: 12px;
            padding: 14px 24px;
            font-size: 16px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3);
        }
        
        .btn-outline-custom {
            border: 2px solid #3b82f6;
            color: #3b82f6;
            border-radius: 12px;
            padding: 14px 24px;
            font-size: 16px;
            font-weight: 600;
            transition: all 0.3s ease;
            background: transparent;
        }
        
        .btn-outline-custom:hover {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 50%, #1e40af 100%);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3);
        }
        
        .password-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #6c757d;
            cursor: pointer;
        }
        
        .password-toggle:hover {
            color: #3b82f6;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">
                <i class="bi bi-mortarboard-fill me-2"></i>Portal Peserta
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('peserta.dashboard') }}">
                            <i class="bi bi-house-door me-1"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('peserta.profile') }}">
                            <i class="bi bi-person me-1"></i>Profile
                        </a>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="nav-link btn btn-link text-decoration-none">
                                <i class="bi bi-box-arrow-right me-1"></i>Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container">
            <!-- Success Message -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Profile Card -->
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card profile-card">
                        <div class="card-body p-5">
                            <!-- Header -->
                            <div class="text-center mb-5">
                                <div class="avatar">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <h2 class="fw-bold mb-2">Profile Saya</h2>
                                <p class="text-muted">Kelola informasi profil dan keamanan akun Anda</p>
                            </div>

                            <!-- Profile Form -->
                            <form method="POST" action="{{ route('peserta.profile.update') }}">
                                @csrf
                                @method('PUT')

                                <!-- Name Field -->
                                <div class="mb-4">
                                    <label for="name" class="form-label fw-semibold">
                                        <i class="bi bi-person me-2"></i>Nama Lengkap
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           id="name" 
                                           name="name" 
                                           value="{{ old('name', $user->name) }}" 
                                           placeholder="Masukkan nama lengkap Anda"
                                           required>
                                    @error('name')
                                        <div class="invalid-feedback">
                                            <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Email Field -->
                                <div class="mb-4">
                                    <label for="email" class="form-label fw-semibold">
                                        <i class="bi bi-envelope me-2"></i>Email Address
                                    </label>
                                    <input type="email" 
                                           class="form-control @error('email') is-invalid @enderror" 
                                           id="email" 
                                           name="email" 
                                           value="{{ old('email', $user->email) }}" 
                                           placeholder="Masukkan email Anda"
                                           required>
                                    @error('email')
                                        <div class="invalid-feedback">
                                            <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <hr class="my-4">

                                <!-- Password Section -->
                                <h5 class="fw-bold mb-3">
                                    <i class="bi bi-shield-lock me-2"></i>Ubah Password
                                </h5>
                                <p class="text-muted mb-4">Biarkan kosong jika tidak ingin mengubah password</p>

                                <!-- New Password Field -->
                                <div class="mb-4">
                                    <label for="password" class="form-label fw-semibold">
                                        <i class="bi bi-lock me-2"></i>Password Baru
                                    </label>
                                    <div class="position-relative">
                                        <input type="password" 
                                               class="form-control @error('password') is-invalid @enderror" 
                                               id="password" 
                                               name="password" 
                                               placeholder="Masukkan password baru">
                                        <button type="button" class="password-toggle" id="togglePassword">
                                            <i class="bi bi-eye" id="toggleIcon1"></i>
                                        </button>
                                    </div>
                                    @error('password')
                                        <div class="invalid-feedback d-block">
                                            <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Confirm Password Field -->
                                <div class="mb-4">
                                    <label for="password_confirmation" class="form-label fw-semibold">
                                        <i class="bi bi-lock-fill me-2"></i>Konfirmasi Password
                                    </label>
                                    <div class="position-relative">
                                        <input type="password" 
                                               class="form-control @error('password_confirmation') is-invalid @enderror" 
                                               id="password_confirmation" 
                                               name="password_confirmation" 
                                               placeholder="Konfirmasi password baru">
                                        <button type="button" class="password-toggle" id="togglePasswordConfirm">
                                            <i class="bi bi-eye" id="toggleIcon2"></i>
                                        </button>
                                    </div>
                                    @error('password_confirmation')
                                        <div class="invalid-feedback d-block">
                                            <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Action Buttons -->
                                <div class="d-flex gap-3 justify-content-between flex-wrap">
                                    <a href="{{ route('peserta.dashboard') }}" class="btn btn-outline-custom">
                                        <i class="bi bi-arrow-left me-2"></i>Kembali
                                    </a>
                                    <button type="submit" class="btn btn-primary-custom text-white">
                                        <i class="bi bi-check-circle me-2"></i>Simpan Perubahan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Password toggle functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle for password field
            const passwordInput = document.getElementById('password');
            const toggleButton = document.getElementById('togglePassword');
            const toggleIcon1 = document.getElementById('toggleIcon1');

            toggleButton.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                
                if (type === 'password') {
                    toggleIcon1.className = 'bi bi-eye';
                } else {
                    toggleIcon1.className = 'bi bi-eye-slash';
                }
            });

            // Toggle for password confirmation field
            const passwordConfirmInput = document.getElementById('password_confirmation');
            const toggleButtonConfirm = document.getElementById('togglePasswordConfirm');
            const toggleIcon2 = document.getElementById('toggleIcon2');

            toggleButtonConfirm.addEventListener('click', function() {
                const type = passwordConfirmInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordConfirmInput.setAttribute('type', type);
                
                if (type === 'password') {
                    toggleIcon2.className = 'bi bi-eye';
                } else {
                    toggleIcon2.className = 'bi bi-eye-slash';
                }
            });

            // Form validation
            const form = document.querySelector('form');
            const emailInput = document.getElementById('email');
            
            emailInput.addEventListener('blur', function() {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (this.value && !emailRegex.test(this.value)) {
                    this.classList.add('is-invalid');
                } else {
                    this.classList.remove('is-invalid');
                }
            });

            // Remove validation classes on input
            const inputs = form.querySelectorAll('.form-control');
            inputs.forEach(input => {
                input.addEventListener('input', function() {
                    this.classList.remove('is-invalid');
                });
            });

            // Password confirmation matching
            passwordConfirmInput.addEventListener('input', function() {
                if (passwordInput.value && this.value && passwordInput.value !== this.value) {
                    this.classList.add('is-invalid');
                } else {
                    this.classList.remove('is-invalid');
                }
            });
        });
    </script>
</body>
</html>