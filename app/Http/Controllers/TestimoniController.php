<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Testimoni;
use Illuminate\Support\Facades\Auth;

class TestimoniController extends Controller
{
    public function store(Request $request)
{
    $request->validate([
        'rating' => 'required|integer|min:1|max:5',
        'message' => 'required|string|max:100',
    ]);

    Testimoni::create([
        'user_id' => Auth::id(),
        'rating' => $request->rating,
        'message' => $request->message,
        'is_active' => 0
    ]);

    return redirect()->back()->with('success', 'Thank you! Your testimonial has been submitted and will appear once approved.');
}

    
}
