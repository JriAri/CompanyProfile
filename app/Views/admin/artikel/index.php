<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('content') ?>
<div class="p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Kelola Artikel</h4>
        <a href="<?= base_url('admin/artikel/create') ?>" class="btn btn-success">
            <i class="fas fa-plus me-2"></i> Tambah Artikel
        </a>
    </div>

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th>Judul</th>
                            <th>Kategori</th>
                            <th>Tanggal</th>
                            <th>Penulis</th>
                            <th>Status</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($artikels as $i => $artikel) : ?>
                            <tr>
                                <td><?= $i + 1 ?></td>
                                <td><?= $artikel['judul'] ?></td>
                                <td><?= $artikel['kategori_nama'] ?? '-' ?></td>
                                <td><?= date('d/m/Y', strtotime($artikel['tanggal'])) ?></td>
                                <td><?= $artikel['penulis'] ?></td>
                                <td>
                                    <span class="badge <?= $artikel['status'] == 'published' ? 'bg-success' : 'bg-secondary' ?>">
                                        <?= $artikel['status'] == 'published' ? 'Published' : 'Draft' ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="<?= base_url('admin/artikel/edit/' . $artikel['id']) ?>" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="<?= base_url('admin/artikel/delete/' . $artikel['id']) ?>" method="POST" class="d-inline">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                <?= $pager->links() ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>