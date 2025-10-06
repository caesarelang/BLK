<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function programs()
    {
        $programs = Program::orderBy('created_at', 'desc')->get();
        return view('admin.pelatihan.index', compact('programs'));
    }public function updateStatus(Registration $registration, Request $request)
    {
        $request->validate([
            'status' => 'required|in:diterima,ditolak,disetujui,gagal'
        ]);

        try {
            $oldStatus = $registration->status;
            
            $registration->update([
                'status' => $request->status,
                'status_updated_at' => now(),
                'updated_by' => auth()->id()
            ]);

            // Log aktivitas
            Log::info('Status registrasi diubah', [
                'registration_id' => $registration->id,
                'participant' => $registration->participant->full_name,
                'old_status' => $oldStatus,
                'new_status' => $request->status,
                'admin' => auth()->user()->name
            ]);

            return redirect()->back()->with('success', 
                'Status registrasi berhasil diubah dari "' . $oldStatus . '" menjadi "' . $request->status . '"');

        } catch (\Exception $e) {
            Log::error('Error updating registration status: ' . $e->getMessage());
            
            return redirect()->back()->with('error', 
                'Terjadi kesalahan saat mengubah status registrasi. Silakan coba lagi.');
        }
    }

    /**
     * Memberikan kesempatan ujian ulang untuk registrasi yang gagal
     */
    public function retakeExam(Registration $registration)
    {
        try {
            // Pastikan status saat ini adalah 'gagal'
            if (strtolower($registration->status) !== 'gagal') {
                return redirect()->back()->with('error', 
                    'Ujian ulang hanya dapat diberikan untuk registrasi dengan status "Gagal".');
            }

            $oldStatus = $registration->status;

            // Ubah status menjadi 'disetujui' untuk memberikan kesempatan ujian ulang
            $registration->update([
                'status' => 'disetujui',
                'retake_granted_at' => now(),
                'retake_granted_by' => auth()->id(),
                'status_updated_at' => now()
            ]);

            // Log aktivitas
            Log::info('Ujian ulang diberikan', [
                'registration_id' => $registration->id,
                'participant' => $registration->participant->full_name,
                'previous_status' => $oldStatus,
                'admin' => auth()->user()->name
            ]);

            return redirect()->back()->with('success', 
                'Kesempatan ujian ulang berhasil diberikan kepada ' . $registration->participant->full_name . 
                '. Status telah diubah menjadi "Disetujui".');

        } catch (\Exception $e) {
            Log::error('Error memberikan ujian ulang: ' . $e->getMessage(), [
                'registration_id' => $registration->id,
                'error' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()->with('error', 
                'Terjadi kesalahan saat memberikan kesempatan ujian ulang. Silakan coba lagi.');
        }
    }
    
public function verifiedRegistrations()
{
    $registrations = Registration::whereIn('status', ['disetujui', 'diterima', 'gagal'])->with('program')->get();
    return view('admin.peserta.verified', compact('registrations'));
}

public function verifyRegistrations()
{
    $registrations = Registration::where('status', 'menunggu')->with('program')->get();
    return view('admin.peserta.verify', compact('registrations'));
}

public function updateRegistrationStatus(Request $request, Registration $registration)
{
    try {
        $request->validate([
            'status' => 'required|in:disetujui,ditolak,gagal,diterima,menunggu,tidak diketahui',
        ]);

        $registration->update(['status' => $request->status]);

        $message = match ($request->status) {
            'disetujui' => 'Registrasi berhasil disetujui.',
            'ditolak' => 'Registrasi berhasil ditolak.',
            'gagal' => 'Registrasi gagal.',
            'diterima' => 'Registrasi berhasil diterima.',
            'menunggu' => 'Registrasi masih menunggu.',
            'tidak diketahui' => 'Status registrasi tidak diketahui.',
            default => 'Status diperbarui.',
        };

return redirect()->route('admin.registrations.verify')->with('success', $message);

    } catch (ValidationException $e) {
        return redirect()->back()->with('error', 'Validasi gagal: ' . $e->getMessage());
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
}


}
