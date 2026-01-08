@extends('layouts.app')

@section('title', 'Cari - RuangRasa')

@section('content')
    <div class="main-layout">
        <!-- Sidebar Left Placeholder -->
        <div class="sidebar-left"></div>

        <!-- Main Content -->
        <div class="main-feed">
            <div class="search-header">
                <h2>Hasil Pencarian</h2>
                @if($query)
                    <p>Menampilkan hasil untuk "<strong>{{ $query }}</strong>"</p>
                @endif
            </div>

            <div class="search-box" style="margin-bottom: 24px;">
                <form action="{{ route('search') }}" method="GET" class="search-form-main">
                    <input type="text" name="q" value="{{ $query }}" placeholder="Cari postingan atau pengguna..."
                        class="search-input-main">
                    <button type="submit" class="search-btn-main">Cari</button>
                </form>
            </div>

            @if($query && strlen($query) >= 2)
                <!-- Users Results -->
                @if($users->count() > 0)
                    <div class="search-section">
                        <h3>Pengguna ({{ $users->count() }})</h3>
                        <div class="users-grid">
                            @foreach($users as $user)
                                <a href="{{ route('profil.show', $user->username ?? $user->id) }}" class="user-card-search">
                                    <div class="user-avatar-search">
                                        @if($user->avatar)
                                            <img src="{{ $user->avatar }}" alt="{{ $user->name }}">
                                        @else
                                            <div class="avatar-placeholder">{{ substr($user->name, 0, 1) }}</div>
                                        @endif
                                    </div>
                                    <div class="user-info-search">
                                        <span class="user-name-search">{{ $user->name }}</span>
                                        <span class="user-username-search">{{ '@' . ($user->username ?? $user->name) }}</span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Posts Results with Interactive Cards -->
                @if($posts->count() > 0)
                    <div class="search-section">
                        <h3>Postingan ({{ $posts->count() }})</h3>
                        <div class="posts-results">
                            @foreach($posts as $post)
                                <x-post-card :post="$post" :showRepostIndicator="false" />
                            @endforeach
                        </div>
                    </div>
                @endif

                @if($users->count() === 0 && $posts->count() === 0)
                    <div class="empty-state">
                        <div class="empty-icon">🔍</div>
                        <h3>Tidak ada hasil ditemukan</h3>
                        <p>Coba gunakan kata kunci yang berbeda untuk "{{ $query }}"</p>
                    </div>
                @endif
            @else
                <div class="empty-state">
                    <div class="empty-icon">💭</div>
                    <h3>Mulai Pencarian</h3>
                    <p>Ketik minimal 2 karakter untuk mencari postingan atau pengguna</p>
                </div>
            @endif
        </div>

        <!-- Sidebar Right Placeholder -->
        <div class="sidebar-right"></div>
    </div>
@endsection

@push('styles')
    <style>
        /* Search Page Specific Styles */
        .search-header {
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 1px solid var(--border-color);
        }

        .search-header h2 {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 8px;
        }

        .search-header p {
            color: var(--text-medium);
            font-size: 0.95rem;
        }

        .search-form-main {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .search-input-main {
            flex: 1;
            padding: 14px 18px;
            border: 2px solid #E5E7EB;
            border-radius: 12px;
            font-size: 0.95rem;
            font-family: inherit;
            background: white;
            transition: all 0.3s ease;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .search-input-main:focus {
            outline: none;
            border-color: #3B82F6;
            border-top-width: 3px;
            border-top-color: #3B82F6;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.12);
        }

        .search-btn-main {
            padding: 14px 28px;
            background: var(--primary-green);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        .search-btn-main:hover {
            background: var(--primary-green-hover);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(107, 123, 75, 0.3);
        }

        .search-section {
            margin-bottom: 32px;
        }

        .search-section h3 {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 16px;
            padding-bottom: 8px;
            border-bottom: 2px solid var(--light-sage);
        }

        /* Users Grid */
        .users-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 12px;
            margin-bottom: 24px;
        }

        .user-card-search {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px;
            background: white;
            border-radius: 12px;
            border: 1px solid var(--border-color);
            text-decoration: none;
            color: inherit;
            transition: all 0.3s ease;
        }

        .user-card-search:hover {
            background: var(--light-sage);
            border-color: var(--primary-green);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(107, 123, 75, 0.15);
        }

        .user-avatar-search {
            width: 48px;
            height: 48px;
            border-radius: var(--radius-full);
            background: var(--light-sage);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            flex-shrink: 0;
        }

        .user-avatar-search img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .user-avatar-search .avatar-placeholder {
            font-weight: 600;
            font-size: 1.2rem;
            color: var(--text-green);
        }

        .user-info-search {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .user-name-search {
            font-weight: 600;
            font-size: 0.95rem;
            color: var(--text-dark);
        }

        .user-username-search {
            color: var(--text-medium);
            font-size: 0.85rem;
        }

        /* Posts Results */
        .posts-results {
            display: flex;
            flex-direction: column;
            gap: var(--spacing-lg);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            background: white;
            border-radius: var(--radius-lg);
            border: 1px solid var(--border-color);
        }

        .empty-icon {
            font-size: 4rem;
            margin-bottom: 16px;
        }

        .empty-state h3 {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 8px;
        }

        .empty-state p {
            color: var(--text-medium);
            font-size: 0.95rem;
        }

        @media (max-width: 768px) {
            .users-grid {
                grid-template-columns: 1fr;
            }

            .search-form-main {
                flex-direction: column;
            }

            .search-btn-main {
                width: 100%;
            }
        }
    </style>
@endpush