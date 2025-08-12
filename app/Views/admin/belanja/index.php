<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Manajemen Toko Pertanian</h5>
                        <div>
                            <a href="<?= base_url('admin/belanja/tambah') ?>" class="btn btn-sm btn-success">
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
                    
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Gambar</th>
                                    <th>Nama Toko</th>
                                    <th>Jenis Toko</th>
                                    <th>Alamat</th>
                                    <th>Link Maps</th>
                                    <th>Telepon</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($toko as $index => $item): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td>
                                        <?php if ($item['gambar']): ?>
                                            <img src="<?= base_url('uploads/toko/' . $item['gambar']) ?>" alt="Gambar Toko" width="60">
                                        <?php else: ?>
                                            <div class="bg-secondary text-center p-2" style="width:60px;">
                                                <i class="fas fa-store text-light"></i>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= esc($item['nama_toko']) ?></td>
                                    <td><?= esc($item['jenis_toko']) ?></td>
                                    <td><?= esc(substr($item['alamat'], 0, 30)) . (strlen($item['alamat']) > 30 ? '...' : '') ?></td>
                                    <td>
                                        <?php if ($item['link_gmaps']): ?>
                                            <a href="<?= esc($item['link_gmaps']) ?>" target="_blank" class="btn btn-sm btn-info">
                                                <i class="fas fa-map-marked-alt"></i> Lihat
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= esc($item['telepon']) ?></td>
                                    <td>
                                        <a href="<?= base_url('admin/belanja/edit/' . $item['id']) ?>" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button class="btn btn-sm btn-danger delete-btn" data-id="<?= $item['id'] ?>">
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
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Hapus Toko</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus toko ini?
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
            $('#deleteForm').attr('action', `<?= base_url('admin/belanja') ?>/${id}`);
            $('#deleteModal').modal('show');
        });
    });
</script>
<?= $this->endSection() ?>

<?= $this->endSection() ?>