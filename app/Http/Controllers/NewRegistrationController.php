<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Participant;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class NewRegistrationController extends Controller
{
    public function index()
    {
        $programs = Program::where('status', 'Buka')->get();
        return view('registration.new-registration', compact('programs'));
    }
public function store(Request $request)
{
    \Log::info('Form Data Received:', $request->all());
    
    try {
        $validated = $request->validate([
            'program_id' => 'required|exists:programs,program_id',
            'nik' => 'required|string|size:16|unique:participants,nik',
            'full_name' => 'required|string|min:3',
            'email' => 'required|email|unique:participants,email|unique:users,email',
            'phone_number' => 'required|string|min:10|max:15',
            'address' => 'required|string|min:10',
            'date_of_birth' => 'required|date|before:today',
            'last_education' => 'required|in:SD,SMP,SMA,SMK,D3,S1,S2,S3',
            'jenis_kelamin' => 'required|in:L,P',
            'ktp_file' => 'required|file|image|mimes:jpg,jpeg,png|max:2048',
            'pas_foto_file' => 'required|file|image|mimes:jpg,jpeg,png|max:2048',
            'ijazah_file' => 'required|file|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        DB::beginTransaction();

        // Upload files ke Supabase
        $paths = $this->uploadFiles($request, $validated['nik']);

        // 1. Buat participant
        $participant = Participant::create([
            'nik' => $validated['nik'],
            'full_name' => $validated['full_name'],
            'email' => $validated['email'],
            'phone_number' => $validated['phone_number'],
            'address' => $validated['address'],
            'date_of_birth' => $validated['date_of_birth'],
            'last_education' => $validated['last_education'],
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'ktp_url' => $paths['ktp_url'],
            'pas_foto_url' => $paths['pas_foto_url'],
            'ijazah_url' => $paths['ijazah_url'],
        ]);

        // 2. Buat registration
        $registration = Registration::create([
            'participant_id' => $participant->participant_id,
            'program_id' => $validated['program_id'],
            'registration_number' => 'REG-' . now()->format('Ym') . '-' . strtoupper(Str::random(6)),
            'status' => 'menunggu',
            'registration_date' => now(),
        ]);

        // 3. Buat user dengan relasi ke registration
        $user = User::create([
            'name' => $participant->full_name,
            'email' => $participant->email,
            'password' => bcrypt($validated['nik']), // default password = NIK
            'role' => 'participant',
            'is_admin' => false,
            'registration_id' => $registration->registration_id, // link user <-> registration
        ]);

        DB::commit();

        return redirect()->route('registration.success')
            ->with('success_registration', [
                'reg_number' => $registration->registration_number,
                'full_name' => $participant->full_name
            ]);

    } catch (\Illuminate\Validation\ValidationException $ve) {
        foreach ($ve->errors() as $field => $messages) {
            foreach ($messages as $msg) {
                \Log::warning("Validation failed on {$field}: {$msg}");
            }
        }
        return back()->withInput()->withErrors($ve->errors());

    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error('Registration failed: ' . $e->getMessage());
        return back()->withInput()
            ->with('error', 'Terjadi kesalahan saat mendaftar. Silakan coba lagi.');
    }
}



    private function uploadFiles(Request $request, string $nik)
    {
        $supabaseUrl = rtrim(env('SUPABASE_URL'), '/');
        $supabaseKey = env('SUPABASE_SERVICE_ROLE_KEY');
        $supabaseBucket = env('SUPABASE_BUCKET');

        $paths = [];
        $files = ['ktp_file' => '/ktp', 'pas_foto_file' => '/pas', 'ijazah_file' => '/ijazah'];

        foreach ($files as $input => $folder) {
            if ($request->hasFile($input)) {
                $file = $request->file($input);
                $fileName = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) 
                         . '-' . $nik . '-' . time() 
                         . '.' . $file->getClientOriginalExtension();
                $filePath = "{$folder}/{$fileName}";

                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $supabaseKey,
                    'Content-Type' => $file->getMimeType(),
                ])->withBody(
                    file_get_contents($file->getRealPath()), 
                    $file->getMimeType()
                )->post("{$supabaseUrl}/storage/v1/object/{$supabaseBucket}/{$filePath}");

                if ($response->failed()) {
                    throw new \Exception('Failed to upload file: ' . $input);
                }

                $paths[str_replace('_file', '_url', $input)] = 
                    "{$supabaseUrl}/storage/v1/object/public/{$supabaseBucket}/{$filePath}";
            }
        }

        return $paths;
    }
    public function success()
{
    // Ambil data dari session
    $registrationData = session('success_registration');
    
    if (!$registrationData) {
        return redirect()->route('registration.new')
            ->with('error', 'Data registrasi tidak ditemukan.');
    }
    
    return view('registration.success', compact('registrationData'));
}public function check(Request $request) 
{
    // If it's a GET request, show the form
    if ($request->isMethod('get')) {
        return view('registration.check');
    }
    
    // If it's a POST request, process the form
    $request->validate([
        'reg_number' => 'required|string'
    ]);

    $registration = Registration::where('registration_number', $request->reg_number)->first();

    if (!$registration) {
        return back()->with('error', 'Nomor registrasi tidak ditemukan.');
    }

    return view('registration.status', compact('registration'));
}

}