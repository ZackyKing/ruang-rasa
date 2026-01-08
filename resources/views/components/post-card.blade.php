@props(['post', 'showRepostIndicator' => true])

<div class="post-card {{ $post->category->slug == 'pertanyaan' ? 'post-type-question' : '' }}"
    data-post-id="{{ $post->id }}">

    {{-- Repost Indicator --}}
    @if($showRepostIndicator && $post->isResharedBy(auth()->id()))
        <div class="repost-indicator">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2">
                <polyline points="17 1 21 5 17 9"></polyline>
                <path d="M3 11V9a4 4 0 0 1 4-4h14"></path>
                <polyline points="7 23 3 19 7 15"></polyline>
                <path d="M21 13v2a4 4 0 0 1-4 4H3"></path>
            </svg>
            Anda membagikan ulang ini
        </div>
    @endif

    {{-- Post Header --}}
    <div class="post-header">
        <div class="post-author">
            <div class="post-avatar">
                @if(!$post->is_anonymous && $post->user->avatar)
                    <img src="{{ $post->user->avatar }}" alt="{{ $post->user->name }}">
                @else
                    <div class="avatar-placeholder {{ $post->is_anonymous ? 'anon' : '' }}">
                        {{ $post->is_anonymous ? '?' : substr($post->user->name, 0, 1) }}
                    </div>
                @endif
            </div>
            <div class="post-author-info">
                @if($post->is_anonymous)
                    <span class="post-author-name">Seseorang di RuangRasa</span>
                @else
                    <div class="post-author-row">
                        <a href="{{ route('profil.show', $post->user->username ?? $post->user_id) }}"
                            class="post-author-name">{{ $post->user->name }}</a>
                        @if(auth()->id() !== $post->user_id)
                            <button
                                class="btn-follow-small follow-user-btn {{ $post->user->isFollowedBy(auth()->id()) ? 'following' : '' }}"
                                data-user-id="{{ $post->user_id }}">
                                {{ $post->user->isFollowedBy(auth()->id()) ? 'Mengikuti' : 'Ikuti' }}
                            </button>
                        @endif
                    </div>
                @endif
                <span class="post-meta">
                    {{ $post->created_at->diffForHumans() }}
                    <span class="dot">•</span>
                    <span class="post-room-badge">{{ $post->category->icon }} {{ $post->category->name }}</span>
                </span>
            </div>
        </div>

        <button class="post-more-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="1"></circle>
                <circle cx="19" cy="12" r="1"></circle>
                <circle cx="5" cy="12" r="1"></circle>
            </svg>
        </button>
    </div>

    {{-- Post Title (if exists) --}}
    @if(!empty($post->title))
        <h4 class="post-title">{{ $post->title }}</h4>
    @endif

    {{-- Post Content --}}
    <div class="post-content">
        {!! nl2br(e($post->content)) !!}
    </div>

    {{-- Post Actions --}}
    <div class="post-actions">
        {{-- Like Button --}}
        <button class="post-action-btn like-btn {{ $post->isLikedBy(auth()->id()) ? 'active' : '' }}"
            data-post-id="{{ $post->id }}" title="Like">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2">
                <path
                    d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z">
                </path>
            </svg>
            <span class="action-count likes-count">{{ $post->likes->count() }}</span>
        </button>

        {{-- Comment Button --}}
        <button class="post-action-btn comment-btn" data-post-id="{{ $post->id }}" title="Tanggapi">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2">
                <path
                    d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z">
                </path>
            </svg>
            <span class="action-count comments-count">{{ $post->comments->count() }}</span>
        </button>

        {{-- Reshare Button --}}
        <button class="post-action-btn reshare-btn {{ $post->isResharedBy(auth()->id()) ? 'active' : '' }}"
            data-post-id="{{ $post->id }}" title="Bagikan ke Ruangmu">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2">
                <polyline points="17 1 21 5 17 9"></polyline>
                <path d="M3 11V9a4 4 0 0 1 4-4h14"></path>
                <polyline points="7 23 3 19 7 15"></polyline>
                <path d="M21 13v2a4 4 0 0 1-4 4H3"></path>
            </svg>
            <span class="action-count reshares-count">{{ $post->reshares->count() }}</span>
        </button>

        {{-- Save Button --}}
        <button class="post-action-btn save-btn {{ $post->isSavedBy(auth()->id()) ? 'active' : '' }}"
            data-post-id="{{ $post->id }}" title="Simpan">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                fill="{{ $post->isSavedBy(auth()->id()) ? 'currentColor' : 'none' }}" stroke="currentColor"
                stroke-width="2">
                <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path>
            </svg>
        </button>
    </div>

    {{-- Comments Section --}}
    <div class="comments-section" id="comments-{{ $post->id }}" style="display: none;">
        <div class="comments-list"></div>
        <form class="comment-form" data-post-id="{{ $post->id }}">
            @csrf
            <input type="text" class="comment-input" placeholder="Tulis tanggapan yang empatik..." required>
            <button type="submit" class="comment-submit">Kirim</button>
        </form>
    </div>
</div>