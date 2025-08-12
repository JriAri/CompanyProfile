<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">Tambah Galeri Baru</h5>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('admin/galeri/simpan') ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        
                        <div class="mb-3">
                            <label for="judul" class="form-label">Judul</label>
                            <input type="text" class="form-control <?= session('errors.judul') ? 'is-invalid' : '' ?>" 
                                   id="judul" name="judul" required>
                            <?php if (session('errors.judul')): ?>
                                <div class="invalid-feedback">
                                    <?= session('errors.judul') ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi (Opsional)</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="gambar" class="form-label">Gambar</label>
                            <input class="form-control <?= session('errors.gambar') ? 'is-invalid' : '' ?>" 
                                   type="file" id="gambar" name="gambar" required>
                            <?php if (session('errors.gambar')): ?>
                                <div class="invalid-feedback">
                                    <?= session('errors.gambar') ?>
                                </div>
                            <?php endif; ?>
                            <small class="form-text text-muted">Format: JPG, JPEG, PNG. Maksimal 2MB.</small>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="<?= base_url('admin/galeri') ?>" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>