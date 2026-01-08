<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Ruang Kehidupan', 'slug' => 'kehidupan', 'icon' => '🌱'],
            ['name' => 'Ruang Buku', 'slug' => 'buku', 'icon' => '📚'],
            ['name' => 'Ruang Musik', 'slug' => 'musik', 'icon' => '🎵'],
            ['name' => 'Ruang Film', 'slug' => 'film', 'icon' => '🎬'],
            ['name' => 'Ruang Kesehatan', 'slug' => 'kesehatan', 'icon' => '💚'],
            ['name' => 'Ruang Karir', 'slug' => 'karir', 'icon' => '💼'],
            ['name' => 'Ruang Cinta', 'slug' => 'cinta', 'icon' => '💕'],
            ['name' => 'Ruang Keluarga', 'slug' => 'keluarga', 'icon' => '👨‍👩‍👧‍👦'],
            // New Categories
            ['name' => 'Ruang Pertanyaan', 'slug' => 'pertanyaan', 'icon' => '❓'], // Critical for Q&A page
            ['name' => 'Ruang Psikologi', 'slug' => 'psikologi', 'icon' => '🧠'],
            ['name' => 'Ruang Pendidikan', 'slug' => 'pendidikan', 'icon' => '🎓'],
            ['name' => 'Ruang Kuliner', 'slug' => 'kuliner', 'icon' => '🍳'],
            ['name' => 'Ruang Bisnis', 'slug' => 'bisnis', 'icon' => '💼'],
            ['name' => 'Ruang Wisata', 'slug' => 'wisata', 'icon' => '✈️'],
            ['name' => 'Ruang Olahraga', 'slug' => 'olahraga', 'icon' => '⚽'],
            ['name' => 'Ruang Kecantikan', 'slug' => 'kecantikan', 'icon' => '💄'],
            ['name' => 'Ruang Filsafat', 'slug' => 'filsafat', 'icon' => '🤔'],
            ['name' => 'Ruang Politik', 'slug' => 'politik', 'icon' => '⚖️'],
            ['name' => 'Ruang Keagamaan', 'slug' => 'keagamaan', 'icon' => '🕌'],
            ['name' => 'Ruang Etnis', 'slug' => 'etnis', 'icon' => '🌍'],
            ['name' => 'Ruang Karantina', 'slug' => 'karantina', 'icon' => '🏠'],
            ['name' => 'Lain-lain', 'slug' => 'lain-lain', 'icon' => '✨'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
