@extends('layouts.app')

@section('title', 'Pilih Minat - RuangRasa')

@section('content')
    <div class="onboarding-background">
        <div class="onboarding-watermark">
            @for($i = 0; $i < 20; $i++)
                <div class="watermark-row">
                    @for($j = 0; $j < 10; $j++)
                        <span>RuangRasa</span>
                    @endfor
                </div>
            @endfor
        </div>

        <div class="onboarding-modal">
            <button class="modal-close">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>

            <h2 class="onboarding-title">Apa yang anda minati?</h2>

            <form action="{{ route('minat.save') }}" method="POST" id="interest-form">
                @csrf
                <div class="interests-grid">
                    @foreach($topics as $topic)
                        <label class="interest-item">
                            <input type="checkbox" name="topics[]" value="{{ $topic['slug'] }}" class="interest-checkbox"
                                onchange="updateSubmitButton()">
                            <span
                                class="interest-btn {{ isset($topic['highlight']) && $topic['highlight'] ? 'highlight-green' : '' }}">
                                {{ $topic['name'] }}
                            </span>
                        </label>
                    @endforeach
                </div>

                <div class="onboarding-footer">
                    <button type="submit" class="btn-primary btn-block" id="btn-continue" disabled>
                        Ikuti 5 topik yang anda minati untuk melanjutkannya
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function updateSubmitButton() {
            const checkboxes = document.querySelectorAll('.interest-checkbox:checked');
            const btn = document.getElementById('btn-continue');
            const count = checkboxes.length;

            if (count >= 5) {
                btn.disabled = false;
                btn.classList.remove('btn-disabled');
                btn.innerHTML = 'Lanjutkan';
            } else {
                btn.disabled = true;
                btn.classList.add('btn-disabled');
                btn.innerHTML = 'Ikuti ' + (5 - count) + ' topik lagi untuk melanjutkannya';
            }
        }
    </script>
@endsection