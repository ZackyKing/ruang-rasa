<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class MissingCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        echo "🌱 Menambahkan kategori yang missing...\n";

        $categories = [
            ['name' => 'Ruang Psikologi', 'slug' => 'psikologi', 'icon' => '🧠'],
            ['name' => 'Ruang Pendidikan', 'slug' => 'pendidikan', 'icon' => '📚'],
            ['name' => 'Ruang Etnis', 'slug' => 'etnis', 'icon' => '🌍'],
            ['name' => 'Ruang Karantina', 'slug' => 'karantina', 'icon' => '🏠'],
            ['name' => 'Ruang Politik', 'slug' => 'politik', 'icon' => '⚖️'],
            ['name' => 'Ruang Filsafat', 'slug' => 'filsafat', 'icon' => '💭'],
            ['name' => 'Ruang Keagamaan', 'slug' => 'keagamaan', 'icon' => '🕌'],
            ['name' => 'Ruang Olahraga', 'slug' => 'olahraga', 'icon' => '⚽'],
            ['name' => 'Ruang Wisata', 'slug' => 'wisata', 'icon' => '✈️'],
            ['name' => 'Lain-lain', 'slug' => 'lain-lain', 'icon' => '✨'],
        ];

        $createdCount = 0;

        foreach ($categories as $categoryData) {
            $category = Category::firstOrCreate(
                ['slug' => $categoryData['slug']],
                [
                    'name' => $categoryData['name'],
                    'icon' => $categoryData['icon']
                ]
            );

            if ($category->wasRecentlyCreated) {
                echo "✓ {$category->name} dibuat\n";
                $createdCount++;
            } else {
                echo "- {$category->name} sudah ada\n";
            }
        }

        echo "\n🎉 {$createdCount} kategori baru berhasil dibuat!\n";
    }
}
