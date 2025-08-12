<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<section class="hero-section bg-success bg-gradient text-white py-5" style="min-height: 70vh; background: linear-gradient(135deg, #28a745, #20c997);">
    <div class="container">
        <div class="row align-items-center min-vh-50">
            <div class="col-lg-6 order-2 order-lg-1">
                <h1 class="display-4 fw-bold mb-3"><?= esc($konten_beranda['judul_utama']) ?></h1>
                <h4 class="fw-light mb-4 text-light"><?= esc($konten_beranda['subjudul']) ?></h4>
                <p class="lead mb-4"><?= esc($konten_beranda['deskripsi']) ?></p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="<?= base_url('konsultasi') ?>" class="btn btn-light btn-lg px-4 py-2">
                        <i class="fas fa-comments me-2"></i>Konsultasi Gratis
                    </a>
                    <a href="<?= base_url('artikel') ?>" class="btn btn-outline-light btn-lg px-4 py-2">
                        <i class="fas fa-newspaper me-2"></i>Baca Artikel
                    </a>
                </div>
            </div>
            <div class="col-lg-6 order-1 order-lg-2 mb-4 mb-lg-0">
                <?php
                $hero_image = base_url('uploads/home.png');
                $fallback_image = base_url('assets/images/hero-default.jpg');
                ?>
                <div class="hero-image-container position-relative">
                    <div class="hero-image-wrapper">
                        <img src="<?= $hero_image ?>" 
                             alt="Pertanian Modern" 
                             class="hero-image img-fluid" 
                             onerror="this.src='<?= $fallback_image ?>'; this.onerror=null;">
                        <div class="image-overlay"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-light">
    <div class="container">
        <div class="row text-center">
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100 stats-card">
                    <div class="card-body">
                        <div class="text-success mb-3">
                            <i class="fas fa-newspaper fa-3x"></i>
                        </div>
                        <h3 class="fw-bold text-success counter" data-target="<?= $statistik['total_artikel'] ?>">0</h3>
                        <p class="card-text text-muted">Artikel Informatif</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100 stats-card">
                    <div class="card-body">
                        <div class="text-success mb-3">
                            <i class="fas fa-comments fa-3x"></i>
                        </div>
                        <h3 class="fw-bold text-success counter" data-target="<?= $statistik['total_konsultasi'] ?>">0</h3>
                        <p class="card-text text-muted">Konsultasi Selesai</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100 stats-card">
                    <div class="card-body">
                        <div class="text-success mb-3">
                            <i class="fas fa-user-tie fa-3x"></i>
                        </div>
                        <h3 class="fw-bold text-success counter" data-target="<?= $statistik['total_penyuluh'] ?>">0</h3>
                        <p class="card-text text-muted">Penyuluh Ahli</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100 stats-card">
                    <div class="card-body">
                        <div class="text-success mb-3">
                            <i class="fas fa-users fa-3x"></i>
                        </div>
                        <h3 class="fw-bold text-success counter" data-target="<?= $statistik['total_anggota'] ?>">0</h3>
                        <p class="card-text text-muted">Anggota Aktif</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold text-success mb-3">Layanan Kami</h2>
            <p class="lead text-muted">Berbagai layanan terlengkap untuk mendukung kesuksesan pertanian dan peternakan Anda</p>
        </div>
        <div class="row">
            <?php foreach ($layanan_utama as $layanan): ?>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100 hover-card service-card">
                    <div class="card-body text-center p-4">
                        <div class="service-icon text-success mb-3">
                            <i class="<?= esc($layanan['icon']) ?> fa-3x"></i>
                        </div>
                        <h5 class="card-title fw-bold"><?= esc($layanan['nama']) ?></h5>
                        <p class="card-text text-muted mb-4"><?= esc($layanan['deskripsi']) ?></p>
                        <a href="<?= base_url($layanan['url']) ?>" class="btn btn-outline-success btn-sm px-4">
                            Selengkapnya <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold text-success mb-3">Artikel Terbaru</h2>
            <p class="lead text-muted">Tips dan informasi terkini untuk meningkatkan produktivitas usaha Anda</p>
        </div>
        <div class="row">
            <?php foreach ($artikel_terbaru as $artikel): ?>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100 hover-card article-card">
                    <div class="article-image-container">
                        <img src="<?= base_url('uploads/artikel/' . ($artikel['gambar'] ?? 'default-artikel.jpg')) ?>" 
                             class="card-img-top article-image" alt="<?= esc($artikel['judul']) ?>">
                        <div class="article-overlay">
                            <i class="fas fa-eye"></i>
                        </div>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <small class="text-muted mb-2">
                            <i class="fas fa-calendar-alt me-1"></i>
                            <?= date('d M Y', strtotime($artikel['tanggal'])) ?>
                        </small>
                        <h6 class="card-title fw-bold"><?= esc($artikel['judul']) ?></h6>
                        <p class="card-text text-muted flex-grow-1"><?= esc($artikel['ringkasan']) ?></p>
                        <a href="<?= base_url('artikel/' . $artikel['slug']) ?>" class="btn btn-success btn-sm mt-auto">
                            Baca Selengkapnya
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center mt-4">
            <a href="<?= base_url('artikel') ?>" class="btn btn-outline-success btn-lg px-5">
                Lihat Semua Artikel <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>

<section class="py-5 bg-success text-white cta-section">
    <div class="container text-center">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h3 class="fw-bold mb-3">Siap Mengembangkan Usaha Pertanian Anda?</h3>
                <p class="lead mb-4">Bergabunglah dengan ribuan petani dan peternak yang telah merasakan manfaat platform kami</p>
                <div class="d-flex gap-3 justify-content-center flex-wrap">
                    <a href="<?= base_url('konsultasi') ?>" class="btn btn-light btn-lg px-4 cta-btn">
                        <i class="fas fa-phone me-2"></i>Konsultasi Sekarang
                    </a>
                    <a href="<?= base_url('diskusi') ?>" class="btn btn-outline-light btn-lg px-4 cta-btn">
                        <i class="fas fa-users me-2"></i>Gabung Diskusi
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.hero-image-container {
    position: relative;
    max-width: 500px;
    margin: 0 auto;
    .floating-element {
        display: none;
    }
}

.hero-image-wrapper {
    position: relative;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
    transform: perspective(1000px) rotateY(-5deg) rotateX(5deg);
    transition: transform 0.3s ease;
}

.hero-image-wrapper:hover {
    transform: perspective(1000px) rotateY(0deg) rotateX(0deg) scale(1.05);
}

.hero-image {
    width: 100%;
    height: 400px;
    object-fit: cover;
    display: block;
}

.image-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(40, 167, 69, 0.1), rgba(32, 201, 151, 0.1));
    pointer-events: none;
}

.floating-element {
    position: absolute;
    background: rgba(255, 255, 255, 0.9);
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    color: #28a745;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    animation: float 6s ease-in-out infinite;
}

.element-1 {
    top: -30px;
    right: -30px;
    animation-delay: 0s;
}

.element-2 {
    bottom: -20px;
    left: -20px;
    animation-delay: 2s;
}

.element-3 {
    top: 50%;
    right: -40px;
    animation-delay: 4s;
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}

.hover-card {
    transition: all 0.3s ease;
    border-radius: 15px;
    overflow: hidden;
}

.hover-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15) !important;
}

.stats-card {
    background: linear-gradient(135deg, #ffffff, #f8f9fa);
}

.service-card {
    position: relative;
}

.service-card:before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #28a745, #20c997);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.service-card:hover:before {
    opacity: 1;
}

.service-icon {
    transition: transform 0.3s ease;
}

.service-card:hover .service-icon {
    transform: scale(1.1);
}

.article-card {
    border-radius: 15px;
    overflow: hidden;
}

.article-image-container {
    position: relative;
    overflow: hidden;
}

.article-image {
    height: 200px;
    object-fit: cover;
    width: 100%;
    transition: transform 0.3s ease;
}

.article-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(40, 167, 69, 0.8);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.article-overlay i {
    color: white;
    font-size: 2rem;
}

.article-card:hover .article-image {
    transform: scale(1.1);
}

.article-card:hover .article-overlay {
    opacity: 1;
}

.cta-section {
    background: linear-gradient(135deg, #28a745, #20c997);
    position: relative;
}

.cta-section:before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="1" fill="white" opacity="0.1"/><circle cx="10" cy="90" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>') repeat;
    opacity: 0.3;
}

.cta-btn {
    border-radius: 25px;
    transition: all 0.3s ease;
}

.cta-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
}

.counter {
    font-size: 2.5rem;
}

@media (max-width: 768px) {
    .display-4 {
        font-size: 2rem;
    }
    
    .hero-section {
        min-height: 60vh;
    }
    
    .btn-lg {
        padding: 0.75rem 1.5rem;
        font-size: 1rem;
    }
    
    .hero-image-wrapper {
        transform: none;
        border-radius: 15px;
    }
    
    .hero-image {
        height: 300px;
    }
}

@media (max-width: 576px) {
    .hero-image {
        height: 250px;
    }
    
    .counter {
        font-size: 2rem;
    }
}

.min-vh-50 {
    min-height: 50vh;
}
</style>

<?= $this->section('scripts') ?>
<script>
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
});

const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver(function(entries) {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
            
            if (entry.target.classList.contains('counter') && !entry.target.hasAttribute('data-animated')) {
                animateCounter(entry.target);
                entry.target.setAttribute('data-animated', 'true');
            }
        }
    });
}, observerOptions);

function animateCounter(element) {
    const target = parseInt(element.getAttribute('data-target'));
    const increment = target / 100;
    let current = 0;
    
    const timer = setInterval(() => {
        current += increment;
        if (current >= target) {
            current = target;
            clearInterval(timer);
        }
        element.textContent = Math.floor(current).toLocaleString();
    }, 20);
}

document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.card');
    cards.forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(card);
    });
    
    const counters = document.querySelectorAll('.counter');
    counters.forEach(counter => {
        observer.observe(counter);
    });
    
    const images = document.querySelectorAll('img');
    images.forEach(img => {
        img.addEventListener('load', function() {
            this.style.opacity = '1';
        });
        img.style.opacity = '0';
        img.style.transition = 'opacity 0.5s ease';
    });
});

const sections = document.querySelectorAll('section');
sections.forEach(section => {
    observer.observe(section);
});
</script>
<?= $this->endSection() ?>

<?= $this->endSection() ?>