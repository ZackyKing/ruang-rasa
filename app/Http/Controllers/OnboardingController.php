<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OnboardingController extends Controller
{
    public function show()
    {
        $topics = [
            // Column 1
            ['name' => 'Kehidupan', 'slug' => 'kehidupan'],
            ['name' => 'Wisata', 'slug' => 'wisata'],
            ['name' => 'Film', 'slug' => 'film'],
            ['name' => 'Buku', 'slug' => 'buku'],
            ['name' => 'Musik', 'slug' => 'musik'],
            ['name' => 'Olahraga', 'slug' => 'olahraga'],
            ['name' => 'Kesehatan', 'slug' => 'kesehatan'],
            ['name' => 'Memasak', 'slug' => 'memasak'],
            ['name' => 'Psikologi', 'slug' => 'psikologi'],
            ['name' => 'Filsafat', 'slug' => 'filsafat'],
            ['name' => 'Pendidikan', 'slug' => 'pendidikan'],
            ['name' => 'Politik', 'slug' => 'politik'],
            ['name' => 'Kuliner', 'slug' => 'kuliner'],
            ['name' => 'Keagamaan', 'slug' => 'keagamaan'],
            ['name' => 'Bisnis', 'slug' => 'bisnis'],
            ['name' => 'Lain-Lain...', 'slug' => 'lain-lain', 'highlight' => true],
        ];

        return view('auth.interests', compact('topics'));
    }

    public function save(Request $request)
    {
        // Validation: require at least 5 topics
        $request->validate([
            'topics' => 'required|array|min:5',
        ]);

        // Logic to save user interests would go here

        return redirect()->route('home')->with('success', 'Minat berhasil disimpan!');
    }
}
