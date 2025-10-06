<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $registration->program->title ?? 'Detail Program' }} - {{ config('app.name') }}</title>
    
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        body {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 50%, #1e40af 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .question-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: 0;
            margin-bottom: 2rem;
        }
        
        .question-number {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 50%, #1e40af 100%);
            color: white;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-right: 20px;
            font-size: 1.1rem;
        }
        
        .form-check-input:checked {
            background-color: #3b82f6;
            border-color: #3b82f6;
        }
        
        .form-check-label {
            font-size: 1.05rem;
            padding: 12px 20px;
            border-radius: 8px;
            transition: all 0.2s ease;
            cursor: pointer;
            width: 100%;
            margin-left: 10px;
            border: 2px solid transparent;
        }
        
        .form-check-label:hover {
            background-color: rgba(59, 130, 246, 0.1);
            border-color: rgba(59, 130, 246, 0.2);
        }
        
        .form-check {
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }
        
        .btn-submit {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border: none;
            border-radius: 12px;
            padding: 15px 40px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        }
        
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
        }
        
        .header-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: 0;
        }
        
        .option-letter {
            font-weight: bold;
            color: #3b82f6;
            margin-right: 8px;
        }
    </style>
</head>
<body>

<div class="container py-5">
    <!-- Header -->
    <div class="card header-card mb-4">
        <div class="card-body p-4">
            <div class="d-flex align-items-center mb-3">
                <a href="{{ route('peserta.program') }}" class="btn btn-outline-primary me-3">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
                <div>
                    <h2 class="fw-bold mb-1">{{ $registration->program->title }}</h2>
                    <p class="text-muted mb-0">
                        {{ $registration->program->description ?? 'Ujian Program' }} 
                        @if($soal->count() > 0)
                            - {{ $soal->count() }} Soal
                        @endif
                    </p>
                </div>
            </div>
            <div class="alert alert-info mb-0">
                <i class="bi bi-info-circle me-2"></i>
                Pilih salah satu jawaban untuk setiap soal, kemudian klik "Kirim Jawaban" untuk menyelesaikan ujian.
            </div>
        </div>
    </div>

    @if($soal->count() > 0)
        <!-- Questions Form -->
        <form action="{{ route('peserta.program.submit', $registration->program_id) }}" method="POST" id="examForm">
            @csrf
            
            @foreach($soal as $index => $s)
                <!-- Question {{ $index + 1 }} -->
                <div class="card question-card">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-start">
                            <div class="question-number">{{ $index + 1 }}</div>
                            <div class="flex-grow-1">
                                <h5 class="fw-bold mb-4">
                                    {{ $s->soal }}
                                </h5>
                                
                                <div class="form-check">
                                    <input type="radio" name="jawaban[{{ $s->materi_id }}]" value="A" class="form-check-input" id="soal{{ $s->materi_id }}a" required>
                                    <label for="soal{{ $s->materi_id }}a" class="form-check-label">
                                        <span class="option-letter">A.</span> Pilihan A
                                    </label>
                                </div>
                                
                                <div class="form-check">
                                    <input type="radio" name="jawaban[{{ $s->materi_id }}]" value="B" class="form-check-input" id="soal{{ $s->materi_id }}b" required>
                                    <label for="soal{{ $s->materi_id }}b" class="form-check-label">
                                        <span class="option-letter">B.</span> Pilihan B
                                    </label>
                                </div>
                                
                                <div class="form-check">
                                    <input type="radio" name="jawaban[{{ $s->materi_id }}]" value="C" class="form-check-input" id="soal{{ $s->materi_id }}c" required>
                                    <label for="soal{{ $s->materi_id }}c" class="form-check-label">
                                        <span class="option-letter">C.</span> Pilihan C
                                    </label>
                                </div>
                                
                                <div class="form-check">
                                    <input type="radio" name="jawaban[{{ $s->materi_id }}]" value="D" class="form-check-input" id="soal{{ $s->materi_id }}d" required>
                                    <label for="soal{{ $s->materi_id }}d" class="form-check-label">
                                        <span class="option-letter">D.</span> Pilihan D
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <!-- Progress Info -->
            <div class="card question-card">
                <div class="card-body p-4 text-center">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center justify-content-center justify-content-md-start">
                                <i class="bi bi-check-circle text-success me-2" style="font-size: 1.5rem;"></i>
                                <div>
                                    <div class="fw-bold">Progress Ujian</div>
                                    <div class="text-muted small">
                                        <span id="answeredCount">0</span> dari {{ $soal->count() }} soal terjawab
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-submit text-white w-100" id="submitBtn" disabled>
                                <i class="bi bi-send me-2"></i>Kirim Jawaban
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    @else
        <!-- Empty State -->
        <div class="card question-card">
            <div class="card-body p-5 text-center">
                <i class="bi bi-journal-x" style="font-size: 4rem; color: #6b7280;"></i>
                <h3 class="fw-bold mt-3 mb-2">Belum Ada Soal</h3>
                <p class="text-muted mb-4">Program ini belum memiliki soal ujian.</p>
                <a href="{{ route('peserta.program') }}" class="btn btn-outline-primary">
                    <i class="bi bi-arrow-left me-2"></i>Kembali ke Program
                </a>
            </div>
        </div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const totalQuestions = {{ $soal->count() }};
    const answeredCountElement = document.getElementById('answeredCount');
    const submitBtn = document.getElementById('submitBtn');
    
    function updateProgress() {
        const answeredQuestions = new Set();
        
        // Count unique answered questions
        document.querySelectorAll('input[type="radio"]:checked').forEach(radio => {
            const questionId = radio.name.match(/\[(\d+)\]/)[1];
            answeredQuestions.add(questionId);
        });
        
        const answeredCount = answeredQuestions.size;
        answeredCountElement.textContent = answeredCount;
        
        // Enable submit button only if all questions are answered
        if (answeredCount === totalQuestions) {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="bi bi-send me-2"></i>Kirim Jawaban';
        } else {
            submitBtn.disabled = true;
            submitBtn.innerHTML = `<i class="bi bi-clock me-2"></i>Jawab ${totalQuestions - answeredCount} soal lagi`;
        }
    }

    // Add event listeners to all radio buttons
    document.querySelectorAll('input[type="radio"]').forEach(radio => {
        radio.addEventListener('change', function() {
            // Visual feedback
            const questionCard = this.closest('.question-card');
            questionCard.querySelectorAll('.form-check-label').forEach(label => {
                label.style.backgroundColor = '';
                label.style.borderColor = 'transparent';
            });
            
            // Highlight selected option
            if(this.checked) {
                this.nextElementSibling.style.backgroundColor = 'rgba(59, 130, 246, 0.15)';
                this.nextElementSibling.style.borderColor = 'rgba(59, 130, 246, 0.3)';
            }
            
            updateProgress();
        });
    });

    // Form submission confirmation
    document.getElementById('examForm')?.addEventListener('submit', function(e) {
        const answeredQuestions = new Set();
        document.querySelectorAll('input[type="radio"]:checked').forEach(radio => {
            const questionId = radio.name.match(/\[(\d+)\]/)[1];
            answeredQuestions.add(questionId);
        });
        
        if(answeredQuestions.size < totalQuestions) {
            e.preventDefault();
            alert(`Anda belum menjawab semua soal. ${answeredQuestions.size} dari ${totalQuestions} soal terjawab.`);
            return false;
        }
        
        if(!confirm('Apakah Anda yakin ingin mengirim jawaban? Jawaban tidak dapat diubah setelah dikirim.')) {
            e.preventDefault();
            return false;
        }
        
        // Show loading state
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Mengirim...';
    });
    
    // Initialize progress
    updateProgress();
});
</script>

</body>
</html>