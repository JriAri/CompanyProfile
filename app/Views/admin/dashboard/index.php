<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('content') ?>
<div class="p-4">
    <h4 class="mb-4">Dashboard Admin</h4>
    
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm stat-card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="text-uppercase text-muted">Artikel</h6>
                            <h3 class="fw-bold mb-0">245</h3>
                        </div>
                        <div class="bg-success rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 55px; height: 55px;">
                            <i class="fas fa-newspaper fa-2x text-white"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="text-success fw-bold"><i class="fas fa-arrow-up me-1"></i> 12.5%</span>
                        <span class="text-muted ms-2">dari bulan lalu</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm stat-card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="text-uppercase text-muted">Konsultasi</h6>
                            <h3 class="fw-bold mb-0">89</h3>
                        </div>
                        <div class="bg-success rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 55px; height: 55px;">
                            <i class="fas fa-comments fa-2x text-white"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="text-success fw-bold"><i class="fas fa-arrow-up me-1"></i> 8.3%</span>
                        <span class="text-muted ms-2">dari bulan lalu</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm stat-card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="text-uppercase text-muted">Penyuluh</h6>
                            <h3 class="fw-bold mb-0">24</h3>
                        </div>
                        <div class="bg-success rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 55px; height: 55px;">
                            <i class="fas fa-user-tie fa-2x text-white"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="text-success fw-bold"><i class="fas fa-arrow-up me-1"></i> 4.3%</span>
                        <span class="text-muted ms-2">dari bulan lalu</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm stat-card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="text-uppercase text-muted">Anggota</h6>
                            <h3 class="fw-bold mb-0">1.250</h3>
                        </div>
                        <div class="bg-success rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 55px; height: 55px;">
                            <i class="fas fa-users fa-2x text-white"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="text-success fw-bold"><i class="fas fa-arrow-up me-1"></i> 18.7%</span>
                        <span class="text-muted ms-2">dari bulan lalu</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0">
                    <h6 class="fw-bold mb-0">Statistik Pengunjung</h6>
                </div>
                <div class="card-body">
                    <canvas id="visitorChart" style="height: 300px;"></canvas>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0">
                    <h6 class="fw-bold mb-0">Aktivitas Terbaru</h6>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <a href="#" class="list-group-item list-group-item-action border-0">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">Admin menambahkan artikel baru</h6>
                                <small class="text-muted">2 menit lalu</small>
                            </div>
                            <p class="mb-1 small text-muted">"Cara Budidaya Padi Organik Modern"</p>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action border-0">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">Petani mengajukan konsultasi</h6>
                                <small class="text-muted">15 menit lalu</small>
                            </div>
                            <p class="mb-1 small text-muted">Permasalahan hama pada tanaman jagung</p>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action border-0">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">Penyuluh baru bergabung</h6>
                                <small class="text-muted">1 jam lalu</small>
                            </div>
                            <p class="mb-1 small text-muted">Dr. Ahmad Fauzi, S.Pt., M.Si</p>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action border-0">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">Produk baru ditambahkan</h6>
                                <small class="text-muted">3 jam lalu</small>
                            </div>
                            <p class="mb-1 small text-muted">Pupuk Organik Super 5kg</p>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action border-0">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">Diskusi baru dimulai</h6>
                                <small class="text-muted">5 jam lalu</small>
                            </div>
                            <p class="mb-1 small text-muted">"Teknologi Pertanian Modern 2025"</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('visitorChart').getContext('2d');
        const visitorChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
                datasets: [{
                    label: 'Pengunjung',
                    data: [1200, 1900, 1500, 2200, 1800, 2500, 3000],
                    borderColor: '#28a745',
                    backgroundColor: 'rgba(40, 167, 69, 0.1)',
                    borderWidth: 2,
                    tension: 0.3,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            drawBorder: false
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    });
</script>
<?= $this->endSection() ?>