<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Materi;
use App\Models\Program;
use Illuminate\Http\Request;

class SoalController extends Controller
{
    public function index(Request $request)
    {
        $programs = Program::all();
        $selectedProgramId = $request->get('program_id');
        
        if ($selectedProgramId) {
            $materi = Materi::with('program')->where('program_id', $selectedProgramId)->latest()->paginate(10);
            $selectedProgram = Program::find($selectedProgramId);
        } else {
            $materi = collect();
            $selectedProgram = null;
        }
        
        return view('admin.soal.index', compact('materi', 'programs', 'selectedProgramId', 'selectedProgram'));
    }

    public function create(Request $request)
    {
        $selectedProgramId = $request->get('program_id');
        $programs = Program::all();
        return view('admin.soal.create', compact('programs', 'selectedProgramId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'program_id' => 'required|exists:programs,program_id',
            'soal' => 'required|string|min:5',
            'jawaban' => 'required|in:A,B,C,D',
        ]);

        Materi::create($request->all());

        return redirect()->route('admin.soal.index', ['program_id' => $request->program_id])
            ->with('success', 'Soal berhasil ditambahkan.');
    }

    public function edit(Materi $materi)
    {
        $programs = Program::all();
        return view('admin.soal.edit', compact('materi', 'programs'));
    }

    public function update(Request $request, Materi $materi)
    {
        $request->validate([
            'program_id' => 'required|exists:programs,program_id',
            'soal' => 'required|string|min:5',
            'jawaban' => 'required|in:A,B,C,D',
        ]);

        $materi->update($request->all());

        return redirect()->route('admin.soal.index', ['program_id' => $request->program_id])
            ->with('success', 'Soal berhasil diperbarui.');
    }

    public function destroy(Materi $materi)
    {
        $materi->delete();
        $programId = $materi->program_id;
        $materi->delete();
        return redirect()->route('admin.soal.index', ['program_id' => $programId])
            ->with('success', 'Soal berhasil dihapus.');
    }
}
