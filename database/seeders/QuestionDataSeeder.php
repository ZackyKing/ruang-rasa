<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Database\Seeder;

class QuestionDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        echo "🌱 Menambahkan data pertanyaan...\n";

        // Get or create "Pertanyaan" category
        $questionCategory = Category::firstOrCreate(
            ['slug' => 'pertanyaan'],
            [
                'name' => 'Pertanyaan',
                'icon' => '❓'
            ]
        );

        // Get all users
        $users = User::all();

        if ($users->count() == 0) {
            echo "⚠️ Tidak ada user, jalankan UserSeeder terlebih dahulu\n";
            return;
        }

        // Array of questions
        $questions = [
            "Kenapa orang Indonesia males membaca buku?",
            "Menurut aku, sistem kenapa banyak orang Indonesia males membaca buku itu bukan karena mereka bodoh, tapi karena dari awal kita nggak diajarin bahwa membaca itu menyenangkan dan bisa membuka dunia baru. Apa pendapat kalian?",
            "Bagaimana cara mengatasi overthinking?",
            "Kenapa kita sering merasa kesepian meskipun dikelilingi banyak orang?",
            "Apakah normal jika kadang merasa tidak mengenal diri sendiri?",
            "Bagaimana cara membedakan antara istirahat dan menghindar dari masalah?",
            "Kenapa kadang kita merasa bersalah saat bahagia?",
            "Apakah memang ada yang namanya soulmate atau itu cuma mitos?",
            "Bagaimana cara move on dari masa lalu yang terus menghantui?",
            "Kenapa kita cenderung lebih keras pada diri sendiri dibanding orang lain?",
            "Apakah uang memang bisa membeli kebahagiaan?",
            "Bagaimana cara menerima kenyataan yang tidak sesuai harapan?",
            "Kenapa toxic positivity itu berbahaya?",
            "Apakah normal merasakan imposter syndrome meskipun sudah sukses?",
            "Bagaimana cara membangun boundaries yang sehat dengan keluarga?",
            "Kenapa kita sering membanding-bandingkan hidup kita dengan orang lain?",
            "Apakah passion memang harus dijadikan pekerjaan?",
            "Bagaimana cara keluar dari cycle people pleasing?",
            "Kenapa healing process itu tidak linear?",
            "Apakah forgiveness itu untuk diri sendiri atau untuk orang lain?",
            "Bagaimana cara menghadapi peer pressure di usia dewasa?",
            "Kenapa kadang kita merasa guilty saat reject permintaan orang lain?",
            "Apakah ghosting bisa dibenarkan dalam situasi tertentu?",
            "Bagaimana cara membedakan antara self-care dan self-indulgence?",
            "Kenapa kita takut sendirian tapi juga takut commitment?",
            "Apakah mindfulness benar-benar efektif atau cuma trend?",
            "Bagaimana cara menghadapi existential crisis?",
            "Kenapa kadang kita merasa stuck padahal sudah melakukan banyak hal?",
            "Apakah therapy memang untuk semua orang atau ada yang tidak cocok?",
            "Bagaimana cara dealing dengan quarter-life crisis?",
        ];

        $createdCount = 0;

        foreach ($questions as $questionContent) {
            $user = $users->random();
            $isAnonymous = rand(1, 3) == 1; // 33% anonymous

            Post::create([
                'user_id' => $user->id,
                'category_id' => $questionCategory->id,
                'content' => $questionContent,
                'is_anonymous' => $isAnonymous,
                'is_draft' => false,
                'created_at' => now()->subDays(rand(0, 30)),
                'updated_at' => now(),
            ]);

            $createdCount++;
        }

        echo "✓ {$createdCount} pertanyaan berhasil dibuat\n";
        echo "🎉 Seeder pertanyaan selesai!\n";
    }
}
