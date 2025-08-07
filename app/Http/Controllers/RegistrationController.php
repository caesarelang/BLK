<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use App\Models\Program;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; // <-- Menggunakan HTTP Client Laravel
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Arr;

class RegistrationController extends Controller
{
    // ... (Metode createStep1, storeStep1, createStep2, storeStep2, createStep3 tetap sama) ...
    public function createStep1()
    {
        $data = Session::get('registration_data', []);
        return view('registration.step1', compact('data'));
    }

    public function storeStep1(Request $request)
    {
        $validated = $request->validate([
            'nik' => 'required|string|digits:16',
            'full_name' => 'required|string|min:3|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'required|string|min:10|max:15',
        ]);

        if (Participant::where('nik', $validated['nik'])->exists()) {
            throw ValidationException::withMessages(['nik' => 'NIK yang Anda masukkan sudah terdaftar dalam sistem.']);
        }
        if (Participant::where('email', $validated['email'])->exists()) {
            throw ValidationException::withMessages(['email' => 'Email yang Anda masukkan sudah terdaftar dalam sistem.']);
        }

        Session::put('registration_data', array_merge(Session::get('registration_data', []), $validated));
        return redirect()->route('registration.create.step2');
    }

    public function createStep2()
    {
        if (!Session::has('registration_data.nik')) {
            return redirect()->route('registration.create.step1')->with('error', 'Silakan lengkapi Langkah 1 terlebih dahulu.');
        }
        $data = Session::get('registration_data', []);
        $programs = Program::where('status', 'Buka')->get();
        return view('registration.step2', compact('data', 'programs'));
    }

    public function storeStep2(Request $request)
    {
        $validated = $request->validate([
            'date_of_birth' => 'required|date',
            'address' => 'required|string|min:10',
            'program_id' => 'required|exists:programs,program_id',
            'last_education' => 'required|string',
        ]);
        Session::put('registration_data', array_merge(Session::get('registration_data', []), $validated));
        return redirect()->route('registration.create.step3');
    }
    
    public function createStep3()
    {
        if (!Session::has('registration_data.program_id')) {
            return redirect()->route('registration.create.step2')->with('error', 'Silakan lengkapi Langkah 2 terlebih dahulu.');
        }
        $data = Session::get('registration_data', []);
        return view('registration.step3', compact('data'));
    }

    /**
     * Store Step 3 Data: Document Upload directly to Supabase.
     */
    public function storeStep3(Request $request)
    {
        $request->validate([
            'ktp_file' => 'required|file|image|mimes:jpg,jpeg,png|max:2048',
            'pas_foto_file' => 'required|file|image|mimes:jpg,jpeg,png|max:2048',
            'ijazah_file' => 'required|file|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = Session::get('registration_data');
        $nik = $data['nik'];
        $paths = [];

        // Ambil konfigurasi Supabase dari .env
        $supabaseUrl = rtrim(env('SUPABASE_URL'), '/');
        $supabaseKey = env('SUPABASE_SERVICE_ROLE_KEY');
        $supabaseBucket = env('SUPABASE_BUCKET');

        // Struktur folder tujuan
        $pathMappings = [
            'ktp_file' => '/ktp',
            'pas_foto_file' => '/pas',
            'ijazah_file' => '/ijazah',
        ];

        foreach ($pathMappings as $key => $folder) {
            if ($request->hasFile($key)) {
                $file = $request->file($key);
                $fileName = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '-' . $nik . '-' . time() . '.' . $file->getClientOriginalExtension();
                $filePath = "{$folder}/{$fileName}";

                // Kirim file ke Supabase Storage API
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $supabaseKey,
                    'Content-Type' => $file->getMimeType(),
                ])->withBody(
                    file_get_contents($file->getRealPath()), $file->getMimeType()
                )->post("{$supabaseUrl}/storage/v1/object/{$supabaseBucket}/{$filePath}");

                if ($response->failed()) {
                    // Jika gagal, kembali dengan error
                    return back()->with('error', 'Gagal mengunggah file. Silakan coba lagi.');
                }
                
                // Simpan URL publik dari file yang diunggah
                $paths[str_replace('_file', '_url', $key)] = "{$supabaseUrl}/storage/v1/object/public/{$supabaseBucket}/{$filePath}";
            }
        }

        Session::put('registration_data', array_merge($data, $paths));
        
        return redirect()->route('registration.confirmation');
    }

    // ... (Metode confirmation, store, dan success tetap sama) ...
    public function confirmation()
    {
        if (!Session::has('registration_data.ktp_url')) {
            return redirect()->route('registration.create.step3')->with('error', 'Silakan lengkapi Langkah 3 terlebih dahulu.');
        }
        $data = Session::get('registration_data');
        $program = Program::find($data['program_id']);
        return view('registration.confirmation', compact('data', 'program'));
    }

    public function store(Request $request)
    {
        $data = Session::get('registration_data');
        if (empty($data['nik']) || empty($data['program_id']) || empty($data['ktp_url'])) {
             return redirect()->route('registration.create.step1')->with('error', 'Sesi Anda telah berakhir. Silakan mulai lagi.');
        }

        try {
            $participantData = Arr::only($data, (new Participant)->getFillable());
            $participant = Participant::create($participantData);
            $date = new \DateTime();
            $regNumber = 'REG-' . $date->format('Ym') . '-' . strtoupper(Str::random(6));
            $registration = Registration::create([
                'participant_id' => $participant->participant_id,
                'program_id' => $data['program_id'],
                'registration_number' => $regNumber,
                'status' => 'Pending',
                'registration_date' => $date,
            ]);

            Session::forget('registration_data');
            Session::put('success_registration', [
                'reg_number' => $registration->registration_number,
                'full_name' => $participant->full_name
            ]);

            return redirect()->route('registration.success');
        } catch (\Exception $e) {
            \Log::error('Registration Error: ' . $e->getMessage());
            return redirect()->route('registration.create.step1')->with('error', 'Terjadi kesalahan fatal saat menyimpan data. Silakan coba lagi.');
        }
    }

    public function success()
    {
        if (!Session::has('success_registration')) {
            return redirect()->route('home');
        }
        $data = Session::get('success_registration');
        return view('registration.success', compact('data'));
    }
}
