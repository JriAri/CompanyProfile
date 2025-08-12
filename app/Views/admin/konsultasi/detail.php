<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Detail Konsultasi</h5>
                        <div>
                            <span class="badge bg-<?= 
                                ($consultation['status'] == 'pending') ? 'warning' : 
                                (($consultation['status'] == 'answered') ? 'success' : 'secondary') 
                            ?>">
                                <?= ucfirst($consultation['status']) ?>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nama</label>
                                <p class="form-control-static"><?= esc($consultation['nama']) ?></p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Wilayah</label>
                                <p class="form-control-static"><?= esc($consultation['wilayah']) ?></p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <p class="form-control-static"><?= esc($consultation['email']) ?></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nomor Tiket</label>
                                <p class="form-control-static"><?= esc($consultation['tiket']) ?></p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tanggal Konsultasi</label>
                                <p class="form-control-static"><?= date('d M Y H:i', strtotime($consultation['created_at'])) ?></p>
                            </div>
                            <?php if ($consultation['status'] == 'answered'): ?>
                                <div class="mb-3">
                                    <label class="form-label">Tanggal Dijawab</label>
                                    <p class="form-control-static"><?= date('d M Y H:i', strtotime($consultation['tanggal_dijawab'])) ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Pesan</label>
                        <div class="border p-3 rounded bg-light">
                            <?= nl2br(esc($consultation['pesan'])) ?>
                        </div>
                    </div>

                    <?php if ($consultation['status'] == 'answered'): ?>
                        <div class="mb-4">
                            <label class="form-label">Jawaban</label>
                            <div class="border p-3 rounded bg-light">
                                <?= nl2br(esc($consultation['jawaban'])) ?>
                            </div>
                            <?php if (!empty($consultation['penyuluh_id'])): ?>
                                <div class="mt-2">
                                    <span class="text-muted">Dijawab oleh: 
                                        <?= esc($consultation['nama_penyuluh'] ?? 'Penyuluh') ?>
                                    </span>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($consultation['status'] == 'pending'): ?>
                        <form method="post" action="<?= base_url('admin/konsultasi/jawab/' . $consultation['id']) ?>">
                            <?= csrf_field() ?>
                            <div class="mb-3">
                                <label for="jawaban" class="form-label">Jawaban</label>
                                <textarea class="form-control" id="jawaban" name="jawaban" rows="5" required></textarea>
                            </div>
                            
                            <?php if (!empty($consultation['penyuluh_id'])): ?>
                                <div class="mb-3">
                                    <label class="form-label">Penyuluh Penanggung Jawab</label>
                                    <?php if (!empty($consultation['penyuluh_id']) && !empty($penyuluh)): ?>
                                        <div class="mb-3">
                                            <p class="form-control-static">
                                                <?= esc($penyuluh['nama']) ?> (<?= esc($penyuluh['spesialisasi'] ?? '') ?>)
                                            </p>
                                            <input type="hidden" name="penyuluh_id" value="<?= $consultation['penyuluh_id'] ?>">
                                        </div>
                                    <?php else: ?>
                                        <div class="alert alert-warning">
                                            <i class="fas fa-exclamation-triangle me-2"></i>
                                            Belum ada penyuluh yang ditugaskan untuk konsultasi ini
                                        </div>
                                    <?php endif; ?>
                                    <input type="hidden" name="penyuluh_id" value="<?= $consultation['penyuluh_id'] ?>">
                                </div>
                            <?php else: ?>
                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    Belum ada penyuluh yang ditugaskan untuk konsultasi ini
                                </div>
                            <?php endif; ?>
                            
                            <button type="submit" class="btn btn-success">Kirim Jawaban</button>
                        </form>
                    <?php else: ?>
                        <div class="d-flex justify-content-end">
                            <form method="post" action="<?= base_url('admin/konsultasi/updateStatus/' . $consultation['id']) ?>">
                                <?= csrf_field() ?>
                                <input type="hidden" name="status" value="closed">
                                <button type="submit" class="btn btn-secondary me-2">Tutup Konsultasi</button>
                            </form>
                            <form method="post" action="<?= base_url('admin/konsultasi/delete/' . $consultation['id']) ?>">
                                <?= csrf_field() ?>
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>