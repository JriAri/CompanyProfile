<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">Edit Galeri</h5>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('admin/galeri/update/' . $galeri['id']) ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        <input type="hidden" name="_method" value="PUT">
                        
                        <div class="mb-3">
                            <label for="judul" class="form-label">Judul</label>
                            <input type="text" class="form-control <?= session('errors.judul') ? 'is-invalid' : '' ?>" 
                                   id="judul" name="judul" value="<?= esc($galeri['judul']) ?>" required>
                            <?php if (session('errors.judul')): ?>
                                <div class="invalid-feedback">
                                    <?= session('errors.judul') ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi (Opsional)</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"><?= esc($galeri['deskripsi']) ?></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="gambar" class="form-label">Gambar</label>
                            <div class="mb-2">
                                <img src="<?= base_url('uploads/galeri/' . $galeri['gambar']) ?>" alt="Preview" class="img-thumbnail" style="max-height: 200px;">
                            </div>
                            <input class="form-control <?= session('errors.gambar') ? 'is-invalid' : '' ?>" 
                                   type="file" id="gambar" name="gambar">
                            <?php if (session('errors.gambar')): ?>
                                <div class="invalid-feedback">
                                    <?= session('errors.gambar') ?>
                                </div>
                            <?php endif; ?>
                            <small class="form-text text-muted">Biarkan kosong jika tidak ingin mengganti gambar. Format: JPG, JPEG, PNG. Maksimal 2MB.</small>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Perbarui</button>
                        <a href="<?= base_url('admin/galeri') ?>" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>