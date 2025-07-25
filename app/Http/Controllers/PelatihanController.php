<?php

namespace App\Http\Controllers;

use App\Models\Pelatihan;
use Illuminate\Http\Request;

class PelatihanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pelatihans = Pelatihan::all();
        return view('admin.pelatihan.index', compact('pelatihans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pelatihan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama_pelatihan' => 'required|string|max:255',
                'deskripsi' => 'nullable|string',
                'tanggal_mulai' => 'required|date',
                'tanggal_berakhir' => 'required|date',
                'lokasi' => 'required|string|max:255',
                'kuota' => 'required|integer|min:1',
                'url_foto_pelatihan' => 'nullable|string|max:255',
            ]);

            Pelatihan::create($request->all());

            return redirect()->route('admin.pelatihan.index')->with('success', 'Pelatihan berhasil ditambahkan.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan pelatihan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id_pelatihan)
    {
        $pelatihan = Pelatihan::findOrFail($id_pelatihan);
        return view('pelatihan.show', compact('pelatihan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id_pelatihan)
    {
        $pelatihan = Pelatihan::findOrFail($id_pelatihan);
        return view('admin.pelatihan.edit', compact('pelatihan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id_pelatihan)
    {
        try {
            $request->validate([
                'nama_pelatihan' => 'required|string|max:255',
                'deskripsi' => 'nullable|string',
                'tanggal_mulai' => 'required|date',
                'tanggal_berakhir' => 'required|date',
                'lokasi' => 'required|string|max:255',
                'kuota' => 'required|integer|min:1',
                'url_foto_pelatihan' => 'nullable|string|max:255',
            ]);

            $pelatihan = Pelatihan::findOrFail($id_pelatihan);
            $pelatihan->update($request->all());

            return redirect()->route('admin.pelatihan.index')->with('success', 'Pelatihan berhasil diperbarui.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui pelatihan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id_pelatihan)
    {
        try {
            $pelatihan = Pelatihan::findOrFail($id_pelatihan);
            $pelatihan->delete();

            return redirect()->route('admin.pelatihan.index')->with('success', 'Pelatihan berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus pelatihan: ' . $e->getMessage());
        }
    }

    /**
     * Display a listing of training courses for the public.
     */
    public function kejuruan()
    {
        $pelatihans = Pelatihan::all(); // Mengambil semua data pelatihan
        return view('kejuruan', compact('pelatihans')); // Mengirim data ke view kejuruan.blade.php
    }
}
