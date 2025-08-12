<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">Tambah Toko Baru</h5>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('admin/belanja/simpan') ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nama_toko" class="form-label">Nama Toko</label>
                                    <input type="text" class="form-control <?= session('errors.nama_toko') ? 'is-invalid' : '' ?>" 
                                           id="nama_toko" name="nama_toko" required>
                                    <?php if (session('errors.nama_toko')): ?>
                                        <div class="invalid-feedback">
                                            <?= session('errors.nama_toko') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="mb-3">
                                    <label for="jenis_toko" class="form-label">Jenis Toko</label>
                                    <select class="form-select <?= session('errors.jenis_toko') ? 'is-invalid' : '' ?>" 
                                            id="jenis_toko" name="jenis_toko" required>
                                        <option value="">Pilih Jenis Toko</option>
                                        <?php foreach ($kategori as $kat): ?>
                                            <option value="<?= esc($kat['jenis_toko']) ?>" <?= set_select('jenis_toko', $kat['jenis_toko']) ?>>
                                                <?= esc($kat['label']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?php if (session('errors.jenis_toko')): ?>
                                        <div class="invalid-feedback">
                                            <?= session('errors.jenis_toko') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="mb-3">
                                    <label for="alamat" class="form-label">Alamat</label>
                                    <textarea class="form-control <?= session('errors.alamat') ? 'is-invalid' : '' ?>" 
                                              id="alamat" name="alamat" rows="3" required></textarea>
                                    <?php if (session('errors.alamat')): ?>
                                        <div class="invalid-feedback">
                                            <?= session('errors.alamat') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="mb-3">
                                    <label for="telepon" class="form-label">Telepon</label>
                                    <input type="text" class="form-control <?= session('errors.telepon') ? 'is-invalid' : '' ?>" 
                                           id="telepon" name="telepon" required>
                                    <?php if (session('errors.telepon')): ?>
                                        <div class="invalid-feedback">
                                            <?= session('errors.telepon') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="deskripsi" class="form-label">Deskripsi (Opsional)</label>
                                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="link_gmaps" class="form-label">Link Google Maps (Opsional)</label>
                                    <input type="url" class="form-control" 
                                        id="link_gmaps" name="link_gmaps"
                                        placeholder="https://maps.app.goo.gl/...">
                                    <small class="form-text text-muted">Contoh: https://goo.gl/maps/AbCdEfGhIjKlMnOp</small>
                                </div>
                                <div class="mb-3">
                                    <label for="gambar" class="form-label">Gambar Toko</label>
                                    <input class="form-control <?= session('errors.gambar') ? 'is-invalid' : '' ?>" 
                                           type="file" id="gambar" name="gambar" required>
                                    <?php if (session('errors.gambar')): ?>
                                        <div class="invalid-feedback">
                                            <?= session('errors.gambar') ?>
                                        </div>
                                    <?php endif; ?>
                                    <small class="form-text text-muted">Format: JPG, JPEG, PNG. Maksimal 2MB.</small>
                                </div>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="<?= base_url('admin/belanja') ?>" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>