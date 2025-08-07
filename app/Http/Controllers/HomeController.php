<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the home page with FAQs.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $faqs = Faq::all(); // Fetch all FAQs from the database
        return view('home', compact('faqs'));
    }
}
