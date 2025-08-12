<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container py-5">
    <div class="row">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('penyuluh') ?>">Daftar Penyuluh</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= esc($penyuluh['nama']) ?></li>
            </ol>
        </nav>
    </div>

    <div class="row mb-5">
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <?php if (!empty($penyuluh['foto'])): ?>
                        <img src="<?= base_url('uploads/penyuluh/' . esc($penyuluh['foto'])) ?>" 
                             alt="<?= esc($penyuluh['nama']) ?>" 
                             class="img-fluid rounded-circle mb-3" 
                             style="width: 200px; height: 200px; object-fit: cover;">
                    <?php else: ?>
                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" 
                             style="width: 200px; height: 200px;">
                            <i class="fas fa-user-circle fa-5x text-muted"></i>
                        </div>
                    <?php endif; ?>

                    <h2 class="h4 fw-bold text-success mb-1"><?= esc($penyuluh['nama']) ?></h2>
                    
                    <div class="mb-3">
                        <span class="badge bg-success rounded-pill">
                            <i class="fas fa-<?= $penyuluh['spesialisasi'] == 'pertanian' ? 'seedling' : ($penyuluh['spesialisasi'] == 'peternakan' ? 'cow' : 'leaf') ?> me-1"></i>
                            <?= ucfirst(esc($penyuluh['spesialisasi'])) ?>
                        </span>
                    </div>

                    <p class="text-muted mb-3">
                        <i class="fas fa-map-marker-alt me-1"></i>
                        <?= esc($penyuluh['wilayah_kerja']) ?>
                    </p>

                    <?php if (!empty($penyuluh['pengalaman'])): ?>
                    <p class="text-muted mb-3">
                        <i class="fas fa-clock me-1"></i>
                        <?= esc($penyuluh['pengalaman']) ?> tahun pengalaman
                    </p>
                    <?php endif; ?>

                    <a href="<?= base_url('penyuluh/whatsapp/' . $penyuluh['id']) ?>"
                       class="btn btn-success btn-lg w-100 mb-3" 
                       target="_blank">
                        <i class="fab fa-whatsapp me-2"></i>Hubungi via WhatsApp
                    </a>

                    <div class="text-start">
                        <?php if (!empty($penyuluh['email'])): ?>
                        <p class="mb-2">
                            <i class="fas fa-envelope me-2 text-success"></i>
                            <a href="mailto:<?= esc($penyuluh['email']) ?>" class="text-decoration-none text-dark">
                                <?= esc($penyuluh['email']) ?>
                            </a>
                        </p>
                        <?php endif; ?>

                        <?php if (!empty($penyuluh['phone'])): ?>
                        <p class="mb-0">
                            <i class="fas fa-phone me-2 text-success"></i>
                            <a href="tel:<?= esc($penyuluh['phone']) ?>" class="text-decoration-none text-dark">
                                <?= esc($penyuluh['phone']) ?>
                            </a>
                        </p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h3 class="h5 fw-bold text-success mb-3">Tentang Penyuluh</h3>
                    <p><?= !empty($penyuluh['bio']) ? nl2br(esc($penyuluh['bio'])) : 'Bio belum tersedia.' ?></p>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h3 class="h5 fw-bold text-success mb-3">Informasi Tambahan</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-2"><strong>Status:</strong> 
                                <span class="badge bg-<?= $penyuluh['status'] == 'aktif' ? 'success' : 'secondary' ?>">
                                    <?= $penyuluh['status'] == 'aktif' ? 'Aktif' : 'Nonaktif' ?>
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-2"><strong>Bergabung Sejak:</strong> 
                                <?= date('d F Y', strtotime($penyuluh['created_at'])) ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if (!empty($penyuluh_lain)): ?>
    <div class="row mt-5">
        <div class="col-12">
            <h3 class="h4 fw-bold text-success mb-4">Penyuluh Lain di <?= esc($penyuluh['wilayah_kerja']) ?></h3>
            
            <div class="row">
                <?php foreach ($penyuluh_lain as $p): ?>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex">
                                <?php if (!empty($p['foto'])): ?>
                                    <img src="<?= base_url('uploads/penyuluh/' . esc($p['foto'])) ?>" 
                                         alt="<?= esc($p['nama']) ?>" 
                                         class="rounded-circle me-3" 
                                         style="width: 60px; height: 60px; object-fit: cover;">
                                <?php else: ?>
                                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-3" 
                                         style="width: 60px; height: 60px;">
                                        <i class="fas fa-user-circle fa-2x text-muted"></i>
                                    </div>
                                <?php endif; ?>
                                
                                <div>
                                    <h5 class="h6 fw-bold mb-0">
                                        <a href="<?= base_url('penyuluh/detail/' . $p['id']) ?>" class="text-decoration-none text-dark">
                                            <?= esc($p['nama']) ?>
                                        </a>
                                    </h5>
                                    <p class="text-muted mb-1">
                                        <span class="badge bg-success rounded-pill">
                                            <?= ucfirst(esc($p['spesialisasi'])) ?>
                                        </span>
                                    </p>
                                    <a href="<?= base_url('penyuluh/whatsapp/' . $p['id']) ?>" 
                                       class="btn btn-sm btn-outline-success py-0 px-2">
                                        <i class="fab fa-whatsapp me-1"></i>Hubungi
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate__animated', 'animate__fadeInUp');
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.card').forEach(card => {
        observer.observe(card);
    });
});
</script>
<?= $this->endSection() ?>