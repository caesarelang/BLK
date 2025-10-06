<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource for the public view.
     */
    public function index()
    {
        $faqs = Faq::orderBy('created_at', 'desc')->get();
        return view('faq.index', compact('faqs'));
    }

    /**
     * Display a listing of the resource for the admin view.
     */
    public function adminIndex()
    {
        $faqs = Faq::orderBy('created_at', 'desc')->get();
        return view('admin.faq.index', compact('faqs'));
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $faqs = Faq::orderBy('created_at', 'desc')->get();
        return view('admin.faq.create', compact('faqs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
        ]);

        Faq::create($request->all());

        return redirect()->route('admin.faq.create')->with('success', 'FAQ berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Faq $faq)
    {
        return view('admin.faq.edit', compact('faq'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Faq $faq)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
        ]);

        $faq->update($request->all());

        return redirect()->route('admin.faq.create')->with('success', 'FAQ berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Faq $faq)
    {
        $faq->delete();

        return redirect()->route('admin.faq.create')->with('success', 'FAQ berhasil dihapus.');
    }
}
