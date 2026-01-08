@extends('layouts.auth')

@section('title', 'Masuk - RuangRasa')

@section('content')
    <div class="auth-background">
        <!-- Watermark Background -->
        <div class="watermark-pattern">
            @for($i = 0; $i < 15; $i++)
                <div class="watermark-text" style="top: {{ $i * 80 }}px; left: -200px;">
                    RuangRasa RuangRasa RuangRasa RuangRasa RuangRasa RuangRasa RuangRasa RuangRasa
                </div>
            @endfor
        </div>

        <!-- Auth Card -->
        <div class="auth-card">
            <div class="auth-header">
                <h1 class="auth-logo">RuangRasa</h1>
                <p class="auth-tagline">Ruang tenang untuk memahami kehidupan.</p>
            </div>

            <div class="auth-content">
                <!-- Social Login Section -->
                <div class="social-login">
                    <p class="social-disclaimer">
                        Dengan melanjutkan, Anda menunjukkan bahwa Anda menyetujui Persyaratan Layanan dan Kebijakan Privasi
                        Quora.
                    </p>

                    <button class="social-btn" type="button">
                        <span class="social-btn-icon">
                            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"
                                    fill="#4285F4" />
                                <path
                                    d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"
                                    fill="#34A853" />
                                <path
                                    d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"
                                    fill="#FBBC05" />
                                <path
                                    d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"
                                    fill="#EA4335" />
                            </svg>
                        </span>
                        Lanjutkan dengan Google
                    </button>

                    <button class="social-btn" type="button">
                        <span class="social-btn-icon">
                            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"
                                    fill="#1877F2" />
                            </svg>
                        </span>
                        Lanjutkan dengan Facebook
                    </button>

                    <a href="javascript:void(0)" class="email-register-link" onclick="openModal('registerModal')">
                        Daftar dengan Email
                    </a>
                </div>

                <!-- Login Form Section -->
                <div class="login-form-section">
                    <h2>Masuk</h2>

                    @if($errors->any())
                        <div style="background: #ffe0e0; padding: 10px; border-radius: 8px; margin-bottom: 15px; color: #c00;">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form action="{{ route('login') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="username">Nama Pengguna</label>
                            <input type="text" id="username" name="username" class="form-control"
                                placeholder="Masukkan nama pengguna anda..." value="{{ old('username') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="password">Kata Sandi</label>
                            <input type="password" id="password" name="password" class="form-control"
                                placeholder="Masukkan kata sandi anda..." required>
                        </div>

                        <a href="javascript:void(0)" class="forgot-password">Lupa kata sandi?</a>

                        <button type="submit" class="btn btn-primary">Masuk</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Register Modal -->
    <div class="modal-overlay" id="registerModal">
        <div class="modal-content">
            <button class="modal-close" onclick="closeModal('registerModal')">&times;</button>
            <h3 class="modal-title">Daftar</h3>

            <form action="{{ route('register') }}" method="POST" id="registerForm">
                @csrf

                <div class="form-group">
                    <label for="reg_nama">Nama</label>
                    <input type="text" id="reg_nama" name="name" class="form-control" placeholder="Masukkan nama anda..."
                        required>
                </div>

                <div class="form-group">
                    <label for="reg_username">Nama Pengguna</label>
                    <input type="text" id="reg_username" name="username" class="form-control"
                        placeholder="Masukkan nama pengguna anda..." required>
                </div>

                <div class="form-group">
                    <label for="reg_email">Email</label>
                    <input type="email" id="reg_email" name="email" class="form-control"
                        placeholder="Masukkan email anda..." required>
                </div>

                <div class="form-group">
                    <label for="reg_password">Kata Sandi</label>
                    <input type="password" id="reg_password" name="password" class="form-control"
                        placeholder="Masukkan kata sandi anda..." required>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Selanjutnya</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Email Confirmation Modal -->
    <div class="modal-overlay" id="emailConfirmModal">
        <div class="modal-content">
            <button class="modal-close" onclick="closeModal('emailConfirmModal')">&times;</button>
            <h3 class="modal-title">Konfirmasikan Email Anda</h3>

            <p style="margin-bottom: 20px;"><strong>Masukkan kode yang dikirimkan ke email anda</strong></p>

            <div class="form-group">
                <input type="text" id="verification_code" class="form-control" placeholder="Masukkan kode disini..."
                    maxlength="6">
            </div>

            <p style="font-size: 0.85rem; color: #666; margin-bottom: 30px;">
                Tidak menerima email atau ada yang salah? <a href="javascript:void(0)" style="color: #6B7B4B;">Kirim ulang
                    kode</a>
            </p>

            <div class="text-center">
                <button type="button" class="btn btn-primary" onclick="verifyEmail()">Selanjutnya</button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function openModal(modalId) {
            document.getElementById(modalId).classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.remove('active');
            document.body.style.overflow = 'auto';
        }

        // Close modal on overlay click
        document.querySelectorAll('.modal-overlay').forEach(function (overlay) {
            overlay.addEventListener('click', function (e) {
                if (e.target === this) {
                    this.classList.remove('active');
                    document.body.style.overflow = 'auto';
                }
            });
        });

        // Close modal on Escape key
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                document.querySelectorAll('.modal-overlay.active').forEach(function (modal) {
                    modal.classList.remove('active');
                });
                document.body.style.overflow = 'auto';
            }
        });

        function verifyEmail() {
            // Placeholder for email verification logic
            alert('Verifikasi email berhasil!');
            closeModal('emailConfirmModal');
        }
    </script>
@endpush

@push('styles')
    <style>
        /* Additional auth-specific styles */
        .watermark-pattern {
            background: linear-gradient(135deg, var(--background-cream) 0%, var(--background-light) 100%);
        }

        .watermark-text {
            font-size: 2.5rem;
            transform: rotate(-5deg);
            line-height: 1.5;
        }

        @media (max-width: 768px) {
            .watermark-text {
                font-size: 1.5rem;
            }
        }
    </style>
@endpush