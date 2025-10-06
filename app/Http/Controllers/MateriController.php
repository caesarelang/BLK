<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Materi;
use App\Models\User;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MateriController extends Controller
{
    /**
     * Show the participant's programs.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get registration based on user's registration_id, then load the program
        $registration = null;
        if ($user->registration_id) {
            $registration = Registration::with(['program'])
                ->where('registration_id', $user->registration_id)
                ->first();
        }
        
        // Convert single registration to collection for consistent blade template
        $registrations = $registration ? collect([$registration]) : collect([]);
        
        return view('peserta.program', compact('user', 'registrations'));
    }

    /**
     * Show details of a specific program.
     */
    public function show($id)
    {
        $user = Auth::user();
        
        // Debug logging first
        Log::info('=== DEBUG PROGRAM DETAIL ===');
        Log::info('User ID: ' . $user->id);
        Log::info('Program ID: ' . $id);
        Log::info('User Registration ID: ' . ($user->registration_id ?? 'NULL'));
        
        // Check if program exists first
        $program = Program::find($id);
        if (!$program) {
            Log::error('Program not found with ID: ' . $id);
            abort(404, 'Program tidak ditemukan');
        }
        Log::info('Program found: ' . $program->title);
        
        // Check all registrations for this user
        $userRegistrations = Registration::where('registration_id', $user->registration_id)->get();
        Log::info('All user registrations count: ' . $userRegistrations->count());
        Log::info('User registrations: ', $userRegistrations->toArray());
        
        // Check specific registration for this program
        $registration = Registration::with('program')
            ->where('registration_id', $user->registration_id)
            ->where('program_id', $id)
            ->first(); // Remove status filter and firstOrFail for debugging
        
        Log::info('Registration found: ' . ($registration ? 'Yes' : 'No'));
        if ($registration) {
            Log::info('Registration status: ' . $registration->status);
        }
        
        // If no registration found, let's check what registrations exist for this program
        if (!$registration) {
            $programRegistrations = Registration::where('program_id', $id)->get();
            Log::info('All registrations for program ' . $id . ': ', $programRegistrations->toArray());
            
            // For testing, create a dummy registration
            $registration = new \stdClass();
            $registration->program_id = $id;
            $registration->participant_id = $user->id;
            $registration->status = 'disetujui';
            $registration->program = $program;
            
            Log::info('Created dummy registration for testing');
        }
        
        // Get all questions from this program
        $soal = Materi::where('program_id', $id)->get();
        
        // Debug materi
        Log::info('=== MATERI DEBUG ===');
        Log::info('Questions count for program ' . $id . ': ' . $soal->count());
        Log::info('SQL Query: ' . Materi::where('program_id', $id)->toSql());
        Log::info('Questions data: ', $soal->toArray());
        
        // Check all materi
        $allMateri = Materi::all();
        Log::info('Total materi in database: ' . $allMateri->count());
        if ($allMateri->count() > 0) {
            Log::info('All materi program_ids: ', $allMateri->pluck('program_id')->unique()->toArray());
            Log::info('Sample materi data: ', $allMateri->first()->toArray());
        }
        
        return view('peserta.program-detail', compact('user', 'registration', 'soal'));
    }

    public function submitAnswers(Request $request, $id)
    {
        $user = Auth::user();
        
        // Debug logging
        Log::info('=== SUBMIT ANSWERS DEBUG ===');
        Log::info('User ID: ' . $user->id);
        Log::info('Program ID: ' . $id);
        Log::info('Request data: ', $request->all());
        
        // Verify user has access to this program (remove strict status check for testing)
        $registration = Registration::with('program')
            ->where('registration_id', $user->registration_id)
            ->where('program_id', $id)
            ->first(); // Remove status filter for testing
        
        if (!$registration) {
            Log::error('No registration found for user ' . $user->id . ' and program ' . $id);
            return redirect()->route('peserta.program')
                ->with('error', 'Anda tidak memiliki akses ke program ini.');
        }
        
        Log::info('Registration found for submit: ', $registration->toArray());
        
        // Get all questions for this program
        $soal = Materi::where('program_id', $id)->get();
        
        if ($soal->isEmpty()) {
            Log::error('No questions found for program ' . $id);
            return redirect()->back()->with('error', 'Tidak ada soal untuk program ini.');
        }
        
        Log::info('Questions found: ' . $soal->count());
        
        // Validate that all questions are answered
        try {
            $request->validate([
                'jawaban' => 'required|array|min:' . $soal->count(),
                'jawaban.*' => 'required|in:A,B,C,D'
            ]);
        } catch (\Exception $e) {
            Log::error('Validation error: ' . $e->getMessage());
            return redirect()->back()
                ->withErrors($e->getMessages())
                ->withInput();
        }
        
        $jawaban_user = $request->input('jawaban', []);
        $score = 0;
        $total_soal = $soal->count();
        $jawaban_benar = 0;
        $jawaban_salah = 0;
        
        // Process each question
        foreach ($soal as $s) {
            $user_answer = $jawaban_user[$s->materi_id] ?? null;
            $correct_answer = $s->jawaban; // Enum A/B/C/D dari database
            
            if ($user_answer && $user_answer === $correct_answer) {
                $jawaban_benar++;
            } else {
                $jawaban_salah++;
            }
        }
        
        // Calculate score (percentage)
        $score = $total_soal > 0 ? round(($jawaban_benar / $total_soal) * 100, 2) : 0;
        $passed = $score >= 80;
        
        Log::info('Score calculated: ' . $score . '%, Passed: ' . ($passed ? 'Yes' : 'No'));
        
        // Update registration status based on score
        if ($passed && is_object($registration) && method_exists($registration, 'save')) {
            $registration->status = 'diterima';
            $registration->save();
            Log::info('Registration status updated to diterima');
        }
        elseif (!$passed && is_object($registration) && method_exists($registration, 'save')) {
            $registration->status = 'gagal';
            $registration->save();
            Log::info('Registration status updated to gagal');
        } else {
            Log::warning('Registration object is not valid for status update');
        }
        
        // Simpan hasil ujian ke session
        session()->put([
            'score' => $score,
            'jawaban_benar' => $jawaban_benar,
            'jawaban_salah' => $jawaban_salah,
            'total_soal' => $total_soal,
            'program_name' => $registration->program->title ?? 'Program Test',
            'passed' => $passed
        ]);

        Log::info('Session data saved, redirecting to result page');
        Log::info('Redirect URL: ' . route('peserta.program.result', $id));

        return redirect()->route('peserta.program.result', ['id' => $id]);
    }

    public function showResult($id)
    {
        $user = Auth::user();
        
        // Debug logging
        Log::info('=== SHOW RESULT DEBUG ===');
        Log::info('User ID: ' . $user->id);
        Log::info('Program ID: ' . $id);
        Log::info('Session data: ', session()->all());
        
        // Verify access - allow both 'disetujui' and 'diterima' status (remove strict check for testing)
        $registration = Registration::with('program')
            ->where('registration_id', $user->registration_id)
            ->where('program_id', $id)
            ->first(); // Remove status filter for testing
        
        if (!$registration) {
            Log::error('No registration found in showResult for user ' . $user->id . ' and program ' . $id);
            
            // For testing, create a dummy registration
            $program = Program::find($id);
            if ($program) {
                $registration = new \stdClass();
                $registration->program_id = $id;
                $registration->participant_id = $user->id;
                $registration->status = 'disetujui';
                $registration->program = $program;
                Log::info('Created dummy registration for result page');
            } else {
                return redirect()->route('peserta.program')
                    ->with('error', 'Program tidak ditemukan.');
            }
        }
        
        // Ambil data dari session
        $score = session('score');
        $jawaban_benar = session('jawaban_benar');
        $jawaban_salah = session('jawaban_salah');
        $total_soal = session('total_soal');
        $program_name = session('program_name');
        $passed = session('passed');
        
        Log::info('Retrieved from session - Score: ' . $score . ', Total: ' . $total_soal);
        
        // Kalau session kosong (belum submit)
        if (is_null($score) || is_null($total_soal)) {
            Log::error('No session data found, redirecting back to program');
            return redirect()->route('peserta.program.show', $id)
                ->with('error', 'Tidak ada data hasil ujian. Silakan mengerjakan ujian terlebih dahulu.');
        }

        // Hapus session setelah ditampilkan
        session()->forget(['score', 'jawaban_benar', 'jawaban_salah', 'total_soal', 'program_name', 'passed']);
        
        Log::info('Showing result page with score: ' . $score);
        
        return view('peserta.program-result', compact(
            'user', 
            'registration', 
            'score', 
            'jawaban_benar', 
            'jawaban_salah',
            'total_soal', 
            'program_name',
            'passed'
        ));
    }
}