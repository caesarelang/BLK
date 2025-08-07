<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

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
    }

    public function verifiedRegistrations()
    {
        $registrations = Registration::where('status', 'Approved')->with('program')->get();
        return view('admin.peserta.verified', compact('registrations'));
    }

    public function verifyRegistrations()
    {
        $registrations = Registration::where('status', 'Pending')->with('program')->get();
        return view('admin.peserta.verify', compact('registrations'));
    }

    public function updateRegistrationStatus(Request $request, Registration $registration)
    {
        try {
            $request->validate([
                'status' => 'required|in:Approved,Rejected',
                // 'catatan_admin' => 'nullable|string|max:1000', // This column is not in the new schema
            ]);

            $registration->status = $request->status;
            // $registration->is_verified = ($request->status === 'Approved'); // Handled by status column
            // $registration->catatan_admin = $request->catatan_admin; // This column is not in the new schema
            $registration->save();

            $message = ($request->status === 'Approved') ? 'Registrasi berhasil diverifikasi.' : 'Registrasi berhasil ditolak.';

            return redirect()->route('admin.verifikasi.peserta')->with('success', $message);
        } catch (ValidationException $e) {
            return redirect()->back()->with('error', 'Validasi gagal. Mohon periksa kembali masukan Anda.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
