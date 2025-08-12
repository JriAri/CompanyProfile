<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card shadow border-0">
                    <div class="card-header bg-success text-white text-center py-4">
                        <h3 class="mb-0">
                            <i class="fas fa-search me-2"></i>
                            Lacak Konsultasi
                        </h3>
                    </div>
                    <div class="card-body p-5">
                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger">
                                <?= session()->getFlashdata('error') ?>
                            </div>
                        <?php endif; ?>
                        
                        <form method="get" action="<?= base_url('/konsultasi/tracking') ?>">
                            <div class="mb-4">
                                <label for="tiket" class="form-label fw-bold">
                                    <i class="fas fa-ticket-alt text-success me-2"></i>
                                    Nomor Tiket
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control form-control-lg" 
                                       id="tiket" 
                                       name="tiket" 
                                       placeholder="Contoh: TKT-20230801-ABCDEF"
                                       required>
                                <div class="form-text">
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Masukkan nomor tiket yang Anda terima di email
                                    </small>
                                </div>
                            </div>
                            
                            <div class="d-grid">
                                <button type="submit" class="btn btn-success btn-lg py-3">
                                    <i class="fas fa-search me-2"></i>
                                    Lacak Konsultasi
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>