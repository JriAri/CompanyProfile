<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h1 class="fw-bold text-success mb-3">Galeri Kegiatan Penyuluhan</h1>
            <p class="lead text-muted">Dokumentasi kegiatan penyuluhan pertanian dan peternakan</p>
        </div>

        <?php if (empty($galeri)) : ?>
            <div class="alert alert-info text-center">
                Belum ada gambar di galeri.
            </div>
        <?php else : ?>
            <div class="row">
                <?php foreach ($galeri as $item) : ?>
                    <div class="col-md-3 mb-4">
                        <div class="card h-100 shadow-sm">
                            <img src="<?= base_url('uploads/galeri/' . $item['gambar']) ?>" 
                                class="card-img-top" 
                                alt="<?= esc($item['judul']) ?>" 
                                style="height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <h6 class="card-title fw-bold text-success"><?= esc($item['judul']) ?></h6>
                                <p class="card-text small"><?= esc($item['deskripsi']) ?></p>
                            </div>
                            <div class="card-footer bg-transparent border-0">
                                <small class="text-muted">
                                    <i class="fas fa-calendar-alt me-1"></i>
                                    <?= date('d M Y', strtotime($item['tanggal'])) ?>
                                </small>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
    .card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
        transition: all 0.3s ease;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    document.querySelectorAll('.gallery-image').forEach(image => {
        image.addEventListener('click', function() {
            const modal = document.createElement('div');
            modal.style.cssText = `
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0,0,0,0.9);
                display: flex;
                align-items: center;
                justify-content: center;
                z-index: 1050;
                cursor: zoom-out;
            `;
            
            const img = document.createElement('img');
            img.src = this.src;
            img.alt = this.alt;
            img.style.cssText = `
                max-width: 90%;
                max-height: 90%;
                object-fit: contain;
            `;
            
            modal.appendChild(img);
            document.body.appendChild(modal);
            
            modal.addEventListener('click', function() {
                document.body.removeChild(modal);
            });
        });
    });
</script>
<?= $this->endSection() ?>