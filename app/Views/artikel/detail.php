<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<section class="py-3 bg-light">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="<?= base_url('/') ?>" class="text-success text-decoration-none">Beranda</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('artikel') ?>" class="text-success text-decoration-none">Artikel</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= esc($artikel['judul']) ?></li>
            </ol>
        </nav>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <article class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex flex-wrap align-items-center mb-3">
                            <span class="badge bg-success me-3 mb-2"><?= esc($artikel['kategori_nama']) ?></span>
                            <small class="text-muted me-3 mb-2">
                                <i class="fas fa-calendar-alt me-1"></i>
                                <?= date('d F Y', strtotime($artikel['tanggal'])) ?>
                            </small>
                            <small class="text-muted me-3 mb-2">
                                <i class="fas fa-user me-1"></i>
                                <?php if (!empty($artikel['penulis_nama'])): ?>
                                    <a href="<?= base_url('penyuluh/detail/' . $artikel['penulis_id']) ?>" 
                                    class="text-success text-decoration-none">
                                        <?= esc($artikel['penulis_nama']) ?>
                                    </a>
                                <?php else: ?>
                                    Penulis Tidak Diketahui
                                <?php endif; ?>
                            </small>
                            <small class="text-muted mb-2">
                                <i class="fas fa-eye me-1"></i>
                                <?= number_format($artikel['views']) ?> views
                            </small>
                        </div>
                        
                        <h1 class="fw-bold text-dark mb-4"><?= esc($artikel['judul']) ?></h1>
                        
                        <div class="text-center mb-4">
                            <img src="<?= base_url('uploads/artikel/' . ($artikel['gambar'] ?? 'default-artikel.jpg')) ?>" 
                                 alt="<?= esc($artikel['judul']) ?>" 
                                 class="img-fluid rounded shadow-sm" 
                                 style="max-height: 400px; width: 100%; object-fit: cover;">
                        </div>
                        
                        <div class="alert alert-success bg-light border-success" role="alert">
                            <h6 class="fw-bold text-success mb-2">
                                <i class="fas fa-info-circle me-2"></i>Ringkasan
                            </h6>
                            <p class="mb-0"><?= esc($artikel['ringkasan']) ?></p>
                        </div>
                        
                        <div class="artikel-content">
                            <?= $artikel['konten'] ?>
                        </div>
                        
                        <div class="border-top pt-4 mt-4">
                            <h6 class="fw-bold mb-3">Bagikan Artikel:</h6>
                            <div class="d-flex flex-wrap gap-2">
                                <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode(current_url()) ?>" 
                                   target="_blank" class="btn btn-outline-primary btn-sm">
                                    <i class="fab fa-facebook-f me-1"></i>Facebook
                                </a>
                                <a href="https://twitter.com/intent/tweet?url=<?= urlencode(current_url()) ?>&text=<?= urlencode($artikel['judul']) ?>" 
                                   target="_blank" class="btn btn-outline-info btn-sm">
                                    <i class="fab fa-twitter me-1"></i>Twitter
                                </a>
                                <a href="https://wa.me/?text=<?= urlencode($artikel['judul'] . ' - ' . current_url()) ?>" 
                                   target="_blank" class="btn btn-outline-success btn-sm">
                                    <i class="fab fa-whatsapp me-1"></i>WhatsApp
                                </a>
                                <button class="btn btn-outline-secondary btn-sm" onclick="copyToClipboard('<?= current_url() ?>')">
                                    <i class="fas fa-link me-1"></i>Salin Link
                                </button>
                            </div>
                        </div>
                    </div>
                </article>
            </div>

            <div class="col-lg-4">
                <?php if (!empty($artikel_terkait)): ?>
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-success text-white">
                        <h6 class="mb-0 fw-bold">
                            <i class="fas fa-newspaper me-2"></i>Artikel Terkait
                        </h6>
                    </div>
                    <div class="card-body p-0">
                        <?php foreach ($artikel_terkait as $index => $terkait): ?>
                        <div class="p-3 <?= $index < count($artikel_terkait) - 1 ? 'border-bottom' : '' ?>">
                            <div class="d-flex align-items-start">
                                <div class="flex-shrink-0 me-3">
                                    <img src="<?= base_url('uploads/artikel/' . ($terkait['gambar'] ?? 'default-artikel.jpg')) ?>"  
                                        alt="<?= esc($terkait['judul']) ?>" class="rounded" 
                                        style="width: 60px; height: 60px; object-fit: cover;">
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">
                                        <a href="<?= base_url('artikel/' . $terkait['slug']) ?>" 
                                        class="text-decoration-none text-dark hover-text-success">
                                            <?= esc(substr($terkait['judul'], 0, 60)) ?><?= strlen($terkait['judul']) > 60 ? '...' : '' ?>
                                        </a>
                                    </h6>
                                    <small class="text-muted">
                                        <i class="fas fa-calendar-alt me-1"></i>
                                        <?= date('d M Y', strtotime($terkait['tanggal'])) ?>
                                    </small>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <i class="fas fa-arrow-left fa-2x text-success mb-3"></i>
                        <h6 class="fw-bold">Jelajahi Artikel Lainnya</h6>
                        <p class="text-muted mb-3">Temukan lebih banyak tips dan informasi berguna</p>
                        <a href="<?= base_url('artikel') ?>" class="btn btn-success">
                            <i class="fas fa-list me-2"></i>Semua Artikel
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-gradient text-white" style="background: linear-gradient(135deg, #28a745, #20c997);">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-edit me-2"></i>
                            <h5 class="mb-0 fw-bold">Tinggalkan Komentar</h5>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <?php if (session()->getFlashdata('success')): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i>
                                <?= session()->getFlashdata('success') ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>
                        
                        <form id="commentForm" action="<?= base_url('artikel/post-komentar') ?>" method="post" class="needs-validation" novalidate>
                            <?= csrf_field() ?>
                            <input type="hidden" name="artikel_id" value="<?= $artikel['id'] ?>">
                            <input type="hidden" id="parent_id" name="parent_id" value="">
                            
                            <div id="replyInfo" class="alert alert-info" style="display: none;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span><i class="fas fa-reply me-2"></i>Membalas komentar dari <strong id="replyToName"></strong></span>
                                    <button type="button" class="btn-close" onclick="cancelReply()"></button>
                                </div>
                            </div>
                            
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control form-control-lg" id="nama" name="nama" 
                                            placeholder="Nama Anda" required value="<?= old('nama') ?>">
                                        <label for="nama"><i class="fas fa-user me-2"></i>Nama Lengkap *</label>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="email" class="form-control form-control-lg" id="email" name="email" 
                                            placeholder="Email Anda" value="<?= old('email') ?>">
                                        <label for="email"><i class="fas fa-envelope me-2"></i>Email</label>
                                    </div>
                                </div>
                                
                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea class="form-control form-control-lg" id="komentar" name="komentar" 
                                                placeholder="Tulis komentar Anda..." style="height: 150px" required><?= old('komentar') ?></textarea>
                                        <label for="komentar"><i class="fas fa-comment-dots me-2"></i>Komentar *</label>
                                    </div>
                                </div>
                                
                                <div class="col-12">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">
                                            <span class="text-danger">*</span> Wajib diisi
                                        </small>
                                        <button type="submit" class="btn btn-success btn-lg px-5">
                                            <i class="fas fa-paper-plane me-2"></i>
                                            <span id="submitText">Kirim Komentar</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Daftar Komentar -->
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-comments text-success me-2"></i>
                                <h5 class="mb-0 fw-bold text-dark">Komentar</h5>
                               <span class="badge bg-success ms-2"><?= $total_komentar ?></span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-body p-0">
                        <?php if (empty($komentar)): ?>
                            <div class="text-center py-5">
                                <i class="fas fa-comment-slash fa-3x text-muted mb-3"></i>
                                <h6 class="text-muted mb-2">Belum Ada Komentar</h6>
                                <p class="text-muted mb-0">Jadilah yang pertama memberikan komentar pada artikel ini!</p>
                            </div>
                        <?php else: ?>
                            <div class="comment-list">
                                <?php foreach ($komentar as $index => $k): ?>
                                    <!-- Komentar Utama -->
                                    <div class="comment-item p-4 <?= $index < count($komentar) - 1 ? 'border-bottom' : '' ?>">
                                        <div class="d-flex align-items-start">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="comment-avatar bg-gradient text-white d-flex align-items-center justify-content-center" 
                                                    style="background: linear-gradient(135deg, #28a745, #20c997); width: 60px; height: 60px; border-radius: 50%; font-size: 1.5rem; font-weight: bold;">
                                                    <?= strtoupper(substr($k['nama'], 0, 1)) ?>
                                                </div>
                                            </div>
                                            
                                            <div class="flex-grow-1">
                                                <div class="comment-header mb-2">
                                                    <h6 class="comment-author mb-1 fw-bold text-dark">
                                                        <?= esc($k['nama']) ?>
                                                    </h6>
                                                    <div class="comment-meta d-flex align-items-center text-muted">
                                                        <i class="fas fa-clock me-1"></i>
                                                        <small><?= date('d F Y, H:i', strtotime($k['tanggal'])) ?> WIB</small>
                                                    </div>
                                                </div>
                                                
                                                <div class="comment-content">
                                                    <p class="mb-0 text-dark" style="line-height: 1.6;">
                                                        <?= nl2br(esc($k['komentar'])) ?>
                                                    </p>
                                                </div>
                                                
                                                <div class="comment-actions mt-2">
                                                    <button class="btn btn-link btn-sm text-muted p-0" onclick="replyComment(<?= $k['id'] ?>, '<?= esc($k['nama']) ?>')">
                                                        <i class="fas fa-reply me-1"></i>
                                                        Balas
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Replies -->
                                        <?php if (!empty($k['replies'])): ?>
                                            <div class="replies mt-3 ms-5">
                                                <?php foreach ($k['replies'] as $reply): ?>
                                                    <div class="reply-item p-3 mb-2 bg-light rounded">
                                                        <div class="d-flex align-items-start">
                                                            <div class="flex-shrink-0 me-3">
                                                                <div class="reply-avatar bg-secondary text-white d-flex align-items-center justify-content-center" 
                                                                    style="width: 40px; height: 40px; border-radius: 50%; font-size: 1rem; font-weight: bold;">
                                                                    <?= strtoupper(substr($reply['nama'], 0, 1)) ?>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="flex-grow-1">
                                                                <div class="reply-header mb-1">
                                                                    <h6 class="reply-author mb-1 fw-bold text-dark" style="font-size: 0.95rem;">
                                                                        <?= esc($reply['nama']) ?>
                                                                    </h6>
                                                                    <div class="reply-meta text-muted">
                                                                        <i class="fas fa-clock me-1"></i>
                                                                        <small><?= date('d F Y, H:i', strtotime($reply['tanggal'])) ?> WIB</small>
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="reply-content">
                                                                    <p class="mb-0 text-dark" style="line-height: 1.5; font-size: 0.95rem;">
                                                                        <?= nl2br(esc($reply['komentar'])) ?>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.artikel-content {
    line-height: 1.8;
    font-size: 1.1rem;
}

.artikel-content h2,
.artikel-content h3,
.artikel-content h4 {
    color: var(--primary-green);
    margin-top: 2rem;
    margin-bottom: 1rem;
}

.artikel-content p {
    margin-bottom: 1.2rem;
    text-align: justify;
}

.artikel-content img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    margin: 1.5rem 0;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.artikel-content ul,
.artikel-content ol {
    margin-bottom: 1.5rem;
    padding-left: 2rem;
}

.artikel-content li {
    margin-bottom: 0.5rem;
}

.artikel-content blockquote {
    border-left: 4px solid var(--primary-green);
    background-color: #f8f9fa;
    padding: 1rem 1.5rem;
    margin: 1.5rem 0;
    font-style: italic;
}

.hover-text-success:hover {
    color: var(--primary-green) !important;
}

.breadcrumb-item + .breadcrumb-item::before {
    color: var(--primary-green);
}

.breadcrumb-item.active {
    color: #6c757d;
}

/* Comment Styles */
.comment-item {
    transition: all 0.3s ease;
}

.comment-item:hover {
    background-color: #f8f9fa !important;
    transform: translateY(-1px);
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.comment-avatar {
    transition: all 0.3s ease;
}

.comment-item:hover .comment-avatar {
    transform: scale(1.05);
    box-shadow: 0 4px 15px rgba(40, 167, 69, 0.4);
}

.comment-author {
    color: #2c3e50;
    font-size: 1.1rem;
}

.comment-meta {
    font-size: 0.85rem;
}

.comment-content {
    font-size: 1rem;
    color: #495057;
}

.comment-actions .btn-link {
    font-size: 0.85rem;
    text-decoration: none;
    transition: color 0.3s ease;
}

.comment-actions .btn-link:hover {
    color: #28a745 !important;
}

/* Form Styles */
.form-control-lg {
    border-radius: 10px;
    border: 2px solid #e9ecef;
    transition: all 0.3s ease;
}

.form-control-lg:focus {
    border-color: #28a745;
    box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
}

.form-floating > label {
    padding-left: 1rem;
}

.btn-success {
    background: linear-gradient(135deg, #28a745, #20c997);
    border: none;
    border-radius: 10px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
}

.btn-success:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(40, 167, 69, 0.4);
}

/* Mobile Responsiveness */
@media (max-width: 768px) {
    .artikel-content {
        font-size: 1rem;
    }
    
    .d-flex.gap-2 {
        gap: 0.5rem !important;
    }
    
    .btn-sm {
        font-size: 0.8rem;
        padding: 0.4rem 0.8rem;
    }
    
    .comment-avatar {
        width: 50px !important;
        height: 50px !important;
        font-size: 1.2rem !important;
    }
    
    .comment-item {
        padding: 1rem !important;
    }
    
    .btn-lg {
        font-size: 1rem;
        padding: 0.75rem 2rem;
    }

    .replies {
        margin-left: 1rem !important;
        padding-left: 0.5rem;
    }
    
    .reply-avatar {
        width: 35px !important;
        height: 35px !important;
        font-size: 0.9rem !important;
    }
}

/* Toast Container */
.toast-container {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 1055;
}

/* Animation for new comments */
@keyframes slideInFromRight {
    from {
        opacity: 0;
        transform: translateX(30px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.comment-item {
    animation: slideInFromRight 0.5s ease-out;
}

/* Badge styles */
.badge {
    font-size: 0.75rem;
    padding: 0.35em 0.65em;
}

.badge-light {
    background-color: #f8f9fa;
    color: #6c757d;
    border: 1px solid #dee2e6;
}

.replies {
    border-left: 3px solid #e9ecef;
    padding-left: 1rem;
}

.reply-item {
    transition: all 0.3s ease;
}

.reply-item:hover {
    transform: translateX(5px);
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.reply-avatar {
    transition: all 0.3s ease;
}

.reply-item:hover .reply-avatar {
    transform: scale(1.05);
}

#replyInfo {
    animation: slideDown 0.3s ease;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        showToast('Link berhasil disalin!', 'success');
    }, function(err) {
        showToast('Gagal menyalin link!', 'error');
    });
}

function showToast(message, type = 'success') {
    const toastContainer = document.querySelector('.toast-container') || createToastContainer();
    const toastId = 'toast-' + Date.now();
    
    const toastHTML = `
        <div id="${toastId}" class="toast align-items-center text-white bg-${type === 'success' ? 'success' : 'danger'} border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="fas fa-${type === 'success' ? 'check' : 'times'}-circle me-2"></i>
                    ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    `;
    
    toastContainer.insertAdjacentHTML('beforeend', toastHTML);
    const toastElement = document.getElementById(toastId);
    const toast = new bootstrap.Toast(toastElement, { delay: 3000 });
    toast.show();
    
    toastElement.addEventListener('hidden.bs.toast', function() {
        toastElement.remove();
    });
}

function createToastContainer() {
    const container = document.createElement('div');
    container.className = 'toast-container';
    document.body.appendChild(container);
    return container;
}

document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('.needs-validation');
    
    if (form) {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        });
    }
});


function replyComment(commentId, authorName) {
    // Set parent_id
    document.getElementById('parent_id').value = commentId;
    
    // Show reply info
    const replyInfo = document.getElementById('replyInfo');
    const replyToName = document.getElementById('replyToName');
    const submitText = document.getElementById('submitText');
    
    replyToName.textContent = authorName;
    replyInfo.style.display = 'block';
    submitText.textContent = 'Kirim Balasan';
    
    // Focus on comment textarea
    document.getElementById('komentar').focus();
    
    // Scroll to form
    document.getElementById('commentForm').scrollIntoView({ behavior: 'smooth' });
}

function cancelReply() {
    // Reset form
    document.getElementById('parent_id').value = '';
    document.getElementById('replyInfo').style.display = 'none';
    document.getElementById('submitText').textContent = 'Kirim Komentar';
}

document.addEventListener('DOMContentLoaded', function() {
    const progressBar = document.createElement('div');
    progressBar.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        width: 0%;
        height: 3px;
        background: linear-gradient(135deg, #28a745, #20c997);
        z-index: 1000;
        transition: width 0.3s ease;
    `;
    document.body.appendChild(progressBar);
    
    window.addEventListener('scroll', function() {
        const windowHeight = window.innerHeight;
        const documentHeight = document.documentElement.scrollHeight - windowHeight;
        const scrollTop = window.pageYOffset;
        const progress = (scrollTop / documentHeight) * 100;
        
        progressBar.style.width = Math.min(progress, 100) + '%';
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const artikelImages = document.querySelectorAll('.artikel-content img');
    
    artikelImages.forEach(img => {
        img.style.cursor = 'pointer';
        img.addEventListener('click', function() {
            createLightbox(this.src, this.alt);
        });
    });
});

document.addEventListener('DOMContentLoaded', function() {
    if (document.querySelector('.alert-success')) {
        setTimeout(() => {
            const commentSection = document.querySelector('.comment-list');
            if (commentSection) {
                commentSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }, 500);
    }
});

function createLightbox(src, alt) {
    const lightbox = document.createElement('div');
    lightbox.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.9);
        z-index: 2000;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    `;
    
    const img = document.createElement('img');
    img.src = src;
    img.alt = alt;
    img.style.cssText = `
        max-width: 90%;
        max-height: 90%;
        object-fit: contain;
        border-radius: 8px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.5);
    `;
    
    const closeBtn = document.createElement('button');
    closeBtn.innerHTML = '<i class="fas fa-times"></i>';
    closeBtn.style.cssText = `
        position: absolute;
        top: 20px;
        right: 20px;
        background: rgba(255,255,255,0.2);
        border: none;
        color: white;
        font-size: 1.5rem;
        padding: 10px;
        border-radius: 50%;
        cursor: pointer;
        transition: background-color 0.3s ease;
    `;
    
    closeBtn.addEventListener('mouseenter', function() {
        this.style.backgroundColor = 'rgba(255,255,255,0.3)';
    });
    
    closeBtn.addEventListener('mouseleave', function() {
        this.style.backgroundColor = 'rgba(255,255,255,0.2)';
    });
    
    lightbox.appendChild(img);
    lightbox.appendChild(closeBtn);
    document.body.appendChild(lightbox);
    
    [lightbox, closeBtn].forEach(element => {
        element.addEventListener('click', function(e) {
            if (e.target === lightbox || e.target === closeBtn || e.target.closest('button') === closeBtn) {
                document.body.removeChild(lightbox);
            }
        });
    });
    
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && document.body.contains(lightbox)) {
            document.body.removeChild(lightbox);
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    const commentTextarea = document.getElementById('komentar');
    if (commentTextarea) {
        const maxLength = 500;
        const counter = document.createElement('div');
        counter.className = 'text-muted text-end mt-1';
        counter.style.fontSize = '0.8rem';
        
        function updateCounter() {
            const currentLength = commentTextarea.value.length;
            counter.textContent = `${currentLength}/${maxLength} karakter`;
            
            if (currentLength > maxLength * 0.9) {
                counter.classList.remove('text-muted');
                counter.classList.add('text-warning');
            } else {
                counter.classList.remove('text-warning');
                counter.classList.add('text-muted');
            }
        }
        
        commentTextarea.parentNode.appendChild(counter);
        commentTextarea.addEventListener('input', updateCounter);
        updateCounter();
    }
});

document.addEventListener('DOMContentLoaded', function() {
    const comments = document.querySelectorAll('.comment-item');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }, index * 100);
            }
        });
    }, { threshold: 0.1 });
    
    comments.forEach(comment => {
        comment.style.opacity = '0';
        comment.style.transform = 'translateY(20px)';
        comment.style.transition = 'all 0.6s ease';
        observer.observe(comment);
    });
});
</script>
<?= $this->endSection() ?>