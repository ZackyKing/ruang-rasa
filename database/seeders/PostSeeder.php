<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use App\Models\Like;
use App\Models\Comment;
use App\Models\Reshare;
use App\Models\Save;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $putri = User::where('email', 'putri@example.com')->first();
        $andi = User::where('email', 'andi@example.com')->first();
        $dewi = User::where('email', 'dewi@example.com')->first();

        $kehidupan = Category::where('slug', 'kehidupan')->first();
        $buku = Category::where('slug', 'buku')->first();
        $kesehatan = Category::where('slug', 'kesehatan')->first();
        $karir = Category::where('slug', 'karir')->first();

        // Post 1 - Putri
        $post1 = Post::create([
            'user_id' => $putri->id,
            'category_id' => $kehidupan->id,
            'title' => '',
            'content' => 'Kualitas hidup seseorang sangat dipengaruhi oleh cara berpikirnya. Jika seseorang dipenuhi oleh pikiran negatif, iri hati, kebencian, atau niat buruk, maka kehidupannya tidak akan bisa berjalan dengan baik, harmonis, atau bersih dari masalah.

Kutipan ini mencerminkan gagasan utama dalam bukunya As a Man Thinketh, yang menekankan bahwa pikiran seseorang membentuk realitasnya. Dengan menjaga kejernihan dan kebersihan pikiran, seseorang bisa menciptakan kehidupan yang lebih baik dan bermakna.',
            'is_anonymous' => false,
        ]);

        // Post 2 - Andi (anonymous)
        $post2 = Post::create([
            'user_id' => $andi->id,
            'category_id' => $kehidupan->id,
            'title' => 'Hidup kita akan sia-sia jika...',
            'content' => 'kita selalu terus membiarkan orang toxic dan negative vibes dalam hidup kita. Oleh karena itu, jangan biarkan diri kita terbawa arus negatif yang dibawa oleh orang tersebut. Karena energi itu menular. Masa iya kita udah cape2 upgrade diri, upgrade skill eh malah dipertemukan orang yang toxic. Kan engga banget.

Jadi, lebih baik langsung jauhin aja orang kayak gitu. Jangan biarkan orang kayak gitu membuat kita down lagi secara berulang kali. Kamu berhak bahagia. Kamu lebih pantas dikelilingi orang baik yang membawa dampak positif untuk kamu.',
            'is_anonymous' => true,
        ]);

        // Post 3 - Dewi
        $post3 = Post::create([
            'user_id' => $dewi->id,
            'category_id' => $buku->id,
            'title' => 'Kenapa orang Indonesia malas membaca buku?',
            'content' => 'Menurut aku.. alasan kenapa banyak orang Indonesia malas membaca buku itu bukan karena mereka bodoh, tapi karena dari awal kita nggak pernah diajarin bahwa membaca itu menyenangkan dan bisa menyelamatkan hidup. 

Aku belajar ini dari buku "How to Read a Book" karya Mortimer J. Adler, buku klasik yang ngajarin bukan cuma "cara" membaca, tapi "kenapa" kita harus membaca.

"The person who says he knows what he thinks but cannot express it usually does not know what he thinks."',
            'is_anonymous' => false,
        ]);

        // Post 4 - Putri
        $post4 = Post::create([
            'user_id' => $putri->id,
            'category_id' => $kesehatan->id,
            'title' => 'Tips menjaga kesehatan mental',
            'content' => 'Beberapa hal yang bisa kamu lakukan untuk menjaga kesehatan mental:

1. Tidur yang cukup (7-8 jam)
2. Olahraga rutin minimal 30 menit sehari
3. Makan makanan bergizi
4. Luangkan waktu untuk diri sendiri
5. Jangan ragu untuk bercerita kepada orang yang dipercaya

Ingat, tidak apa-apa untuk tidak baik-baik saja. Yang penting adalah kita berusaha untuk menjadi lebih baik setiap harinya.',
            'is_anonymous' => false,
        ]);

        // Post 5 - Andi
        $post5 = Post::create([
            'user_id' => $andi->id,
            'category_id' => $karir->id,
            'title' => 'Fresh Graduate Wajib Tau!',
            'content' => 'Sebagai fresh graduate, jangan terlalu khawatir tentang gaji pertama. Yang lebih penting adalah:

✅ Pengalaman dan skill yang didapat
✅ Lingkungan kerja yang mendukung pertumbuhan
✅ Mentor yang bisa membimbing
✅ Kesempatan untuk belajar hal baru

Gaji bisa bertambah seiring waktu, tapi pengalaman dan skill yang kamu dapat di awal karir akan menentukan masa depanmu.',
            'is_anonymous' => false,
        ]);

        // Post 6 - Dewi
        $post6 = Post::create([
            'user_id' => $dewi->id,
            'category_id' => $kehidupan->id,
            'title' => '',
            'content' => 'Semua orang memang baik, tapi tidak semua orang bisa bersikap baik jika sudah diperlakukan buruk. Jadi, bersikap sewajarnya saja. Jangan terlalu banyak berharap. 

Berbuat baik boleh, asalkan tau batas. Intinya berbuat baik lah dengan tulus ikhlas, jangan mengharapkan balasan. Kamu berharga untuk orang yang selalu menganggap kamu ada.',
            'is_anonymous' => false,
        ]);

        // Post 7 - Putri (anonymous)
        $post7 = Post::create([
            'user_id' => $putri->id,
            'category_id' => $kehidupan->id,
            'title' => 'Curhat anonim boleh ya..',
            'content' => 'Aku lagi ngerasa overwhelmed banget sama semua yang terjadi. Kuliah, kerja part-time, masalah keluarga... Rasanya pengen istirahat sebentar dari semuanya.

Tapi aku tau ini cuma sementara. Aku harus kuat. Kalau ada yang ngerasa sama, aku mau bilang: kamu nggak sendirian. Kita sama-sama berjuang.',
            'is_anonymous' => true,
        ]);

        // Add likes
        Like::create(['post_id' => $post1->id, 'user_id' => $andi->id]);
        Like::create(['post_id' => $post1->id, 'user_id' => $dewi->id]);
        Like::create(['post_id' => $post3->id, 'user_id' => $putri->id]);
        Like::create(['post_id' => $post3->id, 'user_id' => $andi->id]);
        Like::create(['post_id' => $post4->id, 'user_id' => $dewi->id]);
        Like::create(['post_id' => $post5->id, 'user_id' => $putri->id]);
        Like::create(['post_id' => $post5->id, 'user_id' => $dewi->id]);
        Like::create(['post_id' => $post6->id, 'user_id' => $putri->id]);
        Like::create(['post_id' => $post6->id, 'user_id' => $andi->id]);
        Like::create(['post_id' => $post7->id, 'user_id' => $andi->id]);
        Like::create(['post_id' => $post7->id, 'user_id' => $dewi->id]);

        // Add comments
        Comment::create([
            'post_id' => $post1->id,
            'user_id' => $dewi->id,
            'content' => 'Setuju banget! Mindset itu penting sekali untuk menjalani kehidupan yang berkualitas.',
        ]);
        Comment::create([
            'post_id' => $post1->id,
            'user_id' => $andi->id,
            'content' => 'Buku As a Man Thinketh memang bagus. Recommended!',
        ]);
        Comment::create([
            'post_id' => $post3->id,
            'user_id' => $putri->id,
            'content' => 'Aku juga suka buku itu! Mengubah cara pandangku tentang membaca.',
        ]);
        Comment::create([
            'post_id' => $post4->id,
            'user_id' => $andi->id,
            'content' => 'Thanks for sharing! Sangat membantu.',
        ]);
        Comment::create([
            'post_id' => $post5->id,
            'user_id' => $dewi->id,
            'content' => 'Betul sekali. Aku dulu juga terlalu fokus ke gaji, padahal pengalaman lebih penting.',
        ]);
        Comment::create([
            'post_id' => $post7->id,
            'user_id' => $dewi->id,
            'content' => 'Semangat! Kamu pasti bisa melewati ini. Kalau butuh teman curhat, aku siap mendengarkan.',
        ]);

        // Add reshares
        Reshare::create(['post_id' => $post1->id, 'user_id' => $andi->id]);
        Reshare::create(['post_id' => $post3->id, 'user_id' => $putri->id]);
        Reshare::create(['post_id' => $post5->id, 'user_id' => $dewi->id]);

        // Add saves
        Save::create(['post_id' => $post1->id, 'user_id' => $dewi->id]);
        Save::create(['post_id' => $post3->id, 'user_id' => $andi->id]);
        Save::create(['post_id' => $post4->id, 'user_id' => $andi->id]);
        Save::create(['post_id' => $post5->id, 'user_id' => $putri->id]);
    }
}
