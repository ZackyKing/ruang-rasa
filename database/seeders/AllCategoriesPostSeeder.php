<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Database\Seeder;

class AllCategoriesPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        echo "🌱 Menambahkan postingan untuk semua kategori...\n";

        $users = User::all();
        if ($users->count() == 0) {
            echo "⚠️ Tidak ada user\n";
            return;
        }

        // Content for each category
        $categoryContents = [
            'psikologi' => [
                "Kenapa kita cenderung mengulangi pola toxic relationship yang sama? Padahal kita sudah sadar itu tidak sehat.",
                "Apakah normalnya kita punya 'different versions' of ourselves tergantung siapa yang ada di depan kita?",
                "Kadang aku merasa lebih nyaman sendirian daripada bersama orang banyak. Apa ini termasuk introvert atau social anxiety ya?",
                "Bagaimana cara membedakan antara istirahat mental yang healthy vs avoidance behavior?",
                "Kenapa kadang kita merasa guilty ketika bahagia, terutama saat orang-orang di sekitar kita sedang struggle?",
            ],
            'film' => [
                "Film Indonesia yang underrated tapi bagus banget menurut kalian apa?",
                "Kenapa banyak orang Indonesia lebih suka nonton film Marvel daripada film lokal? Apa stigmanya?",
                "Rekomendasi film yang bikin mikir soal eksistensi dan makna hidup dong!",
                "Menurutkalian, apakah film harus selalu punya happy ending atau bittersweet ending lebih realistic?",
                "Series Netflix yang worth it untuk ditonton weekend ini apa ya?",
            ],
            'kesehatan' => [
                "Tips untuk konsisten olahraga buat yang super sibuk kerja?",
                "Apakah benar minum air putih 8 gelas sehari mandatory atau itu cuma mitos?",
                "Sharing dong cara kalian mengatasi insomnia tanpa obat tidur!",
                "Mental health itu sama pentingnya dengan physical health. Tapi kenapa masih banyak yang anggap sepele?",
                "Apakah self-diagnosis lewat Google itu berbahaya atau helpful?",
            ],
            'pendidikan' => [
                "Sistem pendidikan Indonesia butuh reformasi total atau cukup perbaikan di sana-sini?",
                "Apakah ijazah masih relevan di era skillbased hiring sekarang?",
                "Kenapa banyak lulusan sarjana yang kerja di bidang yang tidak sesuai jurusannya?",
                "Online learning vs traditional classroom, mana yang lebih efektif menurut pengalaman kalian?",
                "Beasiswa luar negeri yang realistis untuk fresh graduate, share pengalaman dong!",
            ],
            'etnis' => [
                "Sharing pengalaman culture shock yang pernah kalian alami!",
                "Bagaimana cara melestarikan budaya lokal di tengah arus globalisasi?",
                "Stereotip etnis tertentu yang sebenarnya tidak akurat menurut kalian apa?",
                "Makanan tradisional favoritmu yang jarang ditemukan di resto modern?",
                "Kenapa generasi muda makin kurang tertarik belajar bahasa daerah?",
            ],
            'buku' => [
                "Rekomendasi buku self-development yang actually applicable dalam kehidupan nyata?",
                "Kenapa membaca buku fisik masih lebih satisfying daripada e-book?",
                "Novel Indonesia favorit yang wajib dibaca sebelum mati?",
                "Book club offline atau online, mana yang lebih engage menurut kalian?",
                "Sharing buku yang mengubah perspektif hidupmu secara signifikan!",
            ],
            'karantina' => [
                "Hobi baru yang kalian develop selama periode lockdown dulu?",
                "WFH vs WFO, mana yang lebih produktif dan balance menurut pengalaman kalian?",
                "Sharing tips produktif kerja dari rumah tanpa burnout!",
                "Apakah remote work culture akan jadi new normal permanen atau temporary trend?",
                "Kenapa banyak orang yang merasa lebih lonely meskipun WFH bareng keluarga?",
            ],
            'politik' => [
                "Apakah golput itu bentuk protes yang legitimate atau justru merusak demokrasi?",
                "Kenapa diskusi politik di Indonesia selalu berujung debat kusir dan polarisasi?",
                "Bagaimana caranya tetap update politik tanpa stress mental karena beritanya?",
                "Apakah Indonesia butuh regenerasi pemimpin atau pengalaman lebih penting?",
                "Media sosial: memberdayakan atau malah memecah belah masyarakat secara politik?",
            ],
            'filsafat' => [
                "Apa makna hidup menurut perspektif kalian masing-masing?",
                "Apakah free will benar-benar ada atau semua sudah predetermined?",
                "Lebih baik hidup bahagia dalam kebohongan atau menderita dalam kebenaran?",
                "Kenapa manusia selalu mencari meaning padahal mungkin hidup memang meaningless?",
                "Filosofi hidup yang kalian pegang teguh dan membantu kalian survive sejauh ini?",
            ],
            'keagamaan' => [
                "Bagaimana cara kalian menjalani spiritualitas di tengah kesibukan dunia modern?",
                "Apakah bertanya dan doubt itu bagian dari proses keimanan atau justru melemahkan iman?",
                "Sharing pengalaman spiritual awakening yang pernah kalian alami!",
                "Bagaimana menyeimbangkan antara keimanan dan open-mindedness terhadap perbedaan?",
                "Ritual keagamaan yang memberikan peace of mind terbesar buat kalian apa?",
            ],
            'lain-lain' => [
                "Random thoughts yang ga bisa kalian share ke siapa-siapa, spill here!",
                "Guilty pleasure yang kalian tau ga produktif tapi tetap kalian lakuin?",
                "Hal kecil yang bikin hari kalian jadi lebih baik instant-nya apa?",
                "Unpopular opinion kalian tentang apapun yang mungkin controversial?",
                "Shower thoughts yang sampai sekarang belum nemu jawabannya?",
            ],
        ];

        $createdCount = 0;

        foreach ($categoryContents as $slug => $contents) {
            $category = Category::where('slug', $slug)->first();

            if (!$category) {
                echo "⚠️ Kategori '{$slug}' tidak ditemukan\n";
                continue;
            }

            foreach ($contents as $content) {
                $user = $users->random();
                $isAnonymous = rand(1, 4) == 1; // 25% anonymous

                Post::create([
                    'user_id' => $user->id,
                    'category_id' => $category->id,
                    'content' => $content,
                    'is_anonymous' => $isAnonymous,
                    'is_draft' => false,
                    'created_at' => now()->subDays(rand(0, 45)),
                    'updated_at' => now(),
                ]);

                $createdCount++;
            }

            echo "✓ {$category->name}: " . count($contents) . " posts\n";
        }

        echo "\n🎉 Total {$createdCount} postingan berhasil dibuat!\n";
    }
}
