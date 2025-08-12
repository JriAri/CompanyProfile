<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Manajemen Penyuluh</h5>
                        <div>
                            <a href="<?= base_url('admin/penyuluh/tambah') ?>" class="btn btn-sm btn-success">
                                <i class="fas fa-plus me-1"></i> Tambah
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Foto</th>
                                    <th>Nama</th>
                                    <th>Spesialisasi</th>
                                    <th>Wilayah Kerja</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($penyuluh as $index => $row): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td>
                                        <?php if ($row['foto']): ?>
                                            <img src="<?= base_url('uploads/penyuluh/' . $row['foto']) ?>" alt="Foto Penyuluh" class="rounded-circle" width="40" height="40">
                                        <?php else: ?>
                                            <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center" style="width:40px;height:40px;">
                                                <i class="fas fa-user text-light"></i>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= esc($row['nama']) ?></td>
                                    <td><?= esc($row['spesialisasi']) ?></td>
                                    <td><?= esc($row['wilayah_kerja']) ?></td>
                                    <td>
                                        <span class="badge bg-<?= $row['status'] == 'aktif' ? 'success' : 'danger' ?>">
                                            <?= ucfirst($row['status']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="<?= base_url('admin/penyuluh/edit/' . $row['id']) ?>" 
                                           class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button class="btn btn-danger btn-sm delete-btn" data-id="<?= $row['id'] ?>">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">Statistik Penyuluh</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <div class="stat-card card border-0 shadow-sm">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h5 class="text-muted">Total Penyuluh</h5>
                                            <h3><?= $stats['total_penyuluh'] ?></h3>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="fas fa-users fa-2x text-success"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="stat-card card border-0 shadow-sm">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h5 class="text-muted">Pertanian</h5>
                                            <h3><?= $stats['penyuluh_pertanian'] ?></h3>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="fas fa-seedling fa-2x text-success"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="stat-card card border-0 shadow-sm">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h5 class="text-muted">Peternakan</h5>
                                            <h3><?= $stats['penyuluh_peternakan'] ?></h3>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="fas fa-cow fa-2x text-success"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="stat-card card border-0 shadow-sm">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h5 class="text-muted">Wilayah Kerja</h5>
                                            <h3><?= $stats['total_wilayah'] ?></h3>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="fas fa-map-marker-alt fa-2x text-info"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Delete -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="post" id="deleteForm">
      <?= csrf_field() ?>
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Konfirmasi Hapus</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          Yakin ingin menghapus data ini?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-danger">Hapus</button>
        </div>
      </div>
    </form>
  </div>
</div>

<?= $this->section('scripts') ?>
<script>
    $(document).ready(function() {
        $('.delete-btn').click(function() {
            const id = $(this).data('id');
            
            $('#deleteForm').attr('action', `<?= base_url('admin/penyuluh/hapus') ?>/${id}`);
            
            $('#deleteModal').modal('show');
        });
    });
</script>
<?= $this->endSection() ?>

<?= $this->endSection() ?>