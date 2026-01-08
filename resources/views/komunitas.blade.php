@extends('layouts.app')

@section('title', 'Komunitas - RuangRasa')

@section('content')
    <div class="main-content">
        <!-- Page Header -->
        <div class="section-header">
            <span class="section-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="3"></circle>
                    <circle cx="19" cy="5" r="2"></circle>
                    <circle cx="5" cy="5" r="2"></circle>
                    <circle cx="19" cy="19" r="2"></circle>
                    <circle cx="5" cy="19" r="2"></circle>
                </svg>
            </span>
            <h2>Pilih ruang untuk dijelajahi</h2>
        </div>

        <!-- Category Grid -->
        <div class="community-card">
            <div class="category-grid">
                @foreach($categories as $category)
                    <a href="{{ route('ruang.show', $category['slug']) }}"
                        class="category-btn {{ $category['highlight'] ? 'highlighted' : '' }}">
                        {{ $category['name'] }}
                    </a>
                @endforeach
            </div>

            <div class="community-actions">
                <button class="btn-add-category" id="openCreateRoomModal">Tambahkan Ruang Lainnya</button>
            </div>
        </div>
    </div>

    <!-- Create Room Modal -->
    <div id="createRoomModal" class="modal">
        <div class="modal-overlay" id="modalOverlay"></div>
        <div class="modal-content">
            <div class="modal-header">
                <h3>Buat Ruang Baru</h3>
                <button class="modal-close" id="closeModal">&times;</button>
            </div>
            <form id="createRoomForm">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="room_name">Nama Ruang</label>
                        <input type="text" id="room_name" name="name" placeholder="Contoh: Teknologi, Gaming, Olahraga"
                            class="form-input" required maxlength="50">
                        <small class="form-hint">Nama ruang akan otomatis ditambah prefix "Ruang"</small>
                        <div class="error-message" id="nameError"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-secondary" id="cancelBtn">Batal</button>
                    <button type="submit" class="btn-primary" id="submitBtn">Buat Ruang</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal.active {
            display: flex;
        }

        .modal-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
        }

        .modal-content {
            position: relative;
            background: white;
            border-radius: var(--radius-lg);
            max-width: 500px;
            width: 90%;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            animation: modalSlideIn 0.3s ease-out;
        }

        @keyframes modalSlideIn {
            from {
                opacity: 0;
                transform: translateY(-20px) scale(0.95);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 24px;
            border-bottom: 1px solid var(--border-color);
        }

        .modal-header h3 {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0;
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--text-medium);
            cursor: pointer;
            padding: 0;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: var(--radius-sm);
            transition: all 0.2s ease;
        }

        .modal-close:hover {
            background: var(--light-sage);
            color: var(--text-dark);
        }

        .modal-body {
            padding: 24px;
        }

        .form-group {
            margin-bottom: 0;
        }

        .form-group label {
            display: block;
            font-weight: 500;
            color: var(--text-dark);
            margin-bottom: 8px;
        }

        .form-input {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #E5E7EB;
            border-radius: var(--radius-md);
            font-size: 0.95rem;
            font-family: inherit;
            transition: all 0.3s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: #3B82F6;
            border-top-width: 3px;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.1);
        }

        .form-hint {
            display: block;
            margin-top: 6px;
            font-size: 0.85rem;
            color: var(--text-medium);
        }

        .error-message {
            color: #EF4444;
            font-size: 0.85rem;
            margin-top: 6px;
            display: none;
        }

        .error-message.visible {
            display: block;
        }

        .modal-footer {
            padding: 16px 24px;
            border-top: 1px solid var(--border-color);
            display: flex;
            gap: 12px;
            justify-content: flex-end;
        }

        .btn-secondary {
            padding: 10px 20px;
            background: #F3F4F6;
            color: var(--text-dark);
            border: none;
            border-radius: var(--radius-md);
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-secondary:hover {
            background: #E5E7EB;
        }

        .btn-primary {
            padding: 10px 20px;
            background: var(--primary-green);
            color: white;
            border: none;
            border-radius: var(--radius-md);
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-primary:hover {
            background: var(--primary-green-hover);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(107, 123, 75, 0.3);
        }

        .btn-primary:disabled {
            background: #D1D5DB;
            cursor: not-allowed;
            transform: none;
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Modal elements
        const modal = document.getElementById('createRoomModal');
        const openBtn = document.getElementById('openCreateRoomModal');
        const closeBtn = document.getElementById('closeModal');
        const cancelBtn = document.getElementById('cancelBtn');
        const overlay = document.getElementById('modalOverlay');
        const form = document.getElementById('createRoomForm');
        const submitBtn = document.getElementById('submitBtn');
        const nameInput = document.getElementById('room_name');
        const nameError = document.getElementById('nameError');

        // Open modal
        openBtn?.addEventListener('click', () => {
            modal.classList.add('active');
            nameInput.focus();
        });

        // Close modal
        function closeModal() {
            modal.classList.remove('active');
            form.reset();
            nameError.classList.remove('visible');
            nameError.textContent = '';
        }

        closeBtn?.addEventListener('click', closeModal);
        cancelBtn?.addEventListener('click', closeModal);
        overlay?.addEventListener('click', closeModal);

        // Handle form submission
        form?.addEventListener('submit', async (e) => {
            e.preventDefault();

            const formData = new FormData(form);
            submitBtn.disabled = true;
            submitBtn.textContent = 'Membuat...';
            nameError.classList.remove('visible');

            try {
                const response = await fetch('{{ route("ruang.store") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (data.success) {
                    // Show success message
                    alert('✅ ' + data.message);

                    // Redirect to new room
                    window.location.href = data.redirect;
                } else {
                    // Show error
                    nameError.textContent = data.message || 'Terjadi kesalahan';
                    nameError.classList.add('visible');
                }
            } catch (error) {
                console.error('Error:', error);
                nameError.textContent = 'Terjadi kesalahan saat membuat ruang';
                nameError.classList.add('visible');
            } finally {
                submitBtn.disabled = false;
                submitBtn.textContent = 'Buat Ruang';
            }
        });

        // Close modal on Escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && modal.classList.contains('active')) {
                closeModal();
            }
        });
    </script>
@endpush