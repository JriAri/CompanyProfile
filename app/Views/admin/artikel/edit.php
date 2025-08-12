<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('content') ?>
<div class="p-4">
    <h4 class="mb-4">Edit Artikel</h4>

    <?php if (session('validation')) : ?>
    <div class="alert alert-danger">
        <?= session('validation')->listErrors() ?>
    </div>
<?php endif; ?>

    <form action="<?= base_url('admin/artikel/update/' . $artikel['id']) ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <input type="hidden" name="_method" value="PUT">
        
        <div class="row">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="judul" class="form-label">Judul Artikel <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="judul" name="judul" value="<?= old('judul', $artikel['judul']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="slug" class="form-label">Slug <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="slug" name="slug" value="<?= old('slug', $artikel['slug']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="ringkasan" class="form-label">Ringkasan <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="ringkasan" name="ringkasan" rows="3" required><?= old('ringkasan', $artikel['ringkasan']) ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="konten" class="form-label">Konten <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="konten" name="konten" rows="10" required><?= old('konten', $artikel['konten']) ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="penulis_id" class="form-label">Penulis <span class="text-danger">*</span></label>
                            <select class="form-select" id="penulis_id" name="penulis_id" required>
                                <option value="">Pilih Penyuluh</option>
                                <?php foreach ($penyuluhList as $penyuluh) : ?>
                                    <option value="<?= $penyuluh['id'] ?>" 
                                        <?= (old('penulis_id', $artikel['penulis_id'] ?? '') == $penyuluh['id']) ? 'selected' : '' ?>>
                                        <?= $penyuluh['nama'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="kategori_id" class="form-label">Kategori <span class="text-danger">*</span></label>
                            <select class="form-select" id="kategori_id" name="kategori_id" required>
                                <option value="">Pilih Kategori</option>
                                <?php foreach ($kategoris as $kategori) : ?>
                                    <option value="<?= $kategori['id'] ?>" <?= old('kategori_id', $artikel['kategori_id']) == $kategori['id'] ? 'selected' : '' ?>>
                                        <?= $kategori['nama'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="draft" <?= old('status', $artikel['status']) == 'draft' ? 'selected' : '' ?>>Draft</option>
                                <option value="published" <?= old('status', $artikel['status']) == 'published' ? 'selected' : '' ?>>Published</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="gambar" class="form-label">Gambar Utama</label>
                            <input class="form-control" type="file" id="gambar" name="gambar">
                            <small class="text-muted">Biarkan kosong jika tidak ingin mengganti</small>
                            
                            <?php if ($artikel['gambar']) : ?>
                                <div class="mt-2">
                                    <img src="<?= base_url('uploads/artikel/' . $artikel['gambar']) ?>" alt="Gambar Artikel" class="img-thumbnail" width="150">
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3">
                            <label for="meta_keywords" class="form-label">Keywords (SEO)</label>
                            <textarea class="form-control" id="meta_keywords" name="meta_keywords" rows="3"><?= old('meta_keywords', $artikel['meta_keywords']) ?></textarea>
                            <small class="text-muted">Pisahkan dengan koma</small>
                        </div>
                    </div>
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Update Artikel</button>
                </div>
            </div>
        </div>
    </form>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    document.getElementById('judul').addEventListener('input', function() {
        const title = this.value;
        const slug = title.toLowerCase()
            .replace(/ /g, '-')
            .replace(/[^\w-]+/g, '');
        document.getElementById('slug').value = slug;
    });
</script>
<?= $this->endSection() ?>