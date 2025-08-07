<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProgramController extends Controller
{
    /**
     * Display a listing of the resource for the admin.
     */
    public function index()
    {
        // Order by the newest programs first
        $programs = Program::orderBy('program_id', 'desc')->get();
        return view('admin.pelatihan.index', compact('programs'));
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
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:Buka,Tutup',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Changed to 'image' for file upload
            'requirements' => 'nullable|string',
            // 'organizer_id' is not in the form, so it's removed for now.
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/programs');
            $validatedData['image_url'] = Storage::url($path);
        }

        Program::create($validatedData);

        return redirect()->route('admin.programs.index')->with('success', 'Program berhasil ditambahkan.');
    }


    /**
     * Display the specified resource.
     * Note: This is typically for public view, not admin.
     */
    public function show(Program $program)
    {
        return view('pelatihan.show', compact('program'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Program $program)
    {
        return view('admin.pelatihan.edit', compact('program'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Program $program)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:Buka,Tutup',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'requirements' => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            // Optional: Delete the old image
            if ($program->image_url) {
                Storage::delete(str_replace('/storage', 'public', $program->image_url));
            }
            $path = $request->file('image')->store('public/programs');
            $validatedData['image_url'] = Storage::url($path);
        }

        $program->update($validatedData);

        return redirect()->route('admin.programs.index')->with('success', 'Program berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Program $program)
    {
        // Optional: Delete the associated image
        if ($program->image_url) {
            Storage::delete(str_replace('/storage', 'public', $program->image_url));
        }
        
        $program->delete();

        return redirect()->route('admin.programs.index')->with('success', 'Program berhasil dihapus.');
    }

    /**
     * Display a listing of training courses for the public.
     */
    public function kejuruan()
    {
        $programs = Program::where('status', 'Buka')->orderBy('start_date', 'asc')->get();
        return view('kejuruan', compact('programs'));
    }
}
