<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Manajemen Konsultasi</h5>
                        <div>
                            <a href="<?= base_url('admin/konsultasi/export') ?>" class="btn btn-sm btn-outline-success">
                                <i class="fas fa-download me-1"></i> Export
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs mb-4" id="statusTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link <?= ($status == 'pending') ? 'active' : '' ?>" 
                                    data-bs-toggle="tab" data-bs-target="#pending" 
                                    type="button">Pending</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link <?= ($status == 'answered') ? 'active' : '' ?>" 
                                    data-bs-toggle="tab" data-bs-target="#answered" 
                                    type="button">Dijawab</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link <?= ($status == 'closed') ? 'active' : '' ?>" 
                                    data-bs-toggle="tab" data-bs-target="#closed" 
                                    type="button">Ditutup</button>
                        </li>
                    </ul>
                    
                    <div class="tab-content" id="statusTabContent">
                        <div class="tab-pane fade <?= ($status == 'pending') ? 'show active' : '' ?>" id="pending">
                            <?php $pendingConsultations = $pending; ?>
                            <?php if (empty($pendingConsultations)): ?>
                                <div class="alert alert-info">Tidak ada konsultasi yang dijawab</div>
                            <?php else: ?>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nama</th>
                                                <th>Wilayah</th>
                                                <th>Pesan</th>
                                                <th>Tanggal</th>
                                                <th>Tanggal Dijawab</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($pendingConsultations as $index => $consul): ?>
                                            <tr>
                                                <td><?= $index + 1 ?></td>
                                                <td><?= esc($consul['nama']) ?></td>
                                                <td><?= esc($consul['wilayah']) ?></td>
                                                <td><?= esc(substr($consul['pesan'], 0, 50)) . (strlen($consul['pesan']) > 50 ? '...' : '') ?></td>
                                                <td><?= date('d M Y', strtotime($consul['created_at'])) ?></td>
                                                <td><?= date('d M Y', strtotime($consul['tanggal_dijawab'])) ?></td>
                                                <td>
                                                    <a href="<?= base_url('admin/konsultasi/detail/' . $consul['id']) ?>" 
                                                    class="btn btn-sm btn-primary">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <button class="btn btn-sm btn-danger delete-btn" 
                                                            data-id="<?= $consul['id'] ?>">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="tab-pane fade <?= ($status == 'answered') ? 'show active' : '' ?>" id="answered">
                            <?php $answeredConsultations = $answered; ?>
                            <?php if (empty($answeredConsultations)): ?>
                                <div class="alert alert-info">Tidak ada konsultasi yang dijawab</div>
                            <?php else: ?>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nama</th>
                                                <th>Wilayah</th>
                                                <th>Pesan</th>
                                                <th>Tanggal</th>
                                                <th>Tanggal Dijawab</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($answeredConsultations as $index => $consul): ?>
                                            <tr>
                                                <td><?= $index + 1 ?></td>
                                                <td><?= esc($consul['nama']) ?></td>
                                                <td><?= esc($consul['wilayah']) ?></td>
                                                <td><?= esc(substr($consul['pesan'], 0, 50)) . (strlen($consul['pesan']) > 50 ? '...' : '') ?></td>
                                                <td><?= date('d M Y', strtotime($consul['created_at'])) ?></td>
                                                <td><?= date('d M Y', strtotime($consul['tanggal_dijawab'])) ?></td>
                                                <td>
                                                    <a href="<?= base_url('admin/konsultasi/detail/' . $consul['id']) ?>" 
                                                    class="btn btn-sm btn-primary">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <button class="btn btn-sm btn-danger delete-btn" 
                                                            data-id="<?= $consul['id'] ?>">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="tab-pane fade <?= ($status == 'closed') ? 'show active' : '' ?>" id="closed">
                            <?php $aclosedConsultations = $closed; ?>
                            <?php if (empty($closedConsultations)): ?>
                                <div class="alert alert-info">Tidak ada konsultasi yang ditutup</div>
                            <?php else: ?>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nama</th>
                                                <th>Wilayah</th>
                                                <th>Pesan</th>
                                                <th>Tanggal</th>
                                                <th>Tanggal Ditutup</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($closedConsultations as $index => $consul): ?>
                                            <tr>
                                                <td><?= $index + 1 ?></td>
                                                <td><?= esc($consul['nama']) ?></td>
                                                <td><?= esc($consul['wilayah']) ?></td>
                                                <td><?= esc(substr($consul['pesan'], 0, 50)) . (strlen($consul['pesan']) > 50 ? '...' : '') ?></td>
                                                <td><?= date('d M Y', strtotime($consul['created_at'])) ?></td>
                                                <td><?= date('d M Y', strtotime($consul['updated_at'])) ?></td>
                                                <td>
                                                    <a href="<?= base_url('admin/konsultasi/detail/' . $consul['id']) ?>" 
                                                    class="btn btn-sm btn-primary">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <button class="btn btn-sm btn-danger delete-btn" 
                                                            data-id="<?= $consul['id'] ?>">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">Statistik Konsultasi</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <div class="stat-card card border-0 shadow-sm">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h5 class="text-muted">Total</h5>
                                            <h3><?= $stats['total'] ?></h3>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="fas fa-comments fa-2x text-success"></i>
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
                                            <h5 class="text-muted">Pending</h5>
                                            <h3><?= $stats['pending'] ?></h3>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="fas fa-clock fa-2x text-warning"></i>
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
                                            <h5 class="text-muted">Dijawab</h5>
                                            <h3><?= $stats['answered'] ?></h3>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="fas fa-check-circle fa-2x text-success"></i>
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
                                            <h5 class="text-muted">Bulan Ini</h5>
                                            <h3><?= $stats['this_month'] ?></h3>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="fas fa-calendar-alt fa-2x text-info"></i>
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

<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Hapus Konsultasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus konsultasi ini?
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
            $('#deleteForm').attr('action', `<?= base_url('admin/konsultasi') ?>/${id}`);
            $('#deleteModal').modal('show');
        });
        
        $('.nav-link').on('click', function() {
            const status = $(this).text().toLowerCase();
            window.location.href = `<?= base_url('admin/konsultasi') ?>?status=${status}`;
        });
        
        const urlParams = new URLSearchParams(window.location.search);
        const statusParam = urlParams.get('status');
        if (statusParam) {
            $(`.nav-link:contains('${statusParam.charAt(0).toUpperCase() + statusParam.slice(1)}')`).tab('show');
        }
    });
</script>
<?= $this->endSection() ?>

<?= $this->endSection() ?>