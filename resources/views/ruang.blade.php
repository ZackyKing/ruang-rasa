@extends('layouts.app')

@section('title', $category->name . ' - RuangRasa')

@section('content')
    <div class="main-content">
        <!-- Ruang Header -->
        <div class="section-header" style="justify-content: space-between;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <span class="section-icon">{{ $category->icon }}</span>
                <h2>{{ $category->name }}</h2>
            </div>

            @auth
                <button class="btn-follow-room {{ $category->is_followed ? 'following' : '' }}"
                    onclick="toggleRoomFollow(this, {{ $category->id }})"
                    style="border: 1px solid #6B7B4B; background: {{ $category->is_followed ? '#6B7B4B' : 'transparent' }}; color: {{ $category->is_followed ? 'white' : '#6B7B4B' }}; padding: 6px 16px; border-radius: 20px; font-size: 14px; cursor: pointer;">
                    {{ $category->is_followed ? 'Mengikuti' : 'Ikuti Ruang' }}
                </button>
            @endauth
        </div>

        <!-- Create Post Section -->
        <div class="create-post-card">
            <form action="{{ route('post.store') }}" method="POST">
                @csrf
                <input type="hidden" name="category_id" value="{{ $category->id }}">
                <div class="create-post-input-row">
                    <div class="create-post-avatar">
                        @if(auth()->user() && auth()->user()->avatar)
                            <img src="{{ auth()->user()->avatar }}" alt="{{ auth()->user()->name }}"
                                style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                        @else
                            <div class="avatar-placeholder">{{ substr(auth()->user()->name ?? 'A', 0, 1) }}</div>
                        @endif
                    </div>
                    <textarea name="content" class="create-post-input"
                        placeholder="Bagikan rasa di {{ $category->name }}..." required></textarea>
                </div>
                <div class="create-post-actions">
                    <label class="anonymous-label">
                        <input type="checkbox" name="is_anonymous" value="1"> Anonim
                    </label>
                    <button type="submit" class="create-post-submit">Bagikan Rasa</button>
                </div>
            </form>
        </div>

        <!-- Posts Feed -->
        @foreach($posts as $post)
            <x-post-card :post="$post" />
        @endforeach

        @if($posts->isEmpty())
            <div class="empty-state" style="text-align: center; padding: 40px; color: #666;">
                <p>Belum ada postingan di ruang ini. Mulailah berbagi!</p>
            </div>
        @endif
    </div>

    <!-- Script needed for follow button -->
    @section('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

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
                                btn.textContent = data.following ? 'Mengikuti' : 'Ikuti Ruang';
                                btn.classList.toggle('following', data.following);

                                // Update styles manually since we used inline styles for now
                                if (data.following) {
                                    btn.style.background = '#6B7B4B';
                                    btn.style.color = 'white';
                                } else {
                                    btn.style.background = 'transparent';
                                    btn.style.color = '#6B7B4B';
                                }
                            }
                        });
                };
            });
        </script>
    @endsection
@endsection