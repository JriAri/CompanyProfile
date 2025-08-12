<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h1 class="fw-bold text-success mb-3">Lokasi Toko Pertanian</h1>
            <p class="lead text-muted">Temukan toko bibit, pupuk, obat hewan, dan alat pertanian terdekat</p>
        </div>

        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex flex-wrap gap-2 justify-content-center">
                    <a href="<?= base_url('belanja') ?>" 
                       class="btn <?= !$activeKategori ? 'btn-success' : 'btn-outline-success' ?> btn-sm">
                        Semua Toko
                    </a>
                    <?php foreach ($kategoriList as $kategori): ?>
                        <a href="<?= base_url('belanja?kategori='.$kategori['jenis_toko']) ?>" 
                           class="btn <?= $activeKategori === $kategori['jenis_toko'] ? 'btn-success' : 'btn-outline-success' ?> btn-sm">
                            <?= $kategori['label'] ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="row">
            <?php if (empty($tokoList)): ?>
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        Belum ada toko yang terdaftar.
                    </div>
                </div>
            <?php else: ?>
                <?php foreach ($tokoList as $toko): ?>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card border-0 shadow-sm h-100 toko-card">
                            <?php if ($toko['gambar']): ?>
                                <img src="<?= base_url('uploads/toko/'.$toko['gambar']) ?>" 
                                     class="card-img-top" 
                                     alt="<?= esc($toko['nama_toko']) ?>" 
                                     style="height: 200px; object-fit: cover;">
                            <?php else: ?>
                                <div class="bg-light d-flex align-items-center justify-content-center" 
                                     style="height: 200px;">
                                    <i class="fas fa-store fa-3x text-success"></i>
                                </div>
                            <?php endif; ?>
                            
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h5 class="card-title fw-bold text-success mb-0"><?= esc($toko['nama_toko']) ?></h5>
                                    <span class="badge bg-success">
                                        <?= $kategoriList[array_search($toko['jenis_toko'], array_column($kategoriList, 'jenis_toko'))]['label'] ?>
                                    </span>
                                </div>
                                
                                <p class="card-text text-muted small mb-2">
                                    <i class="fas fa-map-marker-alt me-1"></i>
                                    <?= esc($toko['alamat']) ?>
                                </p>
                                
                                <?php if ($toko['telepon']): ?>
                                    <p class="card-text small mb-2">
                                        <i class="fas fa-phone me-1"></i>
                                        <a href="tel:<?= esc($toko['telepon']) ?>" class="text-decoration-none">
                                            <?= esc($toko['telepon']) ?>
                                        </a>
                                    </p>
                                <?php endif; ?>
                                
                                <?php if ($toko['deskripsi']): ?>
                                    <p class="card-text"><?= esc($toko['deskripsi']) ?></p>
                                <?php endif; ?>
                            </div>
                            
                            <div class="card-footer bg-transparent border-0">
                                <?php if (!empty($toko['link_gmaps'])): ?>
                                    <a href="<?= esc($toko['link_gmaps']) ?>" 
                                       target="_blank" 
                                       class="btn btn-success btn-sm w-100">
                                        <i class="fas fa-map-marked-alt me-1"></i> Lihat di Google Maps
                                    </a>
                                <?php else: ?>
                                    <button class="btn btn-secondary btn-sm w-100" disabled>
                                        <i class="fas fa-map-marked-alt me-1"></i> Link Maps Tidak Tersedia
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

    </div>
</section>

<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
    .toko-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .toko-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
</style>
<?= $this->endSection() ?>
