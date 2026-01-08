<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KomunitasController extends Controller
{
    /**
     * Show the community/kategori selection page
     */
    public function index()
    {
        $categories = [
            // Left column
            ['name' => 'Kehidupan', 'slug' => 'kehidupan', 'highlight' => false],
            ['name' => 'Film', 'slug' => 'film', 'highlight' => false],
            ['name' => 'Musik', 'slug' => 'musik', 'highlight' => false],
            ['name' => 'Kesehatan', 'slug' => 'kesehatan', 'highlight' => false],
            ['name' => 'Psikologi', 'slug' => 'psikologi', 'highlight' => false],
            ['name' => 'Pendidikan', 'slug' => 'pendidikan', 'highlight' => false],
            ['name' => 'Kuliner', 'slug' => 'kuliner', 'highlight' => false],
            ['name' => 'Bisnis', 'slug' => 'bisnis', 'highlight' => false],
            // Right column
            ['name' => 'Wisata', 'slug' => 'wisata', 'highlight' => false],
            ['name' => 'Buku', 'slug' => 'buku', 'highlight' => false],
            ['name' => 'Olahraga', 'slug' => 'olahraga', 'highlight' => false],
            ['name' => 'Kecantikan', 'slug' => 'kecantikan', 'highlight' => false],
            ['name' => 'Filsafat', 'slug' => 'filsafat', 'highlight' => false],
            ['name' => 'Politik', 'slug' => 'politik', 'highlight' => false],
            ['name' => 'Keagamaan', 'slug' => 'keagamaan', 'highlight' => false],
            ['name' => 'Lain-Lain...', 'slug' => 'lain-lain', 'highlight' => true],
        ];

        return view('komunitas', compact('categories'));
    }
}
