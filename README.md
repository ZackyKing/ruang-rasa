# RuangRasa

RuangRasa adalah platform sosial media yang dibangun dengan filosofi "Ruang tenang untuk memahami kehidupan". Project ini menggunakan Laravel (Backend & Blade UI) dan MySQL.

## 📋 Prasyarat

Sebelum memulai, pastikan komputer kamu sudah terinstall:

-   **PHP** >= 8.1
-   **Composer**
-   **Node.js** & **NPM**
-   **MySQL** (XAMPP/Laragon/Docker)
-   **Git**

## 🚀 Cara Install (Clone Project)

Ikuti langkah-langkah ini untuk menjalankan project di komputer kamu:

### 1. Clone Repository
Buka terminal (Git Bash / CMD / Powershell) dan jalankan:

```bash
git clone <URL_REPOSITORY_GITHUB_INI>
cd Project
```

### 2. Install Dependencies
Install library PHP (Laravel) dan JavaScript:

```bash
composer install
npm install
```

### 3. Setup Environment (.env)
Copy file konfigurasi `.env.example` ke `.env`:

```bash
cp .env.example .env
```

Buka file `.env` di text editor (VS Code) dan sesuaikan konfigurasi database:

```ini
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=putrisundari  # Atau nama database kamu
DB_USERNAME=root          # Default XAMPP/Laragon
DB_PASSWORD=              # Kosongkan jika default
```

### 4. Generate Application Key
```bash
php artisan key:generate
```

### 5. Setup Database & Dummy Data (PENTING!)
Jalankan migrasi untuk membuat tabel dan seeder untuk mengisi data dummy (User, Post, Komentar, Like, Follow, Notifikasi):

```bash
php artisan migrate:fresh --seed
```
*Perintah ini akan menghapus database lama dan mengisinya dengan data baru yang fresh.*

**Akun Demo:**
Jika seeder berjalan sukses, kamu bisa login dengan salah satu akun dummy, misalnya:
- **Email:** `user1@example.com` (atau cek di database user lain)
- **Password:** `password` (default password untuk semua user dummy)

### 6. Jalankan Aplikasi
Buka dua terminal terpisah untuk menjalankan server backend dan compile frontend:

**Terminal 1 (Laravel Server):**
```bash
php artisan serve
```

Buka browser dan akses: `http://localhost:8000`

---

## 🛠️ Tech Stack
-   **Framework:** Laravel 10/11
-   **Frontend:** Blade Templates + Vanilla CSS/JS
-   **Database:** MySQL
-   **Tools:** Vite (Asset building)

## 🤝 workflow Git untuk Team
1.  **Pull** dulu sebelum ngoding: `git pull origin main`
2.  **Buat branch** baru (opsional tapi disarankan): `git checkout -b fitur-baru`
3.  **Commit** perubahan: `git add .` -> `git commit -m "Menambahkan fitur X"`
4.  **Push**: `git push origin main` (atau nama branch kamu)
