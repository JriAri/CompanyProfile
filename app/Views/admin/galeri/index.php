<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Manajemen Galeri</h5>
                        <div>
                            <a href="<?= base_url('admin/galeri/tambah') ?>" class="btn btn-sm btn-success">
                                <i class="fas fa-plus me-1"></i> Tambah
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <?php if(session('success')): ?>
                        <div class="alert alert-success">
                            <?= session('success') ?>
                        </div>
                    <?php endif; ?>
                    <?php if(session('error')): ?>
                        <div class="alert alert-danger">
                            <?= session('error') ?>
                        </div>
                    <?php endif; ?>
                    
                    <div class="row">
                        <?php foreach ($galeri as $item): ?>
                        <div class="col-md-3 mb-4">
                            <div class="card">
                                <img src="<?= base_url('uploads/galeri/' . $item['gambar']) ?>" class="card-img-top" alt="<?= esc($item['judul']) ?>">
                                <div class="card-body">
                                    <h6 class="card-title"><?= esc($item['judul']) ?></h6>
                                    <p class="card-text small"><?= esc($item['deskripsi']) ?></p>
                                    <div class="d-flex justify-content-between">
                                        <small class="text-muted"><?= date('d M Y', strtotime($item['tanggal'])) ?></small>
                                        <div>
                                            <a href="<?= base_url('admin/galeri/edit/' . $item['id']) ?>" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button class="btn btn-sm btn-danger delete-btn" data-id="<?= $item['id'] ?>">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Hapus Galeri</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus gambar ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="deleteForm" method="post">
                    <?= csrf_field() ?>
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->section('scripts') ?>
<script>
    $(document).ready(function() {
        $('.delete-btn').click(function() {
            const id = $(this).data('id');
            $('#deleteForm').attr('action', `<?= base_url('admin/galeri') ?>/${id}`);
            $('#deleteModal').modal('show');
        });
    });
</script>
<?= $this->endSection() ?>

<?= $this->endSection() ?>