<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Post;
use App\Models\Question;
use App\Models\Answer;
use App\Models\Category;
use App\Models\Like;
use App\Models\Comment;
use App\Models\Reshare;
use App\Models\Save;
use App\Models\Follow;
use App\Models\Notification;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class LargeScaleDataSeeder extends Seeder
{
    private $categories;

    public function run(): void
    {
        $this->categories = Category::all();

        echo "🌱 Memulai simulasi data berskala besar...\n";

        // Create users
        $users = $this->createUsers(80);
        echo "✓ {$users->count()} pengguna dibuat\n";

        // Create follows
        $this->createFollows($users);
        echo "✓ Koneksi antar pengguna dibuat\n";

        // Create room follows
        $this->createRoomFollows($users);
        echo "✓ Pengikut ruang dibuat\n";

        // Create posts
        $posts = $this->createPosts($users, 350);
        echo "✓ {$posts->count()} postingan dibuat\n";

        // Create questions
        $questions = $this->createQuestions($users, 120);
        echo "✓ {$questions->count()} pertanyaan dibuat\n";

        // Create answers
        $answers = $this->createAnswers($users, $questions, 380);
        echo "✓ {$answers->count()} jawaban dibuat\n";

        // Create interactions
        $this->createLikes($users, $posts);
        echo "✓ Resonansi dibuat\n";

        $this->createComments($users, $posts);
        echo "✓ Tanggapan dibuat\n";

        $this->createReshares($users, $posts);
        echo "✓ Postingan ulang dibuat\n";

        $this->createSaves($users, $posts);
        echo "✓ Simpanan dibuat\n";

        $this->createNotifications();
        echo "✓ Notifikasi dibuat\n";

        echo "🎉 Simulasi data selesai!\n";
    }

    private function createUsers(int $count)
    {
        $indonesianNames = [
            // Female names
            'Siti Nurhaliza',
            'Dewi Lestari',
            'Putri Maharani',
            'Ayu Ting Ting',
            'Raisa Andriana',
            'Isyana Sarasvati',
            'Maudy Ayunda',
            'Dian Sastro',
            'Chelsea Olivia',
            'Prilly Latuconsina',
            'Amanda Rawles',
            'Tara Basro',
            'Luna Maya',
            'Sandra Dewi',
            'Bunga Citra Lestari',
            'Yuni Shara',
            'Krisdayanti',
            'Anggun Cipta',
            'Ruth Sahanaya',
            'Titi DJ',
            'Rossa Ayu',
            'Syahrini Ever',
            'Cinta Laura',
            'Jessica Iskandar',
            'Nia Ramadhani',
            'Nagita Slavina',
            'Ayu Dewi',
            'Inul Daratista',
            'Fitri Tropica',
            'Zaskia Gotik',

            // Male names
            'Ahmad Dhani',
            'Glenn Fredly',
            'Afgan Syahreza',
            'Reza Rahadian',
            'Iko Uwais',
            'Nicholas Saputra',
            'Chicco Jerikho',
            'Rio Dewanto',
            'Joko Anwar',
            'Hanung Bramantyo',
            'Adi Nugroho',
            'Bayu Sutrisno',
            'Chandra Wijaya',
            'Dodi Hidayat',
            'Eka Prasetya',
            'Fajar Ramadhan',
            'Genta Buana',
            'Hendra Setiawan',
            'Irfan Hakim',
            'Jefri Nichol',
            'Kaesang Pangarep',
            'Lukman Sardi',
            'Made Wiratama',
            'Nanda Persada',
            'Omar Sharif',
            'Pandji Pragiwaksono',
            'Qory Sandioriva',
            'Rendi Jhon',
            'Surya Saputra',
            'Teuku Wisnu',
            'Umar Lubis',
            'Vino Bastian',
            'Wisnu Wardhana',
            'Xavier Malik',
            'Yoshi Sudarso',
            'Zaldy Zulkafli',
            'Arief Muhammad',
            'Bambang Setiawan',
            'Cahyadi Putra',
            'Deni Rahman'
        ];

        $bios = [
            'Mencari makna dalam setiap detik yang berlalu',
            'Pembelajar selamanya | Pecinta buku dan kopi',
            'Menulis untuk memahami, membaca untuk tumbuh',
            'Percaya bahwa setiap orang punya cerita indah',
            'Sedang belajar mencintai prosesnya, bukan hanya hasilnya',
            'Berteman dengan pikiran sendiri',
            'Menemukan kedamaian dalam hal-hal kecil',
            'Hanya seseorang yang mencoba memahami dunia',
            'Belajar menerima dan melepaskan',
            'Mencari keseimbangan antara logika dan rasa',
            'Penulis amatir | Pemikir overthinking',
            'Sedang dalam perjalanan menemukan diri',
            'Percaya pada kekuatan kata-kata yang lembut',
            'Bersyukur atas setiap napas dan langkah',
            'Mengoleksi momen, bukan barang',
        ];

        $users = collect();

        foreach (range(1, $count) as $i) {
            $name = $indonesianNames[array_rand($indonesianNames)];
            $username = Str::slug($name) . rand(10, 999);

            $users->push(User::create([
                'name' => $name,
                'username' => $username,
                'email' => strtolower($username) . '@example.com',
                'password' => Hash::make('password'),
                'bio' => $bios[array_rand($bios)],
                'avatar' => null,
                'is_profile_hidden' => rand(1, 20) == 1, // 5% hidden profiles
            ]));
        }

        return $users;
    }

    private function createFollows($users)
    {
        foreach ($users as $user) {
            // Each user follows 3-15 other users
            $followCount = rand(3, 15);
            $toFollow = $users->where('id', '!=', $user->id)->random(min($followCount, $users->count() - 1));

            foreach ($toFollow as $followedUser) {
                Follow::firstOrCreate([
                    'follower_id' => $user->id,
                    'following_id' => $followedUser->id,
                ]);
            }
        }
    }

    private function createRoomFollows($users)
    {
        foreach ($users as $user) {
            // Each user follows 2-8 rooms
            $roomCount = rand(2, 8);
            $rooms = $this->categories->random(min($roomCount, $this->categories->count()));

            foreach ($rooms as $room) {
                \DB::table('room_follows')->updateOrInsert([
                    'user_id' => $user->id,
                    'category_id' => $room->id,
                ], [
                    'created_at' => now()->subDays(rand(1, 180)),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    private function createPosts($users, int $count)
    {
        $reflectionContents = [
            "Hari ini aku menyadari bahwa kebahagiaan bukan tentang memiliki segalanya, tapi tentang mensyukuri apa yang sudah kita punya. Terkadang kita terlalu sibuk mengejar yang belum kita miliki sampai lupa menghargai yang sudah ada di tangan.",
            "Sudah berapa lama aku tidak benar-benar mendengarkan suara hatiku sendiri? Terjebak dalam rutinitas dan ekspektasi orang lain, aku hampir lupa siapa diriku yang sebenarnya.",
            "Belajar menerima kenyataan bahwa tidak semua hal bisa kita kontrol itu sulit. Tapi itu lah yang membuat kita jadi lebih damai dan ikhlas.",
            "Ada kedamaian tersendiri saat aku mulai berhenti membandingkan hidupku dengan orang lain. Setiap orang punya waktunya masing-masing untuk berkembang.",
            "Menulis di sini membuatku merasa less alone. Ternyata banyak yang merasakan hal yang sama seperti aku.",
            "Kadang yang kita butuhkan bukan solusi, tapi seseorang yang mau mendengarkan tanpa men-judge.",
            "Hari ini gagal lagi dalam hal yang sama. Tapi aku pilih untuk tidak menyerah. Setiap kegagalan mengajarkan sesuatu.",
            "Sedang belajar untuk lebih sabar pada diri sendiri. Kadang aku terlalu keras pada diriku sendiri.",
            "Melepaskan seseorang yang kita sayang itu berat. Tapi kadang itulah yang terbaik untuk kita berdua.",
            "Mulai memahami bahwa healing itu bukan proses linear. Ada hari baik, ada hari buruk, dan itu okay.",
            "Ternyata self-love itu bukan tentang menjadi sempurna, tapi tentang menerima diri sendiri apa adanya.",
            "Bersyukur untuk orang-orang yang tetap stay meskipun mereka sudah tahu sisi terburukku.",
            "Kadang diam itu lebih bijak daripada berbicara. Sedang belajar untuk paham kapan harus bicara dan kapan harus diam.",
            "Kesepian di tengah keramaian itu real. Dikelilingi banyak orang tapi merasa tidak ada yang mengerti.",
            "Sedang dalam proses forgive myself untuk mistakes di masa lalu. Itu tidak mudah tapi necessary.",
            "Belajar slow living dan menghargai proses. Hidup bukan race.",
            "Sometimes the best thing we can do is just breathe and let go.",
            "Grateful for small things: secangkir kopi pagi, senyum stranger, pesan teman tiba-tiba.",
            "Sedang belajar bahwa it's okay to not be okay sometimes.",
            "Menemukan passion baru di usia yang sudah tidak muda lagi. Never too late to start.",
        ];

        $posts = collect();

        foreach (range(1, $count) as $i) {
            $user = $users->random();
            $category = $this->categories->random();
            $isAnonymous = rand(1, 5) == 1; // 20% anonymous

            $content = $reflectionContents[array_rand($reflectionContents)];
            if (rand(1, 3) == 1) {
                // Add extra paragraphs for some posts
                $content .= "\n\n" . $reflectionContents[array_rand($reflectionContents)];
            }

            $posts->push(Post::create([
                'user_id' => $user->id,
                'category_id' => $category->id,
                'content' => $content,
                'is_anonymous' => $isAnonymous,
                'is_draft' => false,
                'created_at' => now()->subDays(rand(1, 180))->subHours(rand(0, 23)),
            ]));
        }

        return $posts;
    }

    private function createQuestions($users, int $count)
    {
        $questionTexts = [
            "Bagaimana cara kalian mengatasi overthinking? Rasanya pikiran tidak bisa berhenti dan itu sangat melelahkan.",
            "Pernah nggak sih kalian merasa stuck di titik yang sama terus menerus?  Gimana caranya move forward?",
            "Apakah wajar kalau kadang kita merasa lelah dengan kehidupan sosial dan butuh sendiri untuk waktu yang lama?",
            "Bagaimana membedakan antara 'istirahat yang produktif' dengan 'procrastination'?",
            "Ada yang punya tips untuk mulai mencintai diri sendiri? Rasanya sulit banget.",
            "Gimana caranya letting go orang yang sudah tidak ada dalam hidup kita lagi?",
            "Apakah normal kalau kadang kita merasa tidak mengenal diri sendiri?",
            "Bagaimana cara kalian menghadapi toxic positivity dari orang sekitar?",
            "Pernah merasa burnout tapi nggak bisa istirahat? Gimana solusinya?",
            "Apakah ada yang mengalami quarter life crisis? Share dong pengalamannya.",
            "Bagaimana cara menetapkan boundaries dengan orang tua atau keluarga?",
            "Gimana caranya tetap konsisten dengan goals yang sudah ditetapkan?",
            "Ada tips untuk mengatasi social anxiety? Especially di situasi baru.",
            "Bagaimana menghadapi impostor syndrome di tempat kerja atau kuliah?",
            "Pernah nggak sih merasa guilty karena prioritasin diri sendiri?",
            "Gimana cara tahu kalau relationship yang kita jalani itu healthy atau toxic?",
            "Apakah wajar merasa cemburu dengan pencapaian teman?",
            "Bagaimana cara kalian healing from heartbreak?",
            "Ada yang pernah kehilangan motivasi hidup? Gimana cara bangkit lagi?",
            "Bagaimana menghadapi pressure dari ekspektasi masyarakat?",
        ];

        $questions = collect();
        $questionCategory = $this->categories->where('slug', 'pertanyaan')->first();
        if (!$questionCategory) {
            $questionCategory = $this->categories->first();
        }

        foreach (range(1, $count) as $i) {
            $user = $users->random();
            $isAnonymous = rand(1, 3) == 1; // 33% anonymous for questions

            $questions->push(Post::create([
                'user_id' => $user->id,
                'category_id' => $questionCategory->id,
                'content' => $questionTexts[array_rand($questionTexts)],
                'is_anonymous' => $isAnonymous,
                'is_draft' => false,
                'created_at' => now()->subDays(rand(1, 180))->subHours(rand(0, 23)),
            ]));
        }

        return $questions;
    }

    private function createAnswers($users, $questions, int $count)
    {
        // Note: This is a simplified version
        // In real app, answers would link to questions properly
        return collect();
    }

    private function createLikes($users, $posts)
    {
        foreach ($posts as $post) {
            // Popular posts get 10-50 likes, others get 0-5
            $isPopular = rand(1, 5) == 1;
            $likeCount = $isPopular ? rand(10, 50) : rand(0, 5);

            $likers = $users->random(min($likeCount, $users->count()));

            foreach ($likers as $liker) {
                Like::firstOrCreate([
                    'user_id' => $liker->id,
                    'post_id' => $post->id,
                ], [
                    'created_at' => $post->created_at->addMinutes(rand(1, 1000)),
                ]);
            }
        }
    }

    private function createComments($users, $posts)
    {
        $commentTexts = [
            "Terima kasih sudah share. Aku relate banget sama ini.",
            "Semangat ya! Kamu nggak sendiri kok.",
            "Aku juga merasakan hal yang sama. Virtual hug untuk kamu.",
            "Ini exactly yang aku rasakan tapi nggak bisa express in words.",
            "You're doing great. Be kind to yourself.",
            "Terima kasih sudah berani vulnerable. Ini menginspirasi aku.",
            "Peluk jauh untuk kamu. Everything will be okay.",
            "Aku mengerti perasaanmu. Kalau butuh teman cerita, I'm here.",
            "Progress bukan tentang seberapa cepat, tapi tentang konsisten.",
            "Terima kasih sudah mengingatkan aku tentang ini.",
        ];

        foreach ($posts->random(min(150, $posts->count())) as $post) {
            // Some posts get 5-20 comments, others get 0-3
            $isEngaging = rand(1, 4) == 1;
            $commentCount = $isEngaging ? rand(5, 20) : rand(0, 3);

            foreach (range(1, $commentCount) as $i) {
                Comment::create([
                    'user_id' => $users->random()->id,
                    'post_id' => $post->id,
                    'content' => $commentTexts[array_rand($commentTexts)],
                    'created_at' => $post->created_at->addMinutes(rand(5, 2000)),
                ]);
            }
        }
    }

    private function createReshares($users, $posts)
    {
        foreach ($posts->random(min(100, $posts->count())) as $post) {
            // Resonant posts get 2-10 reshares
            $reshareCount = rand(2, 10);
            $resharers = $users->random(min($reshareCount, $users->count()));

            foreach ($resharers as $resharer) {
                Reshare::firstOrCreate([
                    'user_id' => $resharer->id,
                    'post_id' => $post->id,
                ], [
                    'created_at' => $post->created_at->addMinutes(rand(10, 3000)),
                ]);
            }
        }
    }

    private function createSaves($users, $posts)
    {
        foreach ($users as $user) {
            // Each user saves 3-15 posts
            $saveCount = rand(3, 15);
            $toSave = $posts->random(min($saveCount, $posts->count()));

            foreach ($toSave as $post) {
                Save::firstOrCreate([
                    'user_id' => $user->id,
                    'post_id' => $post->id,
                ], [
                    'created_at' => $post->created_at->addMinutes(rand(1, 5000)),
                ]);
            }
        }
    }


    private function createNotifications()
    {
        // 1. Follow Notifications
        $follows = Follow::with(['follower', 'following'])
            ->where('created_at', '>=', now()->subDays(7)) // Only recent follows for realistic notifications
            ->get();

        foreach ($follows as $follow) {
            // 70% chance to have a notification
            if (rand(1, 100) <= 70) {
                Notification::create([
                    'user_id' => $follow->following_id,
                    'type' => 'follow',
                    'data' => [
                        'follower_id' => $follow->follower_id,
                        'follower_name' => $follow->follower->name,
                    ],
                    'created_at' => $follow->created_at,
                    'read_at' => rand(0, 1) ? $follow->created_at->addMinutes(rand(10, 1000)) : null,
                ]);
            }
        }

        // 2. Like Notifications
        $likes = Like::with(['user', 'post.user'])
            ->whereHas('post', function ($q) {
                // Ensure post exists
            })
            ->where('created_at', '>=', now()->subDays(7))
            ->get();

        foreach ($likes as $like) {
            if ($like->post->user_id !== $like->user_id && rand(1, 100) <= 60) {
                Notification::create([
                    'user_id' => $like->post->user_id,
                    'type' => 'like',
                    'data' => [
                        'post_id' => $like->post_id,
                        'liker_id' => $like->user_id,
                        'liker_name' => $like->user->name,
                        'post_preview' => Str::limit($like->post->content, 50),
                    ],
                    'created_at' => $like->created_at,
                    'read_at' => rand(0, 1) ? $like->created_at->addMinutes(rand(5, 500)) : null,
                ]);
            }
        }

        // 3. Comment Notifications
        $comments = Comment::with(['user', 'post.user'])
            ->where('created_at', '>=', now()->subDays(7))
            ->get();

        foreach ($comments as $comment) {
            if ($comment->post->user_id !== $comment->user_id) {
                Notification::create([
                    'user_id' => $comment->post->user_id,
                    'type' => 'comment',
                    'data' => [
                        'post_id' => $comment->post_id,
                        'commenter_id' => $comment->user_id,
                        'commenter_name' => $comment->user->name,
                        'comment_preview' => Str::limit($comment->content, 50),
                    ],
                    'created_at' => $comment->created_at,
                    'read_at' => rand(0, 1) ? $comment->created_at->addMinutes(rand(5, 500)) : null,
                ]);
            }
        }

        // 4. Reshare Notifications
        $reshares = Reshare::with(['user', 'post.user'])
            ->where('created_at', '>=', now()->subDays(7))
            ->get();

        foreach ($reshares as $reshare) {
            if ($reshare->post->user_id !== $reshare->user_id && rand(1, 100) <= 70) {
                Notification::create([
                    'user_id' => $reshare->post->user_id,
                    'type' => 'reshare',
                    'data' => [
                        'post_id' => $reshare->post_id,
                        'resharer_id' => $reshare->user_id,
                        'resharer_name' => $reshare->user->name,
                        'post_preview' => Str::limit($reshare->post->content, 50),
                    ],
                    'created_at' => $reshare->created_at,
                    'read_at' => rand(0, 1) ? $reshare->created_at->addMinutes(rand(5, 500)) : null,
                ]);
            }
        }
    }
}
