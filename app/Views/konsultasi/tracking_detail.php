<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow border-0">
                    <div class="card-header bg-success text-white py-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h3 class="mb-0">
                                    <i class="fas fa-ticket-alt me-2"></i>
                                    Tiket #<?= esc($konsultasi['tiket']) ?>
                                </h3>
                                <p class="mb-0 opacity-75">Detail Konsultasi</p>
                            </div>
                            <span class="badge bg-light text-dark fs-6">
                                <?= ucfirst($konsultasi['status']) ?>
                            </span>
                        </div>
                    </div>
                    <div class="card-body p-5">
                        <div class="mb-5">
                            <h4 class="mb-4 pb-2 border-bottom">Informasi Konsultasi</h4>
                            <div class="row mb-3">
                                <div class="col-md-4 fw-bold">Nama Pengirim</div>
                                <div class="col-md-8"><?= esc($konsultasi['nama']) ?></div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4 fw-bold">Email</div>
                                <div class="col-md-8"><?= esc($konsultasi['email']) ?></div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4 fw-bold">Wilayah</div>
                                <div class="col-md-8"><?= esc($konsultasi['wilayah']) ?></div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4 fw-bold">Tanggal Konsultasi</div>
                                <div class="col-md-8"><?= date('d/m/Y H:i', strtotime($konsultasi['created_at'])) ?></div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4 fw-bold">Pesan</div>
                                <div class="col-md-8"><?= nl2br(esc($konsultasi['pesan'])) ?></div>
                            </div>
                        </div>
                        
                        <?php if ($penyuluh): ?>
                        <div class="mb-5">
                            <h4 class="mb-4 pb-2 border-bottom">Penyuluh Penanggung Jawab</h4>
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <img src="<?= base_url('uploads/penyuluh/' . ($penyuluh['foto'] ?? 'default-penyuluh.jpg')) ?>" 
                                         alt="<?= esc($penyuluh['nama']) ?>" 
                                         class="rounded-circle" 
                                         style="width: 80px; height: 80px; object-fit: cover;">
                                </div>
                                <div class="flex-grow-1 ms-4">
                                    <h5 class="mb-1"><?= esc($penyuluh['nama']) ?></h5>
                                    <p class="mb-1">
                                        <i class="fas fa-briefcase me-1 text-success"></i>
                                        <?= esc($penyuluh['spesialisasi']) ?>
                                    </p>
                                    <p class="mb-1">
                                        <i class="fas fa-phone me-1 text-success"></i>
                                        <?= esc($penyuluh['phone']) ?>
                                    </p>
                                    <p class="mb-0">
                                        <i class="fas fa-envelope me-1 text-success"></i>
                                        <?= esc($penyuluh['email']) ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <?php if ($konsultasi['status'] === 'answered' && $konsultasi['jawaban']): ?>
                        <div class="mb-4">
                            <h4 class="mb-4 pb-2 border-bottom">Jawaban Penyuluh</h4>
                            <div class="card border-success">
                                <div class="card-header bg-success bg-opacity-10">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="fw-bold">Tanggal Dijawab:</span>
                                        <span><?= date('d/m/Y H:i', strtotime($konsultasi['tanggal_dijawab'])) ?></span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <?= nl2br(esc($konsultasi['jawaban'])) ?>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <div class="text-center mt-5">
                            <a href="<?= base_url('/konsultasi') ?>" class="btn btn-outline-success btn-lg px-5">
                                <i class="fas fa-arrow-left me-2"></i>
                                Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>