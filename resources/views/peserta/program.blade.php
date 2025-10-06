<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Program Saya - {{ config('app.name', 'Laravel') }}</title>
    
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
        
        .page-header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            border: 0;
            margin-bottom: 2rem;
        }
        
        .program-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: 0;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin-bottom: 1.5rem;
        }
        
        .program-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }
        
        .status-badge {
            font-size: 0.85rem;
            padding: 0.5rem 1rem;
            border-radius: 20px;
        }
        
        .status-pending {
            background-color: #fef3c7;
            color: #92400e;
        }
        
        .status-verified {
            background-color: #d1fae5;
            color: #065f46;
        }
        
        .status-rejected {
            background-color: #fecaca;
            color: #991b1b;
        }
        
        .program-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 50%, #1e40af 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
            margin: 0 auto 1rem;
        }
        
        .empty-state {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: 0;
            text-align: center;
            padding: 3rem 2rem;
        }
        
        .btn-primary-custom {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 50%, #1e40af 100%);
            border: none;
            border-radius: 10px;
            padding: 12px 24px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3);
        }

        .debug-info {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 1rem;
            font-size: 0.875rem;
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
                        <a class="nav-link active" href="{{ route('peserta.program') }}">
                            <i class="bi bi-journal-text me-1"></i>Program
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
            <!-- Page Header -->
            <div class="card page-header">
                <div class="card-body p-5 text-center">
                    <div class="program-icon">
                        <i class="bi bi-journal-bookmark"></i>
                    </div>
                    <h1 class="fw-bold mb-3">Program Saya</h1>
                    <p class="text-muted mb-0">
                        Berikut adalah daftar program pelatihan yang Anda ikuti
                    </p>
                </div>
            </div>
            @if($registrations->count() > 0)
                <!-- Program List -->
                <div class="row">
                    @foreach($registrations as $registration)
                        <div class="col-lg-6 mb-4">
                            <div class="card program-card h-100">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        @if($registration->program && isset($registration->program->title))
    <h4 class="fw-bold text-primary mb-2">
        {{ $registration->program->title }}
    </h4>
@endif
                                        <h5 class="fw-bold mb-0">
                                            {{ $registration->program ? $registration->program->program_name : 'Program tidak ditemukan' }}
                                        </h5>
                                        <span class="status-badge {{ $registration->status_badge_class }}">
                                            <i class="{{ $registration->status_icon }} me-1"></i>{{ $registration->status_display }}
                                        </span>
                                    </div>
                                    
                                    <p class="text-muted mb-3">
                                        {{ $registration->program ? ($registration->program->description ?? 'Deskripsi program tidak tersedia') : 'Program telah dihapus atau tidak tersedia' }}
                                    </p>
                                    
                                    <div class="row g-2 mb-3 small">
                                        <div class="col-6">
                                            <strong>No. Registrasi:</strong><br>
                                            <span class="text-muted">{{ $registration->registration_number }}</span>
                                        </div>
                                        <div class="col-6">
                                            <strong>Tanggal Daftar:</strong><br>
                                            <span class="text-muted">{{ $registration->registration_date ? $registration->registration_date->format('d M Y') : 'N/A' }}</span>
                                        </div>
                                        <div class="col-6">
                                            <strong>Program ID:</strong><br>
                                            <span class="text-muted">{{ $registration->program_id }}</span>
                                        </div>
                                        @if($registration->program && isset($registration->program->duration))
                                            <div class="col-6">
                                                <strong>Durasi:</strong><br>
                                                <span class="text-muted">{{ $registration->program->duration }} hari</span>
                                            </div>
                                        @endif
                                        @if($registration->program && isset($registration->program->level))
                                            <div class="col-6">
                                                <strong>Level:</strong><br>
                                                <span class="text-muted">{{ $registration->program->level }}</span>
                                            </div>
                                        @endif
                                        @if($registration->program && isset($registration->program->instructor))
                                            <div class="col-6">
                                                <strong>Instruktur:</strong><br>
                                                <span class="text-muted">{{ $registration->program->instructor }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    @if($registration->program && $registration->status == 'disetujui')
                                        <div class="d-grid">
<a href="{{ route('peserta.program.show', $registration->program_id) }}" class="btn btn-primary-custom text-white">
    <i class="bi bi-play-circle me-2"></i>Mulai Pelatihan
</a>

                                        </div>
                                    @elseif($registration->status == 'menunggu')
                                        <div class="alert alert-warning small mb-0">
                                            <i class="bi bi-info-circle me-2"></i>
                                            Menunggu verifikasi admin. Anda akan mendapat notifikasi setelah diverifikasi.
                                        </div>
                                                @elseif($registration->status == 'diterima')
                                        <div class="alert alert-warning small mb-0">
                                            <i class="bi bi-info-circle me-2"></i>
                                            Pelatihan Telah Dikerjakan.
                                        </div>
                                                          @elseif($registration->status == 'gagal')
                                        <div class="alert alert-danger small mb-0">
                                            <i class="bi bi-info-circle me-2"></i>
                                            Anda Gagal. Hubungi Admin untuk informasi lebih lanjut.
                                        </div>
                                    @elseif(!$registration->program)
                                        <div class="alert alert-secondary small mb-0">
                                            <i class="bi bi-exclamation-triangle me-2"></i>
                                            Program tidak tersedia atau telah dihapus.
                                        </div>
                                    @else
                                        <div class="alert alert-danger small mb-0">
                                            <i class="bi bi-exclamation-triangle me-2"></i>
                                            Registrasi ditolak. Silakan hubungi admin untuk informasi lebih lanjut.
                                            @if($registration->notes)
                                                <br><small><strong>Catatan:</strong> {{ $registration->notes }}</small>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="empty-state">
                    <div class="program-icon">
                        <i class="bi bi-journal-x"></i>
                    </div>
                    <h3 class="fw-bold mb-3">Belum Ada Program</h3>
                    <p class="text-muted mb-4">
                        Anda belum mengikuti program apapun. Silakan daftar program pelatihan untuk memulai pembelajaran.
                    </p>
                    <a href="{{ route('peserta.dashboard') }}" class="btn btn-primary-custom text-white">
                        <i class="bi bi-arrow-left me-2"></i>Kembali ke Dashboard
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>