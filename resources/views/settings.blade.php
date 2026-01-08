@extends('layouts.app')

@section('title', 'Pengaturan - RuangRasa')

@section('content')
    <div class="main-content">
        <div class="settings-layout">
            <!-- Sidebar Navigation -->
            <div class="settings-sidebar">
                <h2 class="settings-title">Pengaturan</h2>
                <nav class="settings-nav">
                    <button class="nav-item active" data-tab="account">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        <span>Akun</span>
                    </button>
                    <button class="nav-item" data-tab="security">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                        </svg>
                        <span>Keamanan</span>
                    </button>
                    <button class="nav-item" data-tab="privacy">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                        <span>Privasi</span>
                    </button>
                    <button class="nav-item" data-tab="help">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
                            <line x1="12" y1="17" x2="12.01" y2="17"></line>
                        </svg>
                        <span>Bantuan</span>
                    </button>
                    <div class="nav-divider"></div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="nav-item logout">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                <polyline points="16 17 21 12 16 7"></polyline>
                                <line x1="21" y1="12" x2="9" y2="12"></line>
                            </svg>
                            <span>Keluar</span>
                        </button>
                    </form>
                </nav>
            </div>

            <!-- Content Area -->
            <div class="settings-content-area">
                <!-- Account Tab -->
                <div id="account" class="tab-content active">
                    <div class="content-header">
                        <h3>Pengaturan Akun</h3>
                        <p>Kelola informasi dasar dan preferensi akunmu.</p>
                    </div>

                    <div class="settings-card">
                        <h4>Alamat Email</h4>
                        <form id="email-form" class="settings-form">
                            @csrf
                            <div class="form-group">
                                <label for="email">Email Saat Ini</label>
                                <input type="email" id="email" name="email" value="{{ $user->email }}" required>
                            </div>
                            <div class="form-group">
                                <label for="password-email">Konfirmasi Password</label>
                                <input type="password" id="password-email" name="password"
                                    placeholder="Masukkan password untuk konfirmasi" required>
                            </div>
                            <div class="form-actions">
                                <button type="submit" class="btn-primary">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>

                    <div class="settings-card">
                        <h4>Bahasa</h4>
                        <form id="language-form" class="settings-form">
                            @csrf
                            <div class="form-group">
                                <label for="language">Pilih Bahasa</label>
                                <div class="select-wrapper">
                                    <select id="language" name="language">
                                        <option value="id" {{ ($user->language ?? 'id') === 'id' ? 'selected' : '' }}>Bahasa
                                            Indonesia</option>
                                        <option value="en" {{ ($user->language ?? 'id') === 'en' ? 'selected' : '' }}>English
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-actions">
                                <button type="submit" class="btn-primary">Simpan Bahasa</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Security Tab -->
                <div id="security" class="tab-content">
                    <div class="content-header">
                        <h3>Keamanan</h3>
                        <p>Jaga keamanan akunmu dengan password yang kuat.</p>
                    </div>

                    <div class="settings-card">
                        <h4>Ubah Password</h4>
                        <form id="password-form" class="settings-form">
                            @csrf
                            <div class="form-group">
                                <label for="current_password">Password Saat Ini</label>
                                <input type="password" id="current_password" name="current_password" required>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="password">Password Baru</label>
                                    <input type="password" id="password" name="password" required minlength="8"
                                        placeholder="Minimal 8 karakter">
                                </div>
                                <div class="form-group">
                                    <label for="password_confirmation">Konfirmasi Password</label>
                                    <input type="password" id="password_confirmation" name="password_confirmation" required
                                        placeholder="Ulangi password baru">
                                </div>
                            </div>
                            <div class="form-actions">
                                <button type="submit" class="btn-primary">Ubah Password</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Privacy Tab -->
                <div id="privacy" class="tab-content">
                    <div class="content-header">
                        <h3>Privasi</h3>
                        <p>Kontrol siapa yang dapat melihat profil dan aktivitasmu.</p>
                    </div>

                    <div class="settings-card">
                        <h4>Visibilitas Profil</h4>
                        <form id="privacy-form" class="settings-form">
                            @csrf
                            <div class="toggle-group">
                                <div class="toggle-text">
                                    <label for="is_profile_hidden">Mode Privat</label>
                                    <p>Jika diaktifkan, profil dan postinganmu hanya terlihat oleh pengikut.</p>
                                </div>
                                <label class="switch">
                                    <input type="checkbox" id="is_profile_hidden" name="is_profile_hidden" {{ ($user->is_profile_hidden ?? false) ? 'checked' : '' }}>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                            <div class="form-actions">
                                <button type="submit" class="btn-primary">Simpan Pengaturan</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Help Tab -->
                <div id="help" class="tab-content">
                    <div class="content-header">
                        <h3>Bantuan</h3>
                        <p>Pusat bantuan dan dukungan pengguna.</p>
                    </div>

                    <div class="help-grid">
                        <div class="help-card">
                            <div class="help-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
                                    <line x1="12" y1="17" x2="12.01" y2="17"></line>
                                </svg>
                            </div>
                            <h4>Pusat Bantuan</h4>
                            <p>Temukan jawaban untuk pertanyaan umum.</p>
                            <a href="{{ route('help') }}" class="btn-outline">Kunjungi FAQ</a>
                        </div>
                        <div class="help-card">
                            <div class="help-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z">
                                    </path>
                                    <polyline points="22,6 12,13 2,6"></polyline>
                                </svg>
                            </div>
                            <h4>Hubungi Kami</h4>
                            <p>Kirim pesan kepada tim support.</p>
                            <a href="mailto:support@ruangrasa.com" class="btn-outline">Kirim Email</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
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

            .settings-layout {
                display: grid;
                grid-template-columns: 280px 1fr;
                gap: 40px;
                max-width: 1100px;
                margin: 0 auto;
                padding: 0 20px;
            }

            /* Sidebar */
            .settings-sidebar {
                position: sticky;
                top: 100px;
                align-self: start;
            }

            .settings-title {
                font-size: 24px;
                margin-bottom: 25px;
                color: #2c3e50;
                font-weight: 700;
            }

            .settings-nav {
                background: white;
                border-radius: 16px;
                padding: 10px;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
                display: flex;
                flex-direction: column;
                gap: 5px;
            }

            .nav-item {
                display: flex;
                align-items: center;
                gap: 12px;
                padding: 12px 20px;
                width: 100%;
                border: none;
                background: transparent;
                color: #666;
                font-size: 15px;
                font-weight: 500;
                cursor: pointer;
                border-radius: 10px;
                transition: all 0.2s;
                text-align: left;
            }

            .nav-item:hover {
                background: #f5f7f2;
                color: #6B7B4B;
            }

            .nav-item.active {
                background: #ebf0e6;
                color: #6B7B4B;
                font-weight: 600;
            }

            .nav-item svg {
                stroke-width: 2px;
            }

            .nav-divider {
                height: 1px;
                background: #eee;
                margin: 5px 15px;
            }

            .nav-item.logout {
                color: #e74c3c;
            }

            .nav-item.logout:hover {
                background: #feeced;
                color: #c0392b;
            }

            /* Content Area */
            .tab-content {
                display: none;
                animation: fadeIn 0.3s ease;
            }

            .tab-content.active {
                display: block;
            }

            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(10px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .content-header {
                margin-bottom: 30px;
            }

            .content-header h3 {
                font-size: 24px;
                color: #2c3e50;
                margin-bottom: 8px;
            }

            .content-header p {
                color: #7f8c8d;
                font-size: 15px;
            }

            .settings-card {
                background: white;
                border-radius: 16px;
                padding: 30px;
                margin-bottom: 25px;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
                border: 1px solid #f0f0f0;
            }

            .settings-card h4 {
                font-size: 18px;
                color: #34495e;
                margin-bottom: 25px;
                border-bottom: 1px solid #eee;
                padding-bottom: 15px;
            }

            .settings-form {
                display: flex;
                flex-direction: column;
                gap: 20px;
            }

            .form-row {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 20px;
            }

            .form-group {
                display: flex;
                flex-direction: column;
                gap: 8px;
            }

            .form-group label {
                font-size: 14px;
                font-weight: 600;
                color: #2c3e50;
            }

            .form-group input,
            .form-group select {
                padding: 12px 16px;
                border: 1px solid #e0e0e0;
                border-radius: 10px;
                font-size: 15px;
                transition: all 0.2s;
                background: #fdfdfd;
            }

            .form-group input:focus,
            .form-group select:focus {
                border-color: #6B7B4B;
                outline: none;
                box-shadow: 0 0 0 3px rgba(107, 123, 75, 0.1);
                background: white;
            }

            /* Toggle Switch */
            .toggle-group {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .toggle-text label {
                font-size: 16px;
                font-weight: 600;
                color: #2c3e50;
                display: block;
                margin-bottom: 5px;
            }

            .toggle-text p {
                font-size: 14px;
                color: #7f8c8d;
            }

            .switch {
                position: relative;
                display: inline-block;
                width: 50px;
                height: 26px;
            }

            .switch input {
                opacity: 0;
                width: 0;
                height: 0;
            }

            .slider {
                position: absolute;
                cursor: pointer;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: #ccc;
                transition: .4s;
            }

            .slider:before {
                position: absolute;
                content: "";
                height: 20px;
                width: 20px;
                left: 3px;
                bottom: 3px;
                background-color: white;
                transition: .4s;
            }

            input:checked+.slider {
                background-color: #6B7B4B;
            }

            input:checked+.slider:before {
                transform: translateX(24px);
            }

            .slider.round {
                border-radius: 34px;
            }

            .slider.round:before {
                border-radius: 50%;
            }

            /* Buttons */
            .form-actions {
                margin-top: 10px;
                display: flex;
                justify-content: flex-end;
            }

            .btn-primary {
                background: #6B7B4B;
                color: white;
                border: none;
                padding: 12px 25px;
                border-radius: 10px;
                font-weight: 600;
                cursor: pointer;
                font-size: 14px;
                transition: all 0.2s;
            }

            .btn-primary:hover {
                background: #5a6a3f;
                transform: translateY(-1px);
                box-shadow: 0 4px 12px rgba(107, 123, 75, 0.2);
            }

            .btn-outline {
                display: inline-block;
                padding: 10px 20px;
                border: 1px solid #ddd;
                border-radius: 8px;
                text-decoration: none;
                color: #555;
                font-size: 14px;
                font-weight: 500;
                transition: all 0.2s;
                margin-top: 15px;
            }

            .btn-outline:hover {
                border-color: #6B7B4B;
                color: #6B7B4B;
                background: #f9fbf7;
            }

            /* Help Cards */
            .help-grid {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 20px;
            }

            .help-card {
                background: white;
                padding: 30px;
                border-radius: 16px;
                text-align: center;
                border: 1px solid #eee;
                transition: all 0.2s;
            }

            .help-card:hover {
                transform: translateY(-3px);
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
                border-color: #6B7B4B;
            }

            .help-icon {
                width: 60px;
                height: 60px;
                background: #ebf0e6;
                color: #6B7B4B;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 0 auto 15px;
            }

            .help-card h4 {
                font-size: 18px;
                margin-bottom: 10px;
            }

            .help-card p {
                color: #7f8c8d;
                font-size: 14px;
                margin-bottom: 5px;
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
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            }

            .toast.show {
                opacity: 1;
                transform: translateX(-50%) translateY(0);
            }

            .toast.error {
                background: #e74c3c;
            }

            .toast.success {
                background: #6B7B4B;
            }

            @media (max-width: 768px) {
                .settings-layout {
                    grid-template-columns: 1fr;
                }

                .settings-sidebar {
                    position: static;
                }

                .nav-item {
                    padding: 15px;
                }

                .form-row,
                .help-grid {
                    grid-template-columns: 1fr;
                }
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Tab Switching Logic
                const navItems = document.querySelectorAll('.nav-item[data-tab]');
                const tabContents = document.querySelectorAll('.tab-content');

                navItems.forEach(item => {
                    item.addEventListener('click', () => {
                        const targetTab = item.dataset.tab;

                        // Update Active State
                        navItems.forEach(nav => nav.classList.remove('active'));
                        item.classList.add('active');

                        // Show Content
                        tabContents.forEach(content => {
                            content.classList.remove('active');
                            if (content.id === targetTab) {
                                content.classList.add('active');
                            }
                        });
                    });
                });

                // Form Handling (AJAX)
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                function showToast(message, type = 'success') {
                    const toast = document.getElementById('toast');
                    toast.textContent = message;
                    toast.className = 'toast show ' + type;
                    setTimeout(() => { toast.classList.remove('show'); }, 3000);
                }

                function handleFormSubmit(formId, route, dataCallback) {
                    const form = document.getElementById(formId);
                    if (form) {
                        form.addEventListener('submit', function (e) {
                            e.preventDefault();
                            const submitBtn = form.querySelector('button[type="submit"]');
                            const originalText = submitBtn.textContent;
                            submitBtn.textContent = 'Menyimpan...';
                            submitBtn.disabled = true;

                            fetch(route, {
                                method: 'PUT',
                                headers: {
                                    'X-CSRF-TOKEN': csrfToken,
                                    'Accept': 'application/json',
                                    'Content-Type': 'application/json',
                                },
                                body: JSON.stringify(dataCallback())
                            })
                                .then(r => r.json())
                                .then(data => {
                                    showToast(data.message, data.success ? 'success' : 'error');
                                    if (data.success && formId === 'password-form') {
                                        form.reset();
                                    }
                                })
                                .catch(err => showToast('Terjadi kesalahan', 'error'))
                                .finally(() => {
                                    submitBtn.textContent = originalText;
                                    submitBtn.disabled = false;
                                });
                        });
                    }
                }

                // Email Form
                handleFormSubmit('email-form', '{{ route("settings.email") }}', () => ({
                    email: document.getElementById('email').value,
                    password: document.getElementById('password-email').value,
                }));

                // Language Form
                handleFormSubmit('language-form', '{{ route("settings.language") }}', () => ({
                    language: document.getElementById('language').value,
                }));

                // Password Form
                handleFormSubmit('password-form', '{{ route("settings.password") }}', () => ({
                    current_password: document.getElementById('current_password').value,
                    password: document.getElementById('password').value,
                    password_confirmation: document.getElementById('password_confirmation').value,
                }));

                // Privacy Form
                handleFormSubmit('privacy-form', '{{ route("settings.privacy") }}', () => ({
                    is_profile_hidden: document.getElementById('is_profile_hidden').checked,
                }));
            });
        </script>
    @endpush
@endsection