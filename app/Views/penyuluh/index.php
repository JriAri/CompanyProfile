<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<section class="bg-success bg-gradient text-white py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-5 fw-bold mb-3">Konsultasi dengan Penyuluh Ahli</h1>
                <p class="lead mb-4">Temukan penyuluh pertanian dan peternakan terpercaya di wilayah Anda. Dapatkan konsultasi gratis melalui WhatsApp.</p>
            </div>
            <div class="col-lg-4 text-center">
                <i class="fas fa-user-tie fa-5x opacity-75"></i>
            </div>
        </div>
    </div>
</section>

<section class="py-4 bg-light">
    <div class="container">
        <div class="row text-center">
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="d-flex align-items-center justify-content-center">
                    <i class="fas fa-user-tie text-success fa-2x me-3"></i>
                    <div>
                        <h4 class="fw-bold text-success mb-0"><?= number_format($statistik['total_penyuluh']) ?></h4>
                        <small class="text-muted">Total Penyuluh</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="d-flex align-items-center justify-content-center">
                    <i class="fas fa-seedling text-success fa-2x me-3"></i>
                    <div>
                        <h4 class="fw-bold text-success mb-0"><?= number_format($statistik['penyuluh_pertanian']) ?></h4>
                        <small class="text-muted">Penyuluh Pertanian</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="d-flex align-items-center justify-content-center">
                    <i class="fas fa-cow text-success fa-2x me-3"></i>
                    <div>
                        <h4 class="fw-bold text-success mb-0"><?= number_format($statistik['penyuluh_peternakan']) ?></h4>
                        <small class="text-muted">Penyuluh Peternakan</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="d-flex align-items-center justify-content-center">
                    <i class="fas fa-map-marker-alt text-success fa-2x me-3"></i>
                    <div>
                        <h4 class="fw-bold text-success mb-0"><?= number_format($statistik['total_wilayah']) ?></h4>
                        <small class="text-muted">Wilayah Kerja</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-4 border-bottom">
    <div class="container">
        <form method="GET" action="<?= base_url('penyuluh') ?>" class="row g-3 align-items-end">
            <div class="col-lg-4 col-md-6">
                <label for="search" class="form-label fw-semibold">
                    <i class="fas fa-search me-1"></i>Cari Penyuluh
                </label>
                <input type="text" class="form-control" id="search" name="search" 
                       placeholder="Nama atau keahlian..." value="<?= esc($filter['keyword']) ?>">
            </div>
            <div class="col-lg-3 col-md-6">
                <label for="wilayah" class="form-label fw-semibold">
                    <i class="fas fa-map-marker-alt me-1"></i>Wilayah
                </label>
                <select class="form-select" id="wilayah" name="wilayah">
                    <option value="">Semua Wilayah</option>
                    <?php foreach ($wilayah_kerja as $wilayah): ?>
                        <option value="<?= esc($wilayah) ?>" <?= $filter['wilayah'] == $wilayah ? 'selected' : '' ?>>
                            <?= esc($wilayah) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-lg-3 col-md-6">
                <label for="spesialisasi" class="form-label fw-semibold">
                    <i class="fas fa-tags me-1"></i>Spesialisasi
                </label>
                <select class="form-select" id="spesialisasi" name="spesialisasi">
                    <option value="">Semua Spesialisasi</option>
                    <option value="pertanian" <?= $filter['spesialisasi'] == 'pertanian' ? 'selected' : '' ?>>
                        Pertanian
                    </option>
                    <option value="peternakan" <?= $filter['spesialisasi'] == 'peternakan' ? 'selected' : '' ?>>
                        Peternakan
                    </option>
                    <option value="umum" <?= $filter['spesialisasi'] == 'umum' ? 'selected' : '' ?>>
                        Umum
                    </option>
                </select>
            </div>
            <div class="col-lg-2 col-md-6">
                <button type="submit" class="btn btn-success w-100">
                    <i class="fas fa-filter me-1"></i>Filter
                </button>
            </div>
        </form>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <?php if (!empty($penyuluh)): ?>
            <div class="row">
                <?php foreach ($penyuluh as $p): ?>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card border-0 shadow-sm h-100 hover-card">
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                            <?php if (!empty($p['foto'])): ?>
                                <img src="<?= base_url('uploads/penyuluh/' . esc($p['foto'])) ?>" 
                                     alt="<?= esc($p['nama']) ?>" class="img-fluid rounded" style="max-height: 180px; max-width: 180px; object-fit: cover;">
                            <?php else: ?>
                                <div class="text-center">
                                    <i class="fas fa-user-circle text-muted fa-5x mb-2"></i>
                                    <br><small class="text-muted">Foto tidak tersedia</small>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="card-body d-flex flex-column">
                            <div class="mb-2">
                                <span class="badge bg-success rounded-pill">
                                    <i class="fas fa-<?= $p['spesialisasi'] == 'pertanian' ? 'seedling' : ($p['spesialisasi'] == 'peternakan' ? 'cow' : 'leaf') ?> me-1"></i>
                                    <?= ucfirst(esc($p['spesialisasi'])) ?>
                                </span>
                            </div>
                            
                            <h5 class="card-title fw-bold text-dark mb-2"><?= esc($p['nama']) ?></h5>
                            
                            <p class="text-muted mb-2">
                                <i class="fas fa-map-marker-alt me-1"></i>
                                <?= esc($p['wilayah_kerja']) ?>
                            </p>
                            
                            <?php if (!empty($p['pengalaman'])): ?>
                            <p class="text-muted mb-2">
                                <i class="fas fa-clock me-1"></i>
                                <?= esc($p['pengalaman']) ?> tahun pengalaman
                            </p>
                            <?php endif; ?>
                            
                            <p class="card-text text-muted flex-grow-1 mb-3">
                                <?= esc(isset($p['bio']) ? substr($p['bio'], 0, 100) : 'Deskripsi tidak tersedia') ?>...
                            </p>
                            
                            <div class="mt-auto">
                                <div class="d-grid gap-2">
                                    <a href="<?= base_url('penyuluh/whatsapp/' . $p['id']) ?>"
                                    class="btn btn-success btn-sm" target="_blank">
                                        <i class="fab fa-whatsapp me-1"></i> Hubungi via WhatsApp
                                    </a>
                                    <a href="<?= base_url('penyuluh/detail/' . $p['id']) ?>" 
                                       class="btn btn-outline-success btn-sm">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Detail Penyuluh
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="fas fa-search fa-5x text-muted mb-3"></i>
                <h4 class="text-muted mb-3">Penyuluh Tidak Ditemukan</h4>
                <p class="text-muted mb-4">Maaf, tidak ada penyuluh yang sesuai dengan kriteria pencarian Anda.</p>
                <a href="<?= base_url('penyuluh') ?>" class="btn btn-success">
                    <i class="fas fa-refresh me-1"></i>Lihat Semua Penyuluh
                </a>
            </div>
        <?php endif; ?>
    </div>
</section>

<section class="py-5 bg-success text-white">
    <div class="container text-center">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h3 class="fw-bold mb-3">Butuh Konsultasi Segera?</h3>
                <p class="lead mb-4">Tim penyuluh kami siap membantu Anda 24/7 melalui WhatsApp</p>
                <a href="<?= base_url('konsultasi') ?>" class="btn btn-light btn-lg px-4">
                    <i class="fas fa-comments me-2"></i>Konsultasi Sekarang
                </a>
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
    box-shadow: 0 10px 25px rgba(0,0,0,0.15) !important;
}

.badge {
    font-size: 0.75rem;
}

@media (max-width: 768px) {
    .display-5 {
        font-size: 2rem;
    }
    
    .card-body {
        padding: 1rem;
    }
}
</style>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.getElementById('wilayah').addEventListener('change', function() {
    this.form.submit();
});

document.getElementById('spesialisasi').addEventListener('change', function() {
    this.form.submit();
});

document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.hover-card');
    
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
    
    cards.forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(card);
    });
});
</script>
<?= $this->endSection() ?>