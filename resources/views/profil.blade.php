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

    <!-- Edit Profile Modal -->
    @if($user['isOwner'])
        <div id="editProfileModal" class="modal-overlay" style="display: none;">
            <div class="modal-content edit-profile-modal">
                <div class="modal-header">
                    <h2>Edit Profil</h2>
                    <button type="button" class="modal-close" onclick="closeEditModal()">&times;</button>
                </div>
                <form id="editProfileForm" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <!-- Cover Photo Upload -->
                        <div class="photo-upload-section">
                            <label class="upload-label">Cover Photo</label>
                            <div class="cover-upload-area" id="coverUploadArea">
                                <div class="cover-preview" id="coverPreview">
                                    @if($user['cover_photo'])
                                        <img src="{{ $user['cover_photo'] }}" alt="Cover Preview" id="coverPreviewImg">
                                    @else
                                        <div class="upload-placeholder" id="coverPlaceholder">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"
                                                fill="none" stroke="currentColor" stroke-width="2">
                                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                                <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                                <polyline points="21 15 16 10 5 21"></polyline>
                                            </svg>
                                            <span>Klik atau seret foto cover</span>
                                        </div>
                                    @endif
                                </div>
                                <input type="file" id="coverPhotoInput" name="cover_photo"
                                    accept="image/jpeg,image/png,image/jpg,image/gif" class="file-input-hidden">
                            </div>
                        </div>

                        <!-- Avatar Upload -->
                        <div class="photo-upload-section avatar-section">
                            <label class="upload-label">Foto Profil</label>
                            <div class="avatar-upload-area" id="avatarUploadArea">
                                <div class="avatar-preview" id="avatarPreview">
                                    @if($user['avatar'])
                                        <img src="{{ $user['avatar'] }}" alt="Avatar Preview" id="avatarPreviewImg">
                                    @else
                                        <div class="upload-placeholder avatar-placeholder" id="avatarPlaceholder">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"
                                                fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                                <circle cx="12" cy="7" r="4"></circle>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <input type="file" id="avatarInput" name="avatar"
                                    accept="image/jpeg,image/png,image/jpg,image/gif" class="file-input-hidden">
                                <button type="button" class="btn-change-avatar"
                                    onclick="document.getElementById('avatarInput').click()">Ubah Foto</button>
                            </div>
                        </div>

                        <!-- Form Fields -->
                        <div class="form-group">
                            <label for="editName">Nama</label>
                            <input type="text" id="editName" name="name" value="{{ $user['name'] }}" required>
                        </div>

                        <div class="form-group">
                            <label for="editUsername">Username</label>
                            <div class="input-prefix">
                                <span>@</span>
                                <input type="text" id="editUsername" name="username" value="{{ $user['username'] }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="editBio">Bio</label>
                            <textarea id="editBio" name="bio" rows="3" maxlength="500"
                                placeholder="Ceritakan tentang dirimu...">{{ $user['bio'] !== 'Belum ada bio' ? $user['bio'] : '' }}</textarea>
                            <span class="char-count"><span
                                    id="bioCharCount">{{ strlen($user['bio'] !== 'Belum ada bio' ? $user['bio'] : '') }}</span>/500</span>
                        </div>

                        <div class="form-group">
                            <label for="editWebsite">Website</label>
                            <input type="url" id="editWebsite" name="website" value="{{ $user['website'] }}"
                                placeholder="https://example.com">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn-cancel" onclick="closeEditModal()">Batal</button>
                        <button type="submit" class="btn-save">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
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

        /* Modal Overlay */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(4px);
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .modal-content {
            background: #fff;
            border-radius: 16px;
            width: 100%;
            max-width: 520px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
        }

        .edit-profile-modal .modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 24px;
            border-bottom: 1px solid #eee;
            position: sticky;
            top: 0;
            background: #fff;
            z-index: 10;
            border-radius: 16px 16px 0 0;
        }

        .edit-profile-modal .modal-header h2 {
            margin: 0;
            font-size: 20px;
            color: #333;
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 28px;
            cursor: pointer;
            color: #666;
            padding: 0;
            line-height: 1;
            transition: color 0.2s;
        }

        .modal-close:hover {
            color: #333;
        }

        .modal-body {
            padding: 24px;
        }

        /* Photo Upload Sections */
        .photo-upload-section {
            margin-bottom: 24px;
        }

        .upload-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #333;
            margin-bottom: 10px;
        }

        /* Cover Photo Upload */
        .cover-upload-area {
            position: relative;
            cursor: pointer;
        }

        .cover-preview {
            width: 100%;
            height: 150px;
            border-radius: 12px;
            background: linear-gradient(135deg, #f5f5f5, #e8e8e8);
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px dashed #ddd;
            transition: all 0.3s;
        }

        .cover-preview:hover {
            border-color: #6B7B4B;
            background: linear-gradient(135deg, #f0f4e8, #e8ede0);
        }

        .cover-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .upload-placeholder {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            color: #888;
        }

        .upload-placeholder svg {
            opacity: 0.6;
        }

        .upload-placeholder span {
            font-size: 13px;
        }

        /* Avatar Upload */
        .avatar-section {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .avatar-section .upload-label {
            text-align: center;
            width: 100%;
        }

        .avatar-upload-area {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 12px;
        }

        .avatar-preview {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: linear-gradient(135deg, #f5f5f5, #e8e8e8);
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 3px solid #6B7B4B;
            cursor: pointer;
            transition: all 0.3s;
        }

        .avatar-preview:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(107, 123, 75, 0.2);
        }

        .avatar-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .avatar-placeholder {
            border: none;
        }

        .avatar-placeholder svg {
            color: #6B7B4B;
        }

        .btn-change-avatar {
            background: transparent;
            border: 1px solid #6B7B4B;
            color: #6B7B4B;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-change-avatar:hover {
            background: #6B7B4B;
            color: white;
        }

        .file-input-hidden {
            display: none;
        }

        /* Form Fields */
        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #ddd;
            border-radius: 10px;
            font-size: 14px;
            transition: all 0.2s;
            background: #fafafa;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #6B7B4B;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(107, 123, 75, 0.1);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 80px;
        }

        .input-prefix {
            display: flex;
            align-items: center;
            border: 1px solid #ddd;
            border-radius: 10px;
            overflow: hidden;
            background: #fafafa;
            transition: all 0.2s;
        }

        .input-prefix:focus-within {
            border-color: #6B7B4B;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(107, 123, 75, 0.1);
        }

        .input-prefix span {
            padding: 12px 0 12px 16px;
            color: #888;
            font-size: 14px;
        }

        .input-prefix input {
            border: none;
            background: transparent;
            padding-left: 0;
        }

        .input-prefix input:focus {
            box-shadow: none;
        }

        .char-count {
            display: block;
            text-align: right;
            font-size: 12px;
            color: #888;
            margin-top: 4px;
        }

        /* Modal Footer */
        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            padding: 16px 24px;
            border-top: 1px solid #eee;
            background: #fafafa;
            border-radius: 0 0 16px 16px;
        }

        .btn-cancel {
            padding: 12px 24px;
            background: #f0f0f0;
            border: none;
            border-radius: 10px;
            color: #555;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-cancel:hover {
            background: #e0e0e0;
        }

        .btn-save {
            padding: 12px 24px;
            background: #6B7B4B;
            border: none;
            border-radius: 10px;
            color: white;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-save:hover {
            background: #5a6a3f;
        }

        .btn-save:disabled {
            background: #ccc;
            cursor: not-allowed;
        }

        /* Toast Notification */
        .toast {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%) translateY(100px);
            background: #333;
            color: white;
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 14px;
            opacity: 0;
            transition: all 0.3s;
            z-index: 2000;
        }

        .toast.show {
            transform: translateX(-50%) translateY(0);
            opacity: 1;
        }

        .toast.success {
            background: #4CAF50;
        }

        .toast.error {
            background: #f44336;
        }

        /* Responsive */
        @media (max-width: 600px) {
            .modal-content {
                max-height: 85vh;
            }

            .modal-body {
                padding: 16px;
            }

            .cover-preview {
                height: 120px;
            }

            .modal-footer {
                flex-direction: column;
            }

            .btn-cancel,
            .btn-save {
                width: 100%;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Toast notification
        function showToast(message, type = 'success') {
            let toast = document.getElementById('toast');
            if (!toast) {
                toast = document.createElement('div');
                toast.id = 'toast';
                toast.className = 'toast';
                document.body.appendChild(toast);
            }
            toast.textContent = message;
            toast.className = 'toast show ' + type;
            setTimeout(() => { toast.className = 'toast'; }, 3000);
        }

        // Open Edit Profile Modal
        function openEditModal() {
            const modal = document.getElementById('editProfileModal');
            if (modal) {
                modal.style.display = 'flex';
                // Add active class for visibility and opacity (required by global CSS)
                modal.classList.add('active');
                document.body.style.overflow = 'hidden';
            }
        }

        // Close Edit Profile Modal
        function closeEditModal() {
            const modal = document.getElementById('editProfileModal');
            if (modal) {
                modal.classList.remove('active');
                // Delay hiding to allow transition
                setTimeout(() => {
                    modal.style.display = 'none';
                }, 300);
                document.body.style.overflow = '';
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            // ===================================
            // Follow Button
            // ===================================
            const followBtn = document.getElementById('follow-btn');
            if (followBtn) {
                followBtn.addEventListener('click', function () {
                    const userId = this.dataset.userId;
                    fetch(`/user/${userId}/follow`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                        }
                    })
                        .then(r => r.json())
                        .then(data => {
                            if (data.success) {
                                this.textContent = data.following ? 'Mengikuti' : 'Ikuti';
                                this.classList.toggle('following', data.following);
                                const stats = document.querySelectorAll('.profile-stat');
                                if (stats[1]) {
                                    stats[1].querySelector('strong').textContent = data.followers_count;
                                }
                            }
                        });
                });
            }

            // ===================================
            // Edit Profile Modal Functionality
            // ===================================
            const editModal = document.getElementById('editProfileModal');

            if (editModal) {
                // Close modal when clicking outside
                editModal.addEventListener('click', function (e) {
                    if (e.target === editModal) {
                        closeEditModal();
                    }
                });

                // Close with Escape key
                document.addEventListener('keydown', function (e) {
                    if (e.key === 'Escape' && editModal.style.display === 'flex') {
                        closeEditModal();
                    }
                });

                // ===================================
                // Cover Photo Preview
                // ===================================
                const coverUploadArea = document.getElementById('coverUploadArea');
                const coverInput = document.getElementById('coverPhotoInput');
                const coverPreview = document.getElementById('coverPreview');

                if (coverUploadArea && coverInput) {
                    coverUploadArea.addEventListener('click', () => coverInput.click());

                    coverInput.addEventListener('change', function () {
                        if (this.files && this.files[0]) {
                            const file = this.files[0];

                            // Validate file size (max 4MB)
                            if (file.size > 4 * 1024 * 1024) {
                                showToast('Ukuran file maksimal 4MB', 'error');
                                this.value = '';
                                return;
                            }

                            const reader = new FileReader();
                            reader.onload = function (e) {
                                coverPreview.innerHTML = `<img src="${e.target.result}" alt="Cover Preview" id="coverPreviewImg">`;
                            };
                            reader.readAsDataURL(file);
                        }
                    });

                    // Drag and drop for cover
                    coverUploadArea.addEventListener('dragover', (e) => {
                        e.preventDefault();
                        coverPreview.style.borderColor = '#6B7B4B';
                    });

                    coverUploadArea.addEventListener('dragleave', () => {
                        coverPreview.style.borderColor = '#ddd';
                    });

                    coverUploadArea.addEventListener('drop', (e) => {
                        e.preventDefault();
                        coverPreview.style.borderColor = '#ddd';
                        const files = e.dataTransfer.files;
                        if (files.length > 0 && files[0].type.startsWith('image/')) {
                            coverInput.files = files;
                            coverInput.dispatchEvent(new Event('change'));
                        }
                    });
                }

                // ===================================
                // Avatar Preview
                // ===================================
                const avatarPreview = document.getElementById('avatarPreview');
                const avatarInput = document.getElementById('avatarInput');

                if (avatarPreview && avatarInput) {
                    avatarPreview.addEventListener('click', () => avatarInput.click());

                    avatarInput.addEventListener('change', function () {
                        if (this.files && this.files[0]) {
                            const file = this.files[0];

                            // Validate file size (max 2MB)
                            if (file.size > 2 * 1024 * 1024) {
                                showToast('Ukuran file maksimal 2MB', 'error');
                                this.value = '';
                                return;
                            }

                            const reader = new FileReader();
                            reader.onload = function (e) {
                                avatarPreview.innerHTML = `<img src="${e.target.result}" alt="Avatar Preview" id="avatarPreviewImg">`;
                            };
                            reader.readAsDataURL(file);
                        }
                    });
                }

                // ===================================
                // Bio Character Counter
                // ===================================
                const bioTextarea = document.getElementById('editBio');
                const bioCharCount = document.getElementById('bioCharCount');

                if (bioTextarea && bioCharCount) {
                    bioTextarea.addEventListener('input', function () {
                        bioCharCount.textContent = this.value.length;
                    });
                }

                // ===================================
                // Form Submission
                // ===================================
                const editForm = document.getElementById('editProfileForm');

                if (editForm) {
                    editForm.addEventListener('submit', function (e) {
                        e.preventDefault();

                        const submitBtn = editForm.querySelector('.btn-save');
                        const originalText = submitBtn.textContent;
                        submitBtn.textContent = 'Menyimpan...';
                        submitBtn.disabled = true;

                        const formData = new FormData(editForm);

                        fetch('/profil', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json',
                                'X-HTTP-Method-Override': 'PUT'
                            },
                            body: formData
                        })
                            .then(response => {
                                if (!response.ok) {
                                    return response.json().then(err => { throw err; });
                                }
                                return response.json();
                            })
                            .then(data => {
                                if (data.success) {
                                    showToast(data.message || 'Profil berhasil diperbarui');
                                    setTimeout(() => {
                                        window.location.reload();
                                    }, 1000);
                                } else {
                                    showToast(data.message || 'Gagal memperbarui profil', 'error');
                                    submitBtn.textContent = originalText;
                                    submitBtn.disabled = false;
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                let errorMessage = 'Terjadi kesalahan';
                                if (error.errors) {
                                    const firstError = Object.values(error.errors)[0];
                                    errorMessage = Array.isArray(firstError) ? firstError[0] : firstError;
                                } else if (error.message) {
                                    errorMessage = error.message;
                                }
                                showToast(errorMessage, 'error');
                                submitBtn.textContent = originalText;
                                submitBtn.disabled = false;
                            });
                    });
                }
            }
        });
    </script>
@endpush