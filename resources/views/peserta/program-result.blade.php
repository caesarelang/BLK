<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Ujian - {{ $program_name }} - {{ config('app.name') }}</title>
    
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        body {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 50%, #1e40af 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .result-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
            border: 0;
            overflow: hidden;
        }
        
        .score-circle {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            font-weight: bold;
            color: white;
            margin: 0 auto 1rem;
        }
        
        .score-passed {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            box-shadow: 0 10px 30px rgba(16, 185, 129, 0.3);
        }
        
        .score-failed {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            box-shadow: 0 10px 30px rgba(239, 68, 68, 0.3);
        }
        
        .status-badge {
            padding: 12px 24px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1.1rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .status-passed {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
        }
        
        .status-failed {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
        }
        
        .stats-card {
            background: rgba(255, 255, 255, 0.8);
            border-radius: 15px;
            padding: 1.5rem;
            text-align: center;
            border: 2px solid rgba(59, 130, 246, 0.1);
            transition: all 0.3s ease;
        }
        
        .stats-card:hover {
            border-color: rgba(59, 130, 246, 0.3);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .stats-number {
            font-size: 2.5rem;
            font-weight: bold;
            color: #3b82f6;
        }
        
        .btn-action {
            border-radius: 12px;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-primary-custom {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            border: none;
            color: white;
        }
        
        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3);
        }
        
        .btn-outline-custom {
            border: 2px solid #3b82f6;
            color: #3b82f6;
            background: transparent;
        }
        
        .btn-outline-custom:hover {
            background: #3b82f6;
            color: white;
            transform: translateY(-2px);
        }
        
        .celebration-animation {
            animation: celebrationPulse 2s ease-in-out infinite;
        }
        
        @keyframes celebrationPulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        .confetti {
            position: absolute;
            width: 10px;
            height: 10px;
            background: #f59e0b;
            animation: confetti-fall 3s linear infinite;
        }
        
        @keyframes confetti-fall {
            0% {
                transform: translateY(-100vh) rotate(0deg);
                opacity: 1;
            }
            100% {
                transform: translateY(100vh) rotate(720deg);
                opacity: 0;
            }
        }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Main Result Card -->
            <div class="card result-card">
                <div class="card-body p-5">
                    
                    <!-- Program Info -->
                    <div class="text-center mb-4">
                        <h3 class="fw-bold text-primary mb-2">{{ $program_name }}</h3>
                        <p class="text-muted">Hasil Ujian Program</p>
                    </div>
                    
                    <!-- Score Display -->
                    <div class="text-center mb-5">
                        <div class="score-circle {{ $passed ? 'score-passed' : 'score-failed' }} {{ $passed ? 'celebration-animation' : '' }}">
                            {{ $score }}%
                        </div>
                        
                        <div class="status-badge {{ $passed ? 'status-passed' : 'status-failed' }}">
                            @if($passed)
                                <i class="bi bi-check-circle-fill me-2"></i>LULUS
                            @else
                                <i class="bi bi-x-circle-fill me-2"></i>BELUM LULUS
                            @endif
                        </div>
                    </div>
                    
                    <!-- Statistics -->
                    <div class="row g-4 mb-5">
                        <div class="col-md-4">
                            <div class="stats-card">
                                <div class="stats-number text-success">{{ $jawaban_benar }}</div>
                                <div class="fw-semibold text-muted">Jawaban Benar</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="stats-card">
                                <div class="stats-number text-danger">{{ $jawaban_salah ?? ($total_soal - $jawaban_benar) }}</div>
                                <div class="fw-semibold text-muted">Jawaban Salah</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="stats-card">
                                <div class="stats-number text-primary">{{ $total_soal }}</div>
                                <div class="fw-semibold text-muted">Total Soal</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Result Message -->
                    <div class="text-center mb-4">
                        @if($passed)
                            <div class="alert alert-success border-0" style="background: rgba(16, 185, 129, 0.1); border-radius: 15px;">
                                <i class="bi bi-trophy-fill text-warning me-2" style="font-size: 1.5rem;"></i>
                                <h5 class="fw-bold mb-2">Selamat! Anda Berhasil Lulus</h5>
                                <p class="mb-0">Anda telah menyelesaikan ujian dengan score {{ $score }}%. Status pendaftaran Anda telah diperbarui menjadi <strong>"Diterima"</strong>.</p>
                            </div>
                        @else
                            <div class="alert alert-danger border-0" style="background: rgba(239, 68, 68, 0.1); border-radius: 15px;">
                                <i class="bi bi-exclamation-triangle-fill me-2" style="font-size: 1.5rem;"></i>
                                <h5 class="fw-bold mb-2">Mohon Maaf, Anda Belum Lulus</h5>
                                <p class="mb-2">Score Anda {{ $score }}% belum mencapai batas minimum 80%.</p>
                                <p class="mb-0"><small class="text-muted">Silakan hubungi administrator untuk informasi lebih lanjut mengenai ujian ulang.</small></p>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="text-center">
                        <a href="{{ route('peserta.program') }}" class="btn btn-primary-custom btn-action me-3">
                            <i class="bi bi-house-fill me-2"></i>Kembali ke Dashboard
                        </a>
                        
                        @if($passed)
                            <button class="btn btn-outline-custom btn-action" onclick="window.print()">
                                <i class="bi bi-printer me-2"></i>Cetak Sertifikat
                            </button>
                        @endif
                    </div>
                    
                </div>
            </div>
            
            <!-- Additional Info Card -->
            <div class="card result-card mt-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3"><i class="bi bi-info-circle me-2"></i>Informasi Tambahan</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-2"><strong>Tanggal Ujian:</strong> {{ now()->format('d M Y, H:i') }}</p>
                            <p class="mb-2"><strong>Peserta:</strong> {{ $user->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-2"><strong>Program:</strong> {{ $program_name }}</p>
                            <p class="mb-2"><strong>Status:</strong> 
                                <span class="badge {{ $passed ? 'bg-success' : 'bg-danger' }}">
                                    {{ $passed ? 'Diterima' : 'Gagal' }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if($passed)
<!-- Confetti Animation for Passed Students -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Create confetti effect
    function createConfetti() {
        const colors = ['#f59e0b', '#10b981', '#3b82f6', '#ef4444', '#8b5cf6'];
        
        for(let i = 0; i < 50; i++) {
            setTimeout(() => {
                const confetti = document.createElement('div');
                confetti.className = 'confetti';
                confetti.style.left = Math.random() * 100 + 'vw';
                confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
                confetti.style.animationDelay = Math.random() * 3 + 's';
                confetti.style.animationDuration = (Math.random() * 3 + 2) + 's';
                
                document.body.appendChild(confetti);
                
                setTimeout(() => {
                    confetti.remove();
                }, 5000);
            }, i * 50);
        }
    }
    
    // Start confetti after page load
    setTimeout(createConfetti, 500);
});
</script>
@endif

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>