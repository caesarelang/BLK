<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Models\Pelatihan;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function pelatihan()
    {
        $pelatihans = Pelatihan::orderBy('created_at', 'desc')->get();
        return view('admin.pelatihan.index', compact('pelatihans'));
    }

    public function verifiedParticipants()
    {
        $peserta = Pendaftaran::where('status_verifikasi', 'Terverifikasi')->with('pelatihan')->get();
        return view('admin.peserta.verified', compact('peserta'));
    }

    public function verifyParticipants()
    {
        $peserta = Pendaftaran::where('status_verifikasi', 'Menunggu Verifikasi')->with('pelatihan')->get();
        return view('admin.peserta.verify', compact('peserta'));
    }

    public function updateVerification(Request $request, Pendaftaran $pendaftaran)
    {
        try {
            $request->validate([
                'status' => 'required|in:Terverifikasi,Ditolak',
                'catatan_admin' => 'nullable|string|max:1000',
            ]);

            $pendaftaran->status_verifikasi = $request->status;
            $pendaftaran->is_verified = ($request->status === 'Terverifikasi');
            $pendaftaran->catatan_admin = $request->catatan_admin;
            $pendaftaran->save();

            $message = ($request->status === 'Terverifikasi') ? 'Peserta berhasil diverifikasi.' : 'Peserta berhasil ditolak.';

            return redirect()->route('admin.verifikasi.peserta')->with('success', $message);
        } catch (ValidationException $e) {
            // If validation fails, Laravel automatically redirects back with errors.
            // We can add a generic error message here if needed, but validation errors are usually handled by Laravel's default error bag.
            return redirect()->back()->with('error', 'Validasi gagal. Mohon periksa kembali masukan Anda.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
