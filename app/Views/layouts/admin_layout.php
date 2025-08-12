<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= csrf_hash() ?>">
    <title><?= $title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-green: #28a745;
            --sidebar-bg: #2c3e50;
            --sidebar-hover: #34495e;
        }
        .sidebar {
            min-height: 100vh;
            background-color: var(--sidebar-bg);
            color: white;
            padding: 0;
            transition: all 0.3s;
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 0.8rem 1rem;
            border-left: 4px solid transparent;
            transition: all 0.3s;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            color: white;
            background-color: var(--sidebar-hover);
            border-left: 4px solid var(--primary-green);
        }
        .sidebar .nav-link i {
            width: 24px;
            margin-right: 10px;
            text-align: center;
        }
        .main-content {
            background-color: #f8f9fa;
            min-height: 100vh;
        }
        .navbar-admin {
            background-color: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            z-index: 100;
        }
        .stat-card {
            border-left: 4px solid var(--primary-green);
            transition: transform 0.3s;
        }
        .stat-card:hover {
            transform: translateY(-5px);
        }
        .user-profile {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--primary-green);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-2 col-md-3 sidebar p-0">
                <div class="p-4 text-center border-bottom">
                    <h5 class="mb-0">AgriConnect Admin</h5>
                    <small class="text-muted">Panel Administrator</small>
                </div>
                <ul class="nav flex-column mt-3">
                    <li class="nav-item">
                        <a class="nav-link <?= ($active == 'dashboard') ? 'active' : '' ?>" href="<?= base_url('admin/dashboard') ?>">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($active == 'artikel') ? 'active' : '' ?>" href="<?= base_url('admin/artikel') ?>">
                            <i class="fas fa-newspaper"></i> Artikel
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($active == 'konsultasi') ? 'active' : '' ?>" href="<?= base_url('admin/konsultasi') ?>">
                            <i class="fas fa-comments"></i> Konsultasi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($active == 'penyuluh') ? 'active' : '' ?>" href="<?= base_url('admin/penyuluh') ?>">
                            <i class="fas fa-user-tie"></i> Penyuluh
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($active == 'galeri') ? 'active' : '' ?>" href="<?= base_url('admin/galeri') ?>">
                            <i class="fas fa-images"></i> Galeri
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($active == 'belanja') ? 'active' : '' ?>" href="<?= base_url('admin/belanja') ?>">
                            <i class="fas fa-shopping-cart"></i> Toko
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($active == 'admin') ? 'active' : '' ?>" href="<?= base_url('admin/admin') ?>">
                            <i class="fas fa-users-cog"></i> Admin
                        </a>
                    </li>
                    <li class="nav-item mt-4">
                        <a class="nav-link" href="<?= base_url('admin/logout') ?>">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                    </li>
                </ul>
            </div>
            
            <div class="col-lg-10 col-md-9 main-content p-0">
                <nav class="navbar navbar-expand-lg navbar-admin">
                    <div class="container-fluid px-4">
                        <button class="btn btn-sm d-md-none" id="sidebarToggle">
                            <i class="fas fa-bars"></i>
                        </button>
                        
                        <div class="d-flex align-items-center">
                            <div class="user-profile me-2">
                                <?= substr($nama, 0, 1) ?>
                            </div>
                            <div>
                                <span class="fw-bold"><?= $nama ?></span>
                                <small class="d-block text-muted"><?= ucfirst($role) ?></small>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-center">
                            <span class="me-3"><?= date('d F Y') ?></span>
                            <div class="dropdown">
                                <button class="btn btn-sm" type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-cog"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i> Profil</a></li>
                                    <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i> Pengaturan</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="<?= base_url('admin/logout') ?>"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>
                
                <?= $this->renderSection('content') ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script>
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('d-none');
        });
    </script>

    <?= $this->renderSection('scripts') ?>
</body>
</html>