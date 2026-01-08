@extends('layouts.app')

@section('title', 'Beranda - RuangRasa')

@section('content')
    <div class="main-layout">
        <!-- Sidebar Left - Navigation & User Info -->
        <div class="sidebar-left">
            <div class="user-mini-profile">
                <div class="mini-profile-avatar">
                    @if(auth()->user()->avatar)
                        <img src="{{ auth()->user()->avatar }}" alt="{{ auth()->user()->name }}">
                    @else
                        <div class="avatar-placeholder">{{ substr(auth()->user()->name, 0, 1) }}</div>
                    @endif
                </div>
                <div class="mini-profile-info">
                    <h3>{{ auth()->user()->name }}</h3>
                    <p>{{ '@' . auth()->user()->username }}</p>
                </div>
                <div class="mini-profile-stats">
                    <div class="stat-item">
                        <span class="stat-value">{{ auth()->user()->followingCount() }}</span>
                        <span class="stat-label">Mengikuti</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-value">{{ auth()->user()->followersCount() }}</span>
                        <span class="stat-label">Teman Berpikir</span>
                    </div>
                </div>
            </div>

            <div class="sidebar-menu">
                <a href="{{ route('home') }}" class="menu-item active">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                    </svg>
                    Beranda
                </a>
                <a href="{{ route('profil') }}" class="menu-item">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                    Profil Saya
                </a>
                <a href="{{ route('profil', ['tab' => 'tersimpan']) }}" class="menu-item">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2">
                        <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path>
                    </svg>
                    Tersimpan
                </a>
            </div>
        </div>

        <!-- Main Content - Feed -->
        <div class="feed-content">
            <!-- Create Post Section -->
            <div class="create-post-card">
                <form id="create-post-form" action="{{ route('post.store') }}" method="POST">
                    @csrf
                    <div class="create-post-input-row">
                        <div class="create-post-avatar">
                            @if(auth()->user()->avatar)
                                <img src="{{ auth()->user()->avatar }}" alt="{{ auth()->user()->name }}">
                            @else
                                <div class="avatar-placeholder">{{ substr(auth()->user()->name, 0, 1) }}</div>
                            @endif
                        </div>
                        <textarea name="content" class="create-post-input" id="post-content"
                            placeholder="Bagikan rasa, refleksi, atau pertanyaanmu..." required></textarea>
                    </div>
                    <div class="create-post-actions">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <select name="category_id" id="category-select" class="category-select" required>
                                <option value="">Pilih Ruang...</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->icon }} {{ $category->name }}</option>
                                @endforeach
                            </select>
                            <label class="anonymous-label">
                                <input type="checkbox" name="is_anonymous" value="1">
                                <span>Anonim</span>
                            </label>
                        </div>
                        <button type="submit" class="create-post-submit">Bagikan Rasa</button>
                    </div>
                </form>
            </div>

            <!-- Posts Feed -->
            @foreach($posts as $post)
                <x-post-card :post="$post" />
            @endforeach

            @if($posts->isEmpty())
                <div class="empty-state">
                    <div class="empty-icon">🌱</div>
                    <h3>Ruang Belum Terisi</h3>
                    <p>Jadilah yang pertama menanam benih percakapan di ruang yang kamu ikuti.</p>
                </div>
            @endif
        </div>

        <!-- Sidebar Right - Room Suggestions -->
        <div class="sidebar-right">
            <div class="sidebar-card">
                <h3>Ruang Kehidupan</h3>
                <p class="sidebar-desc">Ikuti ruang untuk menyaring percakapan yang sesuai dengan kondisimu saat ini.</p>

                <div class="rooms-list">
                    @foreach($categories->take(5) as $category)
                        <div class="room-item">
                            <div class="room-info">
                                <span class="room-icon">{{ $category->icon }}</span>
                                <span class="room-name">{{ $category->name }}</span>
                            </div>
                            <button class="btn-follow-room {{ $category->is_followed ? 'following' : '' }}"
                                data-room-id="{{ $category->id }}" onclick="toggleRoomFollow(this, {{ $category->id }})">
                                {{ $category->is_followed ? 'Mengikuti' : 'Ikuti' }}
                            </button>
                        </div>
                    @endforeach
                    <a href="{{ route('komunitas') }}" class="view-all-rooms">Lihat Semua Ruang →</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div id="toast" class="toast"></div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Toggle Room Follow Function
            window.toggleRoomFollow = function (btn, roomId) {
                fetch(`/room/${roomId}/follow`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    }
                })
                    .then(r => r.json())
                    .then(data => {
                        if (data.success) {
                            btn.textContent = data.following ? 'Mengikuti' : 'Ikuti';
                            btn.classList.toggle('following', data.following);
                            // Optional: Reload implementation to filter feed immediately
                            // But for UX, maybe just show toast
                            showToast(data.message);
                        }
                    })
                    .catch(err => console.error(err));
            };

            // Toast notification helper
            function showToast(message, type = 'success') {
                const toast = document.getElementById('toast');
                toast.textContent = message;
                toast.className = 'toast show ' + type;
                setTimeout(() => { toast.className = 'toast'; }, 3000);
            }

            // Create Post Form
            const createPostForm = document.getElementById('create-post-form');
            if (createPostForm) {
                createPostForm.addEventListener('submit', function (e) {
                    e.preventDefault();
                    const formData = new FormData(this);

                    fetch(this.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                        },
                        body: formData
                    })
                        .then(r => r.json())
                        .then(data => {
                            if (data.success) {
                                showToast('Rasa berhasil dibagikan');
                                location.reload();
                            } else {
                                showToast(data.message || 'Gagal', 'error');
                            }
                        });
                });
            }

            // Note: Like, Comment, Reshare, Save handled by interactions.js
        });
    </script>
@endpush

@push('styles')
    <style>
        /* New Layout Styles */
        .main-layout {
            display: grid;
            grid-template-columns: 280px 1fr 300px;
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
            align-items: start;
        }

        /* Sidebar Left */
        .sidebar-left {
            position: sticky;
            top: 20px;
        }

        .user-mini-profile {
            background: white;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            border: 1px solid #eee;
            margin-bottom: 20px;
        }

        .mini-profile-avatar img,
        .avatar-placeholder {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            object-fit: cover;
            margin: 0 auto 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #e8e5da;
            color: #6B7B4B;
            font-size: 24px;
            font-weight: bold;
        }

        .avatar-placeholder.anon {
            background: #333;
            color: #fff;
        }

        .mini-profile-info h3 {
            font-size: 16px;
            margin-bottom: 4px;
        }

        .mini-profile-stats {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #f0f0f0;
        }

        .stat-item {
            display: flex;
            flex-direction: column;
        }

        .stat-value {
            font-weight: bold;
            font-size: 16px;
        }

        .stat-label {
            font-size: 11px;
            color: #777;
            text-transform: uppercase;
        }

        .sidebar-menu {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #eee;
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 15px 20px;
            color: #555;
            transition: all 0.2s;
        }

        .menu-item:hover,
        .menu-item.active {
            background: #fcfcf9;
            color: #6B7B4B;
            font-weight: 500;
        }

        /* Feed Content */
        .feed-content {
            min-width: 0;
        }

        .create-post-card {
            background: white;
            border: 1px solid #eee;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02);
        }

        /* Post Card Specifics */
        .post-card {
            border: none;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02);
            transition: transform 0.2s;
        }

        .post-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        }

        .post-type-question {
            border-left: 4px solid #d4a373;
            /* Earthy orange for questions */
        }

        .repost-indicator {
            font-size: 12px;
            color: #777;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .post-meta {
            font-size: 12px;
            color: #888;
            margin-top: 2px;
        }

        .post-room-badge {
            background: #f0f4ec;
            color: #6B7B4B;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 11px;
            font-weight: 500;
        }

        .post-author-name {
            font-weight: 700;
            color: #333;
        }

        /* Actions */
        .post-actions {
            justify-content: space-between;
            border-top: 1px solid #f8f8f8;
        }

        .post-action-btn {
            padding: 8px 12px;
            border-radius: 8px;
        }

        .post-action-btn:hover {
            background: #f5f5f5;
        }

        .action-label {
            font-size: 13px;
            /* Only label visible by default? */
            display: none;
            /* Hidden on mobile usually, ensure visible on desktop if needed */
        }

        @media (min-width: 768px) {
            .action-label {
                display: inline;
            }
        }

        .hidden-metric {
            opacity: 0;
            transition: opacity 0.2s;
            font-size: 12px;
        }

        .post-action-btn:hover .hidden-metric {
            opacity: 1;
        }

        /* Sidebar Right - Rooms */
        .sidebar-right {
            position: sticky;
            top: 20px;
        }

        .sidebar-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            border: 1px solid #eee;
        }

        .sidebar-desc {
            font-size: 13px;
            color: #666;
            margin-bottom: 20px;
            line-height: 1.5;
        }

        .view-all-rooms {
            display: block;
            text-align: center;
            margin-top: 15px;
            font-size: 13px;
            color: #6B7B4B;
            font-weight: 600;
            text-decoration: none;
        }

        .view-all-rooms:hover {
            text-decoration: underline;
        }

        .rooms-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .room-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            /* Ensure space between name and button */
        }

        .room-info {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 500;
            font-size: 14px;
            overflow: hidden;
            /* Prevent text spill */
        }

        .room-name {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 140px;
            /* Adjust based on sidebar width */
        }

        .btn-follow-room {
            border: 1px solid #6B7B4B;
            background: transparent;
            color: #6B7B4B;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            cursor: pointer;
            transition: all 0.2s;
            white-space: nowrap;
            /* Prevent button text wrapping */
            flex-shrink: 0;
            /* Prevent button from shrinking */
        }

        .btn-follow-room.following {
            background: #6B7B4B;
            color: white;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            background: white;
            border-radius: 12px;
            color: #666;
        }

        .empty-icon {
            font-size: 48px;
            margin-bottom: 15px;
        }

        @media (max-width: 992px) {
            .main-layout {
                grid-template-columns: 1fr;
            }

            .sidebar-left,
            .sidebar-right {
                display: none;
            }
        }
    </style>
@endpush