<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Post;
use App\Models\Question;
use App\Models\Answer;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Follow;
use App\Models\Notification;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        // Create/update demo users with usernames
        $users = [
            [
                'name' => 'Putri Sundari',
                'username' => 'putsnori',
                'email' => 'putri@example.com',
                'password' => Hash::make('password'),
                'bio' => 'Berjalan dengan semestinya saja.',
                'website' => 'instagram.com/putsundari',
            ],
            [
                'name' => 'Kinaraa jz',
                'username' => 'kinaraa',
                'email' => 'kinara@example.com',
                'password' => Hash::make('password'),
                'bio' => 'Menyukai hal-hal sederhana dalam hidup.',
            ],
            [
                'name' => 'Jeremi Nansyi',
                'username' => 'jeremi_n',
                'email' => 'jeremi@example.com',
                'password' => Hash::make('password'),
                'bio' => 'Content creator & book lover.',
            ],
            [
                'name' => 'Tsana',
                'username' => 'tsana_id',
                'email' => 'tsana@example.com',
                'password' => Hash::make('password'),
                'bio' => 'Mahasiswi psikologi semester 5.',
            ],
            [
                'name' => 'Anggunisa',
                'username' => 'anggunisa',
                'email' => 'anggun@example.com',
                'password' => Hash::make('password'),
                'bio' => 'Pecinta kopi dan kucing.',
            ],
            [
                'name' => 'May Ayunda',
                'username' => 'may_ayunda',
                'email' => 'may@example.com',
                'password' => Hash::make('password'),
                'bio' => 'Life is too short to be ordinary.',
            ],
            [
                'name' => 'Budi Hartono',
                'username' => 'budi_h',
                'email' => 'budi@example.com',
                'password' => Hash::make('password'),
                'bio' => 'Software developer & music enthusiast.',
            ],
            [
                'name' => 'Yuliana',
                'username' => 'yuliana_lia',
                'email' => 'yuliana@example.com',
                'password' => Hash::make('password'),
                'bio' => 'Konselor dan penulis.',
            ],
            [
                'name' => 'Ayu Kurniasari',
                'username' => 'ayu_k',
                'email' => 'ayu@example.com',
                'password' => Hash::make('password'),
                'bio' => 'Healing satu langkah per hari.',
            ],
            [
                'name' => 'Aidil Amri Z',
                'username' => 'aidil_az',
                'email' => 'aidil@example.com',
                'password' => Hash::make('password'),
                'bio' => 'Penikmat sunset dan sunrise.',
            ],
        ];

        $createdUsers = [];
        foreach ($users as $userData) {
            $createdUsers[] = User::updateOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }

        // Get category IDs
        $categories = Category::all()->keyBy('slug');

        // Create posts for each category
        $posts = [
            // Ruang Kehidupan
            [
                'user_id' => $createdUsers[0]->id,
                'category_id' => $categories['kehidupan']->id ?? 1,
                'content' => 'Hidup tidak selalu berjalan seperti yang kita rencanakan, dan sering kali justru di situlah kita belajar. Dari kecewa, dari gagal, dari hal-hal yang tidak kita mengerti saat itu. Perlahan kita paham bahwa tidak semua harus dimenangkan, tidak semua harus dipercepat, dan tidak semua harus dijelaskan. Ada fase di mana bertahan sudah lebih dari cukup.',
                'is_anonymous' => false,
            ],
            [
                'user_id' => $createdUsers[1]->id,
                'category_id' => $categories['kehidupan']->id ?? 1,
                'content' => 'Kadang yang kita butuhkan bukan solusi, tapi seseorang yang mau mendengarkan tanpa menghakimi. Yang mau duduk di samping kita saat semuanya terasa berat, tanpa perlu bertanya "kenapa kamu gitu sih?"',
                'is_anonymous' => false,
            ],
            [
                'user_id' => $createdUsers[2]->id,
                'category_id' => $categories['kehidupan']->id ?? 1,
                'content' => 'Berhenti membandingkan perjalananmu dengan orang lain. Setiap orang punya timeline masing-masing. Yang penting terus melangkah, meski pelan.',
                'is_anonymous' => true,
            ],
            // Ruang Buku
            [
                'user_id' => $createdUsers[0]->id,
                'category_id' => $categories['buku']->id ?? 2,
                'content' => 'Membaca adalah cara paling sunyi untuk berdialog dengan banyak pikiran. Tanpa harus bertemu langsung, kita belajar dari pengalaman, kesalahan, dan kebijaksanaan orang lain. Buku tidak memaksa kita setuju, ia hanya mengajak kita berpikir lebih dalam sebelum memutuskan apa yang ingin kita percaya.',
                'is_anonymous' => false,
            ],
            [
                'user_id' => $createdUsers[3]->id,
                'category_id' => $categories['buku']->id ?? 2,
                'content' => 'Baru selesai baca "Atomic Habits" dan benar-benar mengubah cara pandangku tentang kebiasaan. Ternyata perubahan kecil yang konsisten itu lebih powerful dari perubahan besar yang sekali-sekali.',
                'is_anonymous' => false,
            ],
            // Ruang Kesehatan
            [
                'user_id' => $createdUsers[4]->id,
                'category_id' => $categories['kesehatan']->id ?? 5,
                'content' => 'Mental health itu bukan privilege, tapi kebutuhan dasar. Jangan malu untuk mencari bantuan profesional saat merasa overwhelmed. Kamu tidak harus kuat sendirian.',
                'is_anonymous' => false,
            ],
            [
                'user_id' => $createdUsers[5]->id,
                'category_id' => $categories['kesehatan']->id ?? 5,
                'content' => 'Tips sederhana untuk self-care: tidur cukup, minum air putih, jalan kaki 30 menit sehari, dan yang terpenting - belajar bilang "tidak" untuk hal yang menguras energy.',
                'is_anonymous' => true,
            ],
            // Ruang Karir
            [
                'user_id' => $createdUsers[6]->id,
                'category_id' => $categories['karir']->id ?? 6,
                'content' => 'Pengalaman pahit hari ini: ditolak di interview ke-7. Tapi aku percaya, penolakan adalah redirect ke arah yang lebih baik. Tetap semangat untuk yang sedang berjuang juga!',
                'is_anonymous' => false,
            ],
            [
                'user_id' => $createdUsers[7]->id,
                'category_id' => $categories['karir']->id ?? 6,
                'content' => 'Toxic workplace itu real, dan memutuskan untuk resign tanpa backup itu berani. Tapi kesehatan mentalmu lebih berharga dari gaji apapun.',
                'is_anonymous' => true,
            ],
            // Ruang Cinta
            [
                'user_id' => $createdUsers[8]->id,
                'category_id' => $categories['cinta']->id ?? 7,
                'content' => 'Move on bukan berarti melupakan, tapi memilih untuk tidak lagi terikat dengan rasa sakit. Biarkan dia pergi bersama pelajaran yang ia tinggalkan.',
                'is_anonymous' => false,
            ],
            // Ruang Keluarga
            [
                'user_id' => $createdUsers[9]->id,
                'category_id' => $categories['keluarga']->id ?? 8,
                'content' => 'Komunikasi dengan orang tua memang tidak mudah, especially kalau cara pandang berbeda generasi. Tapi pelan-pelan, dengan kesabaran, pasti ada titik temu.',
                'is_anonymous' => false,
            ],
            // More Ruang Musik
            [
                'user_id' => $createdUsers[3]->id,
                'category_id' => $categories['musik']->id ?? 3,
                'content' => 'Lagu favorit minggu ini: "Matahari" by Kunto Aji. Liriknya seperti pelukan hangat untuk yang sedang lelah.',
                'is_anonymous' => false,
            ],
            // More Ruang Film
            [
                'user_id' => $createdUsers[5]->id,
                'category_id' => $categories['film']->id ?? 4,
                'content' => 'Baru nonton "Past Lives" dan nangis sesenggukan. Film tentang keputusan hidup dan jalan yang tidak kita ambil. Highly recommended!',
                'is_anonymous' => false,
            ],
        ];

        $createdPosts = [];
        foreach ($posts as $postData) {
            $createdPosts[] = Post::create($postData);
        }

        // Create likes for posts
        foreach ($createdPosts as $index => $post) {
            // Random users like each post
            $likersCount = rand(5, 50);
            $likers = collect($createdUsers)->random(min($likersCount, count($createdUsers)));
            foreach ($likers as $liker) {
                Like::create([
                    'post_id' => $post->id,
                    'user_id' => $liker->id,
                ]);
            }
        }

        // Create comments
        $comments = [
            ['post_id' => $createdPosts[0]->id, 'user_id' => $createdUsers[4]->id, 'content' => 'Sangat relate dengan ini. Terima kasih sudah berbagi.'],
            ['post_id' => $createdPosts[0]->id, 'user_id' => $createdUsers[1]->id, 'content' => 'Butuh dibaca ini setiap hari.'],
            ['post_id' => $createdPosts[1]->id, 'user_id' => $createdUsers[0]->id, 'content' => 'Setuju banget! Kadang kita cuma butuh didengarkan.'],
            ['post_id' => $createdPosts[3]->id, 'user_id' => $createdUsers[2]->id, 'content' => 'Buku favorit aku juga ini!'],
            ['post_id' => $createdPosts[5]->id, 'user_id' => $createdUsers[8]->id, 'content' => 'Terima kasih remindernya 💚'],
        ];

        foreach ($comments as $comment) {
            Comment::create($comment);
        }

        // Create questions
        $questions = [
            ['user_id' => $createdUsers[1]->id, 'content' => 'Bagaimana pendapatmu dengan orang yang kritis tapi minim aksi?', 'is_anonymous' => false],
            ['user_id' => $createdUsers[3]->id, 'content' => 'Apakah permintaan maaf saja sudah cukup, untuk menyelesaikan semua kesalahan?', 'is_anonymous' => true],
            ['user_id' => $createdUsers[5]->id, 'content' => 'Apa kebiasaan kecil yang ternyata sangat membantu hidupmu jadi lebih teratur?', 'is_anonymous' => true],
            ['user_id' => $createdUsers[2]->id, 'content' => 'Kenapa seseorang susah keluar dari zona malasnya?', 'is_anonymous' => false],
            ['user_id' => $createdUsers[0]->id, 'content' => 'Bagaimana cara membangkitkan ambisi dari dalam diri?', 'is_anonymous' => false],
            ['user_id' => $createdUsers[0]->id, 'content' => 'Bagaimana cara menabung versimu?', 'is_anonymous' => false],
            ['user_id' => $createdUsers[6]->id, 'content' => 'Tone up cream apa yang menurutmu terbaik dan cocok untuk kulit berminyak?', 'is_anonymous' => true],
        ];

        $createdQuestions = [];
        foreach ($questions as $q) {
            $createdQuestions[] = Question::create($q);
        }

        // Create answers
        $answers = [
            ['question_id' => $createdQuestions[0]->id, 'user_id' => $createdUsers[0]->id, 'content' => 'Menurutku, kritis tanpa aksi itu setengah jalan—pikirannya tajam, tapi keberaniannya belum nyampe ke praktik. Kritik seharusnya jadi pintu masuk untuk bergerak, bukan tempat berhenti.'],
            ['question_id' => $createdQuestions[0]->id, 'user_id' => $createdUsers[7]->id, 'content' => 'Mereka mungkin tahu apa yang salah, tapi takut gagal saat mencoba memperbaikinya.'],
            ['question_id' => $createdQuestions[4]->id, 'user_id' => $createdUsers[7]->id, 'content' => 'Start small, dream big. Mulai dari hal kecil yang bisa kamu kontrol setiap hari.'],
            ['question_id' => $createdQuestions[4]->id, 'user_id' => $createdUsers[8]->id, 'content' => 'Coba tanya ke dirimu sendiri: apa yang bikin kamu excited? Mulai dari situ.'],
            ['question_id' => $createdQuestions[5]->id, 'user_id' => $createdUsers[9]->id, 'content' => 'Aku pakai metode 50-30-20. 50% kebutuhan, 30% keinginan, 20% tabungan. Sederhana tapi efektif!'],
            ['question_id' => $createdQuestions[2]->id, 'user_id' => $createdUsers[4]->id, 'content' => 'Journaling sebelum tidur! Menulis 3 hal yang grateful hari itu.'],
        ];

        foreach ($answers as $a) {
            Answer::create($a);
        }

        // Create follow relationships
        $follows = [
            [$createdUsers[0]->id, $createdUsers[1]->id],
            [$createdUsers[0]->id, $createdUsers[2]->id],
            [$createdUsers[0]->id, $createdUsers[3]->id],
            [$createdUsers[1]->id, $createdUsers[0]->id],
            [$createdUsers[1]->id, $createdUsers[4]->id],
            [$createdUsers[2]->id, $createdUsers[0]->id],
            [$createdUsers[2]->id, $createdUsers[5]->id],
            [$createdUsers[3]->id, $createdUsers[0]->id],
            [$createdUsers[4]->id, $createdUsers[0]->id],
            [$createdUsers[4]->id, $createdUsers[1]->id],
            [$createdUsers[5]->id, $createdUsers[0]->id],
            [$createdUsers[6]->id, $createdUsers[0]->id],
            [$createdUsers[7]->id, $createdUsers[0]->id],
            [$createdUsers[8]->id, $createdUsers[0]->id],
            [$createdUsers[9]->id, $createdUsers[0]->id],
        ];

        foreach ($follows as $f) {
            Follow::firstOrCreate([
                'follower_id' => $f[0],
                'following_id' => $f[1],
            ]);
        }

        // Create notifications
        $notifications = [
            [
                'user_id' => $createdUsers[0]->id,
                'type' => 'like',
                'data' => json_encode([
                    'post_id' => $createdPosts[0]->id,
                    'liker_id' => $createdUsers[4]->id,
                    'liker_name' => 'Anggunisa dan 95 orang lainnya',
                    'post_preview' => 'Hidup tidak selalu berjalan seperti yang kita rencanakan...',
                ]),
            ],
            [
                'user_id' => $createdUsers[0]->id,
                'type' => 'reshare',
                'data' => json_encode([
                    'post_id' => $createdPosts[0]->id,
                    'resharer_id' => $createdUsers[5]->id,
                    'resharer_name' => 'May Ayunda dan 11 orang lainnya',
                    'post_preview' => 'Hidup tidak selalu berjalan seperti yang kita rencanakan...',
                ]),
            ],
            [
                'user_id' => $createdUsers[0]->id,
                'type' => 'answer',
                'data' => json_encode([
                    'question_id' => $createdQuestions[4]->id,
                    'answerer_id' => $createdUsers[7]->id,
                    'answerer_name' => 'Yuliana',
                    'question_preview' => 'Bagaimana cara membangkitkan ambisi dari dalam diri?',
                ]),
            ],
            [
                'user_id' => $createdUsers[0]->id,
                'type' => 'follow',
                'data' => json_encode([
                    'follower_id' => $createdUsers[9]->id,
                    'follower_name' => 'Aidil Amri Z',
                ]),
            ],
        ];

        foreach ($notifications as $n) {
            Notification::create($n);
        }

        echo "Demo data created successfully!\n";
        echo "Users: " . count($createdUsers) . "\n";
        echo "Posts: " . count($createdPosts) . "\n";
        echo "Questions: " . count($createdQuestions) . "\n";
    }
}
