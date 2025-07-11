<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Testimoni;

class TestimoniController extends Controller
{
   public function index()
{
    $testimonis = Testimoni::latest()->paginate(10); // GUNAKAN paginate()
    return view('testimoni.index', compact('testimonis'));
}


    public function toggle($id)
    {
        $testimoni = Testimoni::findOrFail($id);
        $testimoni->is_active = !$testimoni->is_active;
        $testimoni->save();

        return redirect()->back()->with('success', 'Status updated.');
    }

    public function destroy($id)
    {
        Testimoni::destroy($id);
        return redirect()->back()->with('success', 'Testimoni deleted.');
    }
}
