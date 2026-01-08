@extends('layouts.app')

@section('title', $user['name'] . ' - RuangRasa')

@section('content')
    <div class="profile-container">
        <!-- Profile Card -->
        <div class="profile-main">
            <div class="profile-card">
                <!-- Back Button -->
                <a href="{{ route('home') }}" class="profile-back">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2">
                        <line x1="19" y1="12" x2="5" y2="12"></line>
                        <polyline points="12 19 5 12 12 5"></polyline>
                    </svg>
                    Profil
                </a>

                <!-- Cover Photo -->
                <div class="profile-cover">
                    @if($user['cover_photo'])
                        <img src="{{ $user['cover_photo'] }}" alt="Cover">
                    @else
                        <img src="https://images.unsplash.com/photo-1518837695005-2083093ee35b?w=800&h=200&fit=crop"
                            alt="Cover">
                    @endif
                </div>

                <!-- Avatar -->
                <div class="profile-avatar-wrapper">
                    <div class="profile-avatar-large">
                        @if($user['avatar'])
                            <img src="{{ $user['avatar'] }}" alt="{{ $user['name'] }}">
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none"
                                stroke="#6B7B4B" stroke-width="2">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                        @endif
                    </div>
                </div>

                <!-- Profile Info -->
                <div class="profile-info">
                    <h1 class="profile-name">{{ $user['name'] }}</h1>
                    <p class="profile-username">{{ '@' . $user['username'] }}</p>

                    <p class="profile-bio">{{ $user['bio'] }}</p>

                    @if($user['website'])
                        <a href="{{ $user['website'] }}" target="_blank" class="profile-website">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2">
                                <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                                <polyline points="15 3 21 3 21 9"></polyline>
                                <line x1="10" y1="14" x2="21" y2="3"></line>
                            </svg>
                            {{ $user['website'] }}
                        </a>
                    @endif

                    <div class="profile-stats">
                        <div class="profile-stat">
                            <strong>{{ $user['following'] }}</strong>
                            <span>Following</span>
                        </div>
                        <div class="profile-stat">
                            <strong>{{ $user['followers'] }}</strong>
                            <span>Followers</span>
                        </div>
                    </div>

                    @if(!$user['isOwner'])
                        <button class="btn-follow {{ isset($user['isFollowing']) && $user['isFollowing'] ? 'following' : '' }}"
                            data-user-id="{{ $user['id'] }}" id="follow-btn">
                            {{ isset($user['isFollowing']) && $user['isFollowing'] ? 'Mengikuti' : 'Ikuti' }}
                        </button>
                    @endif

                    <!-- Hide Profile Toggle (only for owner) -->
                    @if($user['isOwner'])
                        <div class="profile-toggle">
                            <span>Sembunyikan Profil</span>
                            <label class="toggle-switch">
                                <input type="checkbox" {{ $user['hidden'] ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                            </label>
                        </div>
                    @endif
                </div>

                <!-- Profile Tabs -->
                <div class="profile-tabs">
                    @if($user['isOwner'])
                        <a href="{{ route('profil', ['tab' => 'kiriman']) }}"
                            class="profile-tab {{ $activeTab === 'kiriman' ? 'active' : '' }}">Kiriman</a>
                        <a href="{{ route('profil', ['tab' => 'pertanyaan']) }}"
                            class="profile-tab {{ $activeTab === 'pertanyaan' ? 'active' : '' }}">Pertanyaan</a>
                        <a href="{{ route('profil', ['tab' => 'jawaban']) }}"
                            class="profile-tab {{ $activeTab === 'jawaban' ? 'active' : '' }}">Jawaban</a>
                        <a href="{{ route('profil', ['tab' => 'repost']) }}"
                            class="profile-tab {{ $activeTab === 'repost' ? 'active' : '' }}">Postingan Ulang</a>
                    @else
                        <a href="{{ route('profil.show', ['username' => $user['username'], 'tab' => 'kiriman']) }}"
                            class="profile-tab {{ $activeTab === 'kiriman' ? 'active' : '' }}">Kiriman</a>
                        <a href="{{ route('profil.show', ['username' => $user['username'], 'tab' => 'pertanyaan']) }}"
                            class="profile-tab {{ $activeTab === 'pertanyaan' ? 'active' : '' }}">Pertanyaan</a>
                        <a href="{{ route('profil.show', ['username' => $user['username'], 'tab' => 'jawaban']) }}"
                            class="profile-tab {{ $activeTab === 'jawaban' ? 'active' : '' }}">Jawaban</a>
                        <a href="{{ route('profil.show', ['username' => $user['username'], 'tab' => 'repost']) }}"
                            class="profile-tab {{ $activeTab === 'repost' ? 'active' : '' }}">Postingan Ulang</a>
                    @endif
                </div>

                <!-- Tab Content -->
                <div class="profile-posts">
                    @if($activeTab === 'kiriman')
                        <!-- Kiriman/Posts Tab -->
                        @forelse($posts as $post)
                            <x-post-card :post="$post" :showRepostIndicator="false" />
                        @empty
                            <p class="no-more-posts">Tidak ada kiriman lainnya</p>
                        @endforelse

                    @elseif($activeTab === 'pertanyaan')
                        <!-- Pertanyaan Tab -->
                        @forelse($questions as $question)
                            <p class="no-more-posts">Tab Pertanyaan sedang dikembangkan</p>
                        @empty
                            <p class="no-more-posts">Tidak ada Pertanyaan lainnya</p>
                        @endforelse

                    @elseif($activeTab === 'jawaban')
                        <!-- Jawaban Tab -->
                        @forelse($answers as $answer)
                            <p class="no-more-posts">Tab Jawaban sedang dikembangkan</p>
                        @empty
                            <p class="no-more-posts">Tidak ada jawaban lainnya</p>
                        @endforelse

                    @elseif($activeTab === 'repost')
                        <!-- Postingan Ulang Tab -->
                        @forelse($reposts as $repost)
                            <x-post-card :post="$repost" :showRepostIndicator="true" />
                        @empty
                            <p class="no-more-posts">Belum ada postingan ulang</p>
                        @endforelse

                    @elseif($activeTab === 'draft' && $user['isOwner'])
                        <!-- Draft Tab -->
                        @forelse($drafts as $draft)
                            <div class="post-card compact">
                                <span class="draft-badge">Draft</span>
                                <div class="post-content">{{ $draft['content'] }}</div>
                                <div class="post-actions">
                                    <button class="btn-sm btn-primary publish-draft"
                                        data-post-id="{{ $draft['id'] }}">Publish</button>
                                </div>
                            </div>
                        @empty
                            <p class="no-more-posts">Tidak ada draft</p>
                        @endforelse

                    @elseif($activeTab === 'tersimpan' && $user['isOwner'])
                        <!-- Saved Posts Tab -->
                        @forelse($savedPosts as $post)
                            <x-post-card :post="$post" :showRepostIndicator="false" />
                        @empty
                            <p class="no-more-posts">Belum ada kiriman tersimpan</p>
                        @endforelse

                    @elseif($activeTab === 'disukai' && $user['isOwner'])
                        <!-- Liked Posts Tab -->
                        @forelse($likedPosts as $post)
                            <x-post-card :post="$post" :showRepostIndicator="false" />
                        @empty
                            <p class="no-more-posts">Belum ada kiriman yang disukai</p>
                        @endforelse
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar Menu (only show for owner) -->
        @if($user['isOwner'])
            <div class="profile-sidebar">
                <a href="#" class="sidebar-item" onclick="openEditModal(); return false;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                    </svg>
                    <span>Edit Profil</span>
                </a>
                <a href="{{ route('profil', ['tab' => 'draft']) }}" class="sidebar-item">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                    </svg>
                    <span>Draft</span>
                </a>
                <a href="{{ route('profil', ['tab' => 'tersimpan']) }}" class="sidebar-item">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2">
                        <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path>
                    </svg>
                    <span>Tersimpan</span>
                </a>
                <a href="{{ route('profil', ['tab' => 'disukai']) }}" class="sidebar-item">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2">
                        <path
                            d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z">
                        </path>
                    </svg>
                    <span>Disukai</span>
                </a>
                <a href="{{ route('settings') }}" class="sidebar-item">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="3"></circle>
                        <path
                            d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82V9a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z">
                        </path>
                    </svg>
                    <span>Pengaturan</span>
                </a>
                <a href="{{ route('help') }}" class="sidebar-item">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
                        <line x1="12" y1="17" x2="12.01" y2="17"></line>
                    </svg>
                    <span>Bantuan</span>
                </a>
                <a href="{{ route('logout') }}" class="sidebar-item logout"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                        <polyline points="16 17 21 12 16 7"></polyline>
                        <line x1="21" y1="12" x2="9" y2="12"></line>
                    </svg>
                    <span>Keluar</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
            </div>
        @endif
    </div>
@endsection

@push('styles')
    <style>
        .btn-follow {
            padding: 10px 30px;
            background: #6B7B4B;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            margin-top: 15px;
            transition: all 0.2s;
        }

        .btn-follow:hover {
            background: #5a6a3f;
        }

        .btn-follow.following {
            background: transparent;
            color: #6B7B4B;
            border: 2px solid #6B7B4B;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const followBtn = document.getElementById('follow-btn');
            if (followBtn) {
                followBtn.addEventListener('click', function () {
                    const userId = this.dataset.userId;
                    fetch(`/user/${userId}/follow`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                        }
                    })
                        .then(r => r.json())
                        .then(data => {
                            if (data.success) {
                                this.textContent = data.following ? 'Mengikuti' : 'Ikuti';
                                this.classList.toggle('following', data.following);
                                // Update followers count
                                const stats = document.querySelectorAll('.profile-stat');
                                if (stats[1]) {
                                    stats[1].querySelector('strong').textContent = data.followers_count;
                                }
                            }
                        });
                });
            }
        });
    </script>
@endpush