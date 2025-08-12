<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<section class="hero-section bg-success bg-gradient text-white py-5" style="background: linear-gradient(135deg, #28a745, #20c997);">
    <div class="container">
        <div class="row align-items-center min-vh-30">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-4 fw-bold mb-3">Artikel Pertanian & Peternakan</h1>
                <p class="lead mb-4">Kumpulan artikel terlengkap dan terpercaya untuk mengembangkan usaha pertanian dan peternakan Anda</p>
                
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <form action="<?= base_url('artikel/search') ?>" method="get" class="d-flex">
                            <input type="text" class="form-control form-control-lg me-2" 
                                placeholder="Cari artikel..." name="q" 
                                value="<?= $search_query ?>">
                            <button class="btn btn-light btn-lg px-4" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-4 bg-light">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-4">
                <div class="d-flex align-items-center justify-content-center">
                    <div class="text-success me-3">
                        <i class="fas fa-newspaper fa-2x"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold text-success mb-0"><?= number_format($total_artikel) ?></h4>
                        <small class="text-muted">Total Artikel</small>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="d-flex align-items-center justify-content-center">
                    <div class="text-success me-3">
                        <i class="fas fa-tags fa-2x"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold text-success mb-0"><?= count($kategori_list) ?></h4>
                        <small class="text-muted">Kategori</small>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="d-flex align-items-center justify-content-center">
                    <div class="text-success me-3">
                        <i class="fas fa-eye fa-2x"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold text-success mb-0"><?= number_format($total_views) ?></h4>
                        <small class="text-muted">Total Views</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="fw-bold text-success">Artikel Terbaru</h3>
                    <div class="dropdown">
                        <button class="btn btn-outline-success dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-filter me-2"></i>Filter Kategori
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?= base_url('artikel') ?>">Semua Kategori</a></li>
                            <?php foreach ($kategori_list as $kategori): ?>
                            <li>
                                <a class="dropdown-item" href="<?= base_url('artikel/kategori/' . $kategori['slug']) ?>">
                                    <?= esc($kategori['nama']) ?> (<?= $kategori['total_artikel'] ?>)
                                </a>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>

                <div class="row">
                    <?php if (!empty($artikel_list)): ?>
                        <?php foreach ($artikel_list as $artikel): ?>
                        <div class="col-lg-6 col-md-6 mb-4">
                            <div class="card border-0 shadow-sm h-100 hover-card">
                                <img src="<?= base_url('uploads/artikel/' . ($artikel['gambar'] ?? 'default-artikel.jpg')) ?>" 
                                     class="card-img-top" alt="<?= esc($artikel['judul']) ?>" style="height: 200px; object-fit: cover;">
                                <div class="card-body d-flex flex-column">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <span class="badge bg-success"><?= esc($artikel['kategori_nama']) ?></span>
                                        <small class="text-muted">
                                            <i class="fas fa-eye me-1"></i><?= number_format($artikel['views']) ?>
                                        </small>
                                    </div>
                                    <h5 class="card-title fw-bold">
                                        <a href="<?= base_url('artikel/' . $artikel['slug']) ?>"
                                        class="text-decoration-none text-dark hover-text-success">
                                            <?= esc($artikel['judul']) ?>
                                        </a>
                                    </h5>
                                    <p class="card-text text-muted flex-grow-1 mb-3"><?= esc($artikel['ringkasan']) ?></p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">
                                            <i class="fas fa-calendar-alt me-1"></i>
                                            <?= date('d M Y', strtotime($artikel['tanggal'])) ?>
                                        </small>
                                        <a href="<?= base_url('artikel/' . $artikel['slug']) ?>" 
                                        class="btn btn-success btn-sm">
                                            Selengkapnya <i class="fas fa-arrow-right ms-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12">
                            <div class="text-center py-5">
                                <i class="fas fa-newspaper fa-4x text-muted mb-3"></i>
                                <h4 class="text-muted">Belum ada artikel</h4>
                                <p class="text-muted">Artikel akan segera hadir untuk Anda</p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <?php if (isset($pager)): ?>
                <div class="d-flex justify-content-center mt-4">
                    <?= $pager->links() ?>
                </div>
                <?php endif; ?>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-success text-white">
                        <h6 class="mb-0 fw-bold">
                            <i class="fas fa-tags me-2"></i>Kategori Artikel
                        </h6>
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            <?php foreach ($kategori_list as $kategori): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center hover-item">
                                <a href="<?= base_url('artikel/kategori/' . $kategori['slug']) ?>" 
                                class="text-decoration-none text-dark">
                                    <?= esc($kategori['nama']) ?>
                                </a>
                                <span class="badge bg-success rounded-pill"><?= $kategori['total_artikel'] ?></span>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-success text-white">
                        <h6 class="mb-0 fw-bold">
                            <i class="fas fa-fire me-2"></i>Artikel Populer
                        </h6>
                    </div>
                    <div class="card-body">
                        <?php foreach ($artikel_populer as $index => $populer): ?>
                        <div class="d-flex align-items-start mb-3 <?= $index === count($artikel_populer) - 1 ? '' : 'border-bottom pb-3' ?>">
                            <div class="flex-shrink-0 me-3">
                                <img src="<?= base_url('uploads/artikel/' . ($populer['gambar'] ?? 'default-artikel.jpg')) ?>" 
                                    alt="<?= esc($populer['judul']) ?>" class="rounded" style="width: 60px; height: 60px; object-fit: cover;">
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1">
                                    <a href="<?= base_url('artikel/' . $populer['slug']) ?>"
                                    class="text-decoration-none text-dark hover-text-success">
                                        <?= esc(substr($populer['judul'], 0, 50)) ?><?= strlen($populer['judul']) > 50 ? '...' : '' ?>
                                    </a>
                                </h6>
                                <small class="text-muted">
                                    <i class="fas fa-eye me-1"></i><?= number_format($populer['views']) ?> views
                                </small>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.hover-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.hover-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.15) !important;
}

.hover-text-success:hover {
    color: var(--primary-green) !important;
}

.hover-item:hover {
    background-color: #f8f9fa;
}

.min-vh-30 {
    min-height: 30vh;
}

.dropdown-menu {
    max-height: 300px;
    overflow-y: auto;
}

@media (max-width: 768px) {
    .display-4 {
        font-size: 2rem;
    }
    
    .hero-section {
        min-height: 40vh;
    }
    
    .col-lg-6.col-md-6 {
        margin-bottom: 1rem;
    }
}

/* Custom Bootstrap Pagination */
.page-link {
    color: var(--primary-green);
    border: 1px solid #dee2e6;
}

.page-link:hover {
    color: var(--dark-green);
    background-color: var(--light-green);
    border-color: var(--primary-green);
}

.page-item.active .page-link {
    background-color: var(--primary-green);
    border-color: var(--primary-green);
}
</style>

<?= $this->endSection() ?>

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
        }
    });
}, observerOptions);

document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.hover-card');
    cards.forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(card);
    });
    
    document.addEventListener('click', function(e) {
        const dropdown = document.querySelector('.dropdown');
        if (!dropdown.contains(e.target)) {
            const dropdownMenu = dropdown.querySelector('.dropdown-menu');
            if (dropdownMenu.classList.contains('show')) {
                bootstrap.Dropdown.getOrCreateInstance(dropdown.querySelector('.dropdown-toggle')).hide();
            }
        }
    });
});
</script>
<?= $this->endSection() ?>