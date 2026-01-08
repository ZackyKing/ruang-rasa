// RuangRasa - Interaction JavaScript
// Handles likes, comments, reshares, and save functionality

document.addEventListener('DOMContentLoaded', function () {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    if (!csrfToken) {
        console.error('CSRF token not found');
        return;
    }

    // ===================================
    // Toast Notification Helper
    // ===================================
    function showToast(message, type = 'success') {
        const toast = document.getElementById('toast');
        if (toast) {
            toast.textContent = message;
            toast.className = 'toast show ' + type;
            setTimeout(() => { toast.className = 'toast'; }, 3000);
        }
    }

    // ===================================
    // Like/Resonansi Button
    // ===================================
    document.querySelectorAll('.like-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const postId = this.dataset.postId;
            fetch(`/post/${postId}/like`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
            })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        this.classList.toggle('active', data.liked);
                        const count = this.querySelector('.likes-count');
                        if (count) count.textContent = data.likes_count;
                    }
                })
                .catch(err => console.error('Like error:', err));
        });
    });

    // ===================================
    // Comment Toggle
    // ===================================
    document.querySelectorAll('.comment-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const postId = this.dataset.postId;
            const commentsSection = document.getElementById(`comments-${postId}`);

            if (!commentsSection) return;

            if (commentsSection.style.display === 'none') {
                commentsSection.style.display = 'block';
                // Load comments
                fetch(`/post/${postId}/comments`, { headers: { 'Accept': 'application/json' } })
                    .then(r => r.json())
                    .then(data => {
                        const list = commentsSection.querySelector('.comments-list');
                        if (list && data.comments) {
                            list.innerHTML = data.comments.map(c => `
                                <div class="comment-item">
                                    <strong>${c.user.name}</strong>
                                    <p>${c.content}</p>
                                </div>
                            `).join('');
                        }
                    })
                    .catch(err => console.error('Comments load error:', err));
            } else {
                commentsSection.style.display = 'none';
            }
        });
    });

    // ===================================
    // Comment Submit
    // ===================================
    document.querySelectorAll('.comment-form').forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            const postId = this.dataset.postId;
            const input = this.querySelector('.comment-input');
            const content = input.value.trim();

            if (!content) return;

            fetch(`/post/${postId}/comment`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ content })
            })
                .then(r => r.json())
                .then(data => {
                    if (data.success && data.comment) {
                        const list = document.querySelector(`#comments-${postId} .comments-list`);
                        if (list) {
                            list.innerHTML += `
                                <div class="comment-item">
                                    <strong>${data.comment.user.name}</strong>
                                    <p>${data.comment.content}</p>
                                </div>
                            `;
                        }
                        input.value = '';
                        const countBtn = document.querySelector(`.comment-btn[data-post-id="${postId}"] .comments-count`);
                        if (countBtn) countBtn.textContent = data.comments_count;
                        showToast('Tanggapan berhasil ditambahkan');
                    }
                })
                .catch(err => {
                    console.error('Comment submit error:', err);
                    showToast('Gagal mengirim tanggapan', 'error');
                });
        });
    });

    // ===================================
    // Reshare Button
    // ===================================
    document.querySelectorAll('.reshare-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const postId = this.dataset.postId;
            fetch(`/post/${postId}/reshare`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
            })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        this.classList.toggle('active', data.reshared);
                        const count = this.querySelector('.reshares-count');
                        if (count) count.textContent = data.reshares_count;
                        showToast(data.message || (data.reshared ? 'Dibagikan ke ruang Anda' : 'Batal bagikan'));
                    }
                })
                .catch(err => {
                    console.error('Reshare error:', err);
                    showToast('Gagal membagikan', 'error');
                });
        });
    });

    // ===================================
    // Save Button
    // ===================================
    document.querySelectorAll('.save-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const postId = this.dataset.postId;
            fetch(`/post/${postId}/save`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
            })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        this.classList.toggle('active', data.saved);
                        const svg = this.querySelector('svg');
                        if (svg) {
                            svg.setAttribute('fill', data.saved ? 'currentColor' : 'none');
                        }
                        showToast(data.saved ? 'Tersimpan' : 'Batal simpan');
                    }
                })
                .catch(err => {
                    console.error('Save error:', err);
                    showToast('Gagal menyimpan', 'error');
                });
        });
    });

    // ===================================
    // Follow User Button (in post cards)
    // ===================================
    document.querySelectorAll('.follow-user-btn').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();

            const userId = this.dataset.userId;

            fetch(`/user/${userId}/follow`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        // Update all buttons for this user
                        document.querySelectorAll(`.follow-user-btn[data-user-id="${userId}"]`).forEach(b => {
                            b.classList.toggle('following', data.following);
                            b.textContent = data.following ? 'Mengikuti' : 'Ikuti';
                        });
                        showToast(data.message || (data.following ? 'Mengikuti' : 'Berhenti mengikuti'));
                    }
                })
                .catch(err => {
                    console.error('Follow error:', err);
                    showToast('Gagal mengikuti', 'error');
                });
        });
    });
});
