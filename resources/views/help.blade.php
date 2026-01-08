@extends('layouts.app')

@section('title', 'Bantuan - RuangRasa')

@section('content')
    <div class="main-content">
        <div class="help-layout">
            <div class="help-header">
                <h2>Pusat Bantuan</h2>
                <p>Temukan jawaban atau hubungi kami untuk bantuan lebih lanjut.</p>
            </div>

            <div class="help-grid">
                <!-- FAQ Section -->
                <div class="faq-container">
                    <h3>Pertanyaan Umum</h3>
                    <div class="faq-list">
                        <details class="faq-item">
                            <summary>
                                <span>Bagaimana cara posting secara anonim?</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="6 9 12 15 18 9"></polyline>
                                </svg>
                            </summary>
                            <div class="faq-content">
                                <p>Saat membuat postingan, aktifkan opsi toggle "Anonim" di bagian bawah editor teks sebelum mengirim. Nama dan foto profil kamu tidak akan ditampilkan pada postingan tersebut.</p>
                            </div>
                        </details>

                        <details class="faq-item">
                            <summary>
                                <span>Bagaimana cara menyembunyikan profil saya?</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="6 9 12 15 18 9"></polyline>
                                </svg>
                            </summary>
                            <div class="faq-content">
                                <p>Buka halaman <strong>Pengaturan</strong>, pilih tab <strong>Privasi</strong>, lalu aktifkan opsi "Mode Privat". Profil dan postinganmu hanya akan terlihat oleh pengikut yang kamu setujui.</p>
                            </div>
                        </details>

                        <details class="faq-item">
                            <summary>
                                <span>Bagaimana cara melaporkan postingan yang tidak pantas?</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="6 9 12 15 18 9"></polyline>
                                </svg>
                            </summary>
                            <div class="faq-content">
                                <p>Klik tombol titik tiga (...) di pojok kanan atas postingan, pilih opsi "Laporkan", dan pilih alasan yang sesuai. Tim kami akan meninjau laporanmu dalam waktu 24 jam.</p>
                            </div>
                        </details>

                        <details class="faq-item">
                            <summary>
                                <span>Apakah saya bisa menghapus akun saya?</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="6 9 12 15 18 9"></polyline>
                                </svg>
                            </summary>
                            <div class="faq-content">
                                <p>Ya. Untuk saat ini, silakan hubungi kami melalui formulir di samping dengan subjek "Lainnya" dan jelaskan permintaan penghapusan akun. Kami akan memprosesnya secara manual demi keamanan.</p>
                            </div>
                        </details>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="contact-container">
                    <div class="contact-card">
                        <h3>Hubungi Kami</h3>
                        <p class="contact-desc">Tidak menemukan jawaban? Kirim pesan kepada kami.</p>

                        <form id="help-form" action="{{ route('help.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="subject">Topik Bantuan</label>
                                <div class="select-wrapper">
                                    <select id="subject" name="subject" required>
                                        <option value="" disabled selected>Pilih topik...</option>
                                        <option value="Pertanyaan Umum">Pertanyaan Umum</option>
                                        <option value="Masalah Teknis">Masalah Teknis</option>
                                        <option value="Laporkan Pengguna">Laporkan Pengguna</option>
                                        <option value="Saran & Masukan">Saran & Masukan</option>
                                        <option value="Lainnya">Lainnya</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="message">Pesan Anda</label>
                                <textarea id="message" name="message" rows="5"
                                    placeholder="Jelaskan detail masalah atau pertanyaanmu..." required
                                    minlength="10"></textarea>
                            </div>

                            <button type="submit" class="btn-submit">
                                <span>Kirim Pesan</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <line x1="22" y1="2" x2="11" y2="13"></line>
                                    <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="toast" class="toast"></div>
@endsection

@section('scripts')
@push('styles')
    <style>
        .main-content {
            padding: 40px 0;
            background: #f8f9fa;
            min-height: calc(100vh - 70px);
        }

        .help-layout {
            max-width: 1000px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .help-header {
            text-align: center;
            margin-bottom: 50px;
        }

        .help-header h2 {
            font-size: 32px;
            color: #2c3e50;
            margin-bottom: 10px;
            font-weight: 700;
        }

        .help-header p {
            font-size: 16px;
            color: #7f8c8d;
        }

        .help-grid {
            display: grid;
            grid-template-columns: 1.2fr 0.8fr;
            gap: 40px;
            align-items: start;
        }

        /* FAQ Styling */
        .faq-container h3 {
            font-size: 20px;
            color: #2c3e50;
            margin-bottom: 20px;
            padding-left: 5px;
        }

        .faq-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .faq-item {
            background: white;
            border-radius: 12px;
            border: 1px solid #eee;
            overflow: hidden;
            transition: all 0.2s;
        }

        .faq-item:hover {
            border-color: #d0d6c5;
        }

        .faq-item[open] {
            border-color: #6B7B4B;
            box-shadow: 0 4px 15px rgba(107, 123, 75, 0.1);
        }

        .faq-item summary {
            padding: 18px 20px;
            cursor: pointer;
            list-style: none; /* Remove default triangle */
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-weight: 600;
            color: #2c3e50;
        }

        .faq-item summary::-webkit-details-marker {
            display: none;
        }

        .faq-item summary svg {
            color: #95a5a6;
            transition: transform 0.3s;
        }

        .faq-item[open] summary svg {
            transform: rotate(180deg);
            color: #6B7B4B;
        }

        .faq-item[open] summary {
            border-bottom: 1px solid #f0f0f0;
            color: #6B7B4B;
        }

        .faq-content {
            padding: 20px;
            background: #fdfdfd;
            color: #555;
            line-height: 1.6;
            font-size: 15px;
            animation: slideDown 0.3s ease-out;
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-5px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Contact Form */
        .contact-card {
            background: white;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.03);
            border: 1px solid #eee;
            position: sticky;
            top: 100px;
        }

        .contact-card h3 {
            font-size: 20px;
            color: #2c3e50;
            margin-bottom: 5px;
        }

        .contact-desc {
            color: #7f8c8d;
            font-size: 14px;
            margin-bottom: 25px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 8px;
            color: #34495e;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            font-size: 15px;
            font-family: inherit;
            background: #fdfdfd;
            transition: all 0.2s;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #6B7B4B;
            background: white;
            box-shadow: 0 0 0 3px rgba(107, 123, 75, 0.1);
        }

        .btn-submit {
            width: 100%;
            padding: 14px;
            background: #6B7B4B;
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 15px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.2s;
        }

        .btn-submit:hover {
            background: #5a6a3f;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(107, 123, 75, 0.2);
        }

        .btn-submit:disabled {
            background: #ccc;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        /* Toast */
        .toast {
            position: fixed;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%) translateY(100px);
            background: #333;
            color: white;
            padding: 12px 25px;
            border-radius: 30px;
            opacity: 0;
            transition: all 0.3s cubic-bezier(0.68, -0.55, 0.27, 1.55);
            z-index: 1000;
            font-weight: 500;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        .toast.show {
            opacity: 1;
            transform: translateX(-50%) translateY(0);
        }

        .toast.success { background: #6B7B4B; }
        .toast.error { background: #e74c3c; }

        @media (max-width: 768px) {
            .help-grid {
                grid-template-columns: 1fr;
            }
            .contact-card {
                position: static;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.getElementById('help-form').addEventListener('submit', function (e) {
            e.preventDefault();
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            
            submitBtn.innerHTML = '<span>Mengirim...</span>';
            submitBtn.disabled = true;

            const formData = new FormData(this);

            fetch(this.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                },
                body: formData
            })
            .then(r => r.json())
            .then(data => {
                const toast = document.getElementById('toast');
                toast.textContent = data.message;
                toast.className = 'toast show ' + (data.success ? 'success' : 'error');
                
                setTimeout(() => { 
                    toast.classList.remove('show'); 
                }, 3000);

                if (data.success) {
                    this.reset();
                }
            })
            .catch(() => {
                const toast = document.getElementById('toast');
                toast.textContent = "Terjadi kesalahan koneksi";
                toast.className = 'toast show error';
                setTimeout(() => { toast.classList.remove('show'); }, 3000);
            })
            .finally(() => {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            });
        });
    </script>
@endpush
@endsection