@extends('layouts.app')

@section('title', 'Pertanyaan - RuangRasa')

@section('content')
    <div class="main-layout">
        <!-- Sidebar Left Placeholder -->
        <div class="sidebar-left"></div>

        <!-- Main Content -->
        <div class="main-feed">
            {{-- Create Question Card --}}
            <div class="create-post-card">
                <form id="create-question-form" method="POST" action="{{ route('pertanyaan.store') }}">
                    @csrf
                    <div class="create-post-header">
                        <div class="create-post-avatar">
                            @if(auth()->user()->avatar)
                                <img src="{{ auth()->user()->avatar }}" alt="{{ auth()->user()->name }}">
                            @else
                                <div class="avatar-placeholder">{{ substr(auth()->user()->name, 0, 1) }}</div>
                            @endif
                        </div>
                        <textarea name="content" class="create-post-textarea" id="question-content"
                            placeholder="Apa yang sedang ada di pikiranmu? Bagikan disini!" required></textarea>
                    </div>
                    <div class="create-post-footer">
                        <label class="anonymous-label">
                            <input type="checkbox" name="is_anonymous" value="1">
                            <span>Anonim</span>
                        </label>
                        <button type="submit" class="create-post-submit">Kirim Pertanyaan</button>
                    </div>
                </form>
            </div>

            {{-- Section Header --}}
            <div class="section-header-questions">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
                    <line x1="12" y1="17" x2="12.01" y2="17"></line>
                </svg>
                <h2>Beberapa pertanyaan yang bisa kamu jawab dengan sudut pandangmu</h2>
            </div>

            {{-- Questions List using Post Card --}}
            @if(isset($questions) && $questions->count() > 0)
                @foreach($questions as $question)
                    <x-post-card :post="$question" :showRepostIndicator="false" />
                @endforeach
            @else
                <div class="empty-state">
                    <div class="empty-icon">❓</div>
                    <h3>Belum Ada Pertanyaan</h3>
                    <p>Jadilah yang pertama bertanya di RuangRasa!</p>
                </div>
            @endif
        </div>

        <!-- Sidebar Right Placeholder -->
        <div class="sidebar-right"></div>
    </div>
@endsection

@push('styles')
<style>
    /* Questions Page Specific Styles */
    .section-header-questions {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 16px;
        background: var(--light-sage);
        border-radius: var(--radius-md);
        margin: var(--spacing-lg) 0;
        border-left: 4px solid var(--primary-green);
    }

    .section-header-questions svg {
        flex-shrink: 0;
        color: var(--primary-green);
    }

    .section-header-questions h2 {
        font-size: 1rem;
        font-weight: 500;
        color: var(--text-dark);
        margin: 0;
        line-height: 1.5;
    }
</style>
@endpush

@push('scripts')
<script>
    // Question form submission
    document.getElementById('create-question-form')?.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const form = this;
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.textContent;
        
        submitBtn.disabled = true;
        submitBtn.textContent = 'Mengirim...';
        
        try {
            const formData = new FormData(form);
            
            const response = await fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });
            
            const data = await response.json();
            
            if (data.success) {
                // Clear form
                form.reset();
                // Reload page to show new question
                window.location.reload();
            } else {
                alert(data.message || 'Gagal mengirim pertanyaan');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat mengirim pertanyaan');
        } finally {
            submitBtn.disabled = false;
            submitBtn.textContent = originalText;
        }
    });
</script>
@endpush
