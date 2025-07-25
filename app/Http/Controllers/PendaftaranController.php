<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Models\Pelatihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PendaftaranController extends Controller
{
    /**
     * Show the initial form for checking NIK and Nama.
     *
     * @return \Illuminate\View\View
     */
    public function checkForm()
    {
        return view('pendaftaran.check');
    }

    /**
     * Check if the participant is already registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function checkRegistration(Request $request)
    {
        $request->validate([
            'nik' => 'required|string|max:20',
            'nama_lengkap' => 'required|string|max:255',
        ]);

        $existingPendaftar = Pendaftaran::where('nik', $request->nik)
                                        ->where('nama_lengkap', $request->nama_lengkap)
                                        ->first();

        if ($existingPendaftar) {
            return redirect()->route('pendaftaran.checkForm')
                             ->withErrors(['already_registered' => 'Anda sudah terdaftar dengan NIK dan Nama tersebut.'])
                             ->withInput();
        } else {
            // If not registered, proceed to the full registration form with a success flash message
            return redirect()->route('pendaftaran.create', ['nik' => $request->nik, 'nama_lengkap' => $request->nama_lengkap])
                             ->with('new_registration', 'Anda belum terdaftar. Silakan lengkapi formulir pendaftaran.');
        }
    }

    /**
     * Show the form for creating a new resource (full registration).
     *
     * @return \Illuminate\View\View
     */
    public function create(Request $request, $nik, $nama_lengkap)
    {
        $pelatihans = Pelatihan::all();
        return view('pendaftaran.create', compact('pelatihans', 'nik', 'nama_lengkap'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_pelatihan' => 'required|exists:pelatihan,id_pelatihan',
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:pendaftarans,email',
            'nik' => 'required|string|max:20|unique:pendaftarans,nik',
            'tanggal_lahir' => 'nullable|date',
            'url_foto_ijasah' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'url_foto_ktp' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->except(['_token', 'url_foto_ijasah', 'url_foto_ktp']);
        $data['status_verifikasi'] = 'Menunggu Verifikasi'; // Corrected capitalization
        $data['is_verified'] = false; // Ensure is_verified is false by default

        DB::transaction(function () use ($request, &$data) {
            if ($request->hasFile('url_foto_ijasah')) {
                $data['url_foto_ijasah'] = Storage::url($request->file('url_foto_ijasah')->store('public/ijasah'));
            }

            if ($request->hasFile('url_foto_ktp')) {
                $data['url_foto_ktp'] = Storage::url($request->file('url_foto_ktp')->store('public/ktp'));
            }

            Pendaftaran::create($data);
        });

        return redirect()->route('pendaftaran.sukses')->with('success', 'Pendaftaran Anda berhasil!');
    }
}
