<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'AgriConsult - Platform Pertanian Indonesia' ?></title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-green: #28a745;
            --secondary-green: #20c997;
            --light-green: #d4edda;
            --dark-green: #155724;
        }

        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            color: #333;
        }

        .navbar {
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            background-color: white !important;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--primary-green) !important;
        }

        .navbar-nav .nav-link {
            font-weight: 500;
            color: #333 !important;
            transition: color 0.3s ease;
        }

        .navbar-nav .nav-link:hover {
            color: var(--primary-green) !important;
        }

        .hero-section {
            min-height: 70vh;
        }

        .icon-circle {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
        }

        .btn-outline-success {
            border-color: var(--primary-green);
            color: var(--primary-green);
        }

        .btn-outline-success:hover {
            background-color: var(--primary-green);
            border-color: var(--primary-green);
        }

        .text-success {
            color: var(--primary-green) !important;
        }

        .bg-success {
            background-color: var(--primary-green) !important;
        }

        .btn-success {
            background-color: var(--primary-green);
            border-color: var(--primary-green);
        }

        .btn-success:hover {
            background-color: var(--dark-green);
            border-color: var(--dark-green);
        }

        footer {
            background-color: var(--dark-green);
        }

        .footer-link {
            color: #ccc;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer-link:hover {
            color: var(--secondary-green);
        }

        @media (max-width: 768px) {
            .hero-section {
                min-height: 50vh;
            }
            
            .display-4 {
                font-size: 2rem;
            }
        }
    </style>
    
    <?= $this->renderSection('additional_css') ?>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top bg-white">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url() ?>">
                <i class="fas fa-seedling me-2"></i>AgriConsult
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url() ?>">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('konsultasi') ?>">Konsultasi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('artikel') ?>">Artikel</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('penyuluh') ?>">Penyuluh</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('galeri') ?>">Galeri</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('belanja') ?>">Belanja</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('diskusi') ?>">Diskusi</a>
                    </li>
                </ul>
                
                <div class="d-flex">
                    <a href="<?= base_url('kontak') ?>" class="btn btn-outline-success me-2">Kontak</a>
                    <a href="<?= base_url('admin') ?>" class="btn btn-success">Admin</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main style="margin-top: 76px;">
        <?= $this->renderSection('content') ?>
    </main>

    <!-- Footer -->
    <footer class="text-white py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <h5 class="mb-3">
                        <i class="fas fa-seedling me-2"></i>AgriConsult
                    </h5>
                    <p class="text-light">
                        Platform konsultasi dan informasi terpercaya untuk petani dan peternak Indonesia. 
                        Memberikan solusi terbaik untuk kemajuan sektor pertanian.
                    </p>
                    <div class="d-flex gap-3">
                        <a href="#" class="footer-link"><i class="fab fa-facebook fa-lg"></i></a>
                        <a href="#" class="footer-link"><i class="fab fa-twitter fa-lg"></i></a>
                        <a href="#" class="footer-link"><i class="fab fa-instagram fa-lg"></i></a>
                        <a href="#" class="footer-link"><i class="fab fa-youtube fa-lg"></i></a>
                    </div>
                </div>
                
                <div class="col-lg-2 col-md-6">
                    <h6 class="mb-3">Layanan</h6>
                    <ul class="list-unstyled">
                        <li><a href="<?= base_url('konsultasi') ?>" class="footer-link">Konsultasi</a></li>
                        <li><a href="<?= base_url('artikel') ?>" class="footer-link">Artikel</a></li>
                        <li><a href="<?= base_url('penyuluh') ?>" class="footer-link">Penyuluh</a></li>
                        <li><a href="<?= base_url('galeri') ?>" class="footer-link">Galeri</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-2 col-md-6">
                    <h6 class="mb-3">Lainnya</h6>
                    <ul class="list-unstyled">
                        <li><a href="<?= base_url('belanja') ?>" class="footer-link">Belanja</a></li>
                        <li><a href="<?= base_url('diskusi') ?>" class="footer-link">Diskusi</a></li>
                        <li><a href="<?= base_url('kontak') ?>" class="footer-link">Kontak</a></li>
                        <li><a href="<?= base_url('tentang') ?>" class="footer-link">Tentang Kami</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-4">
                    <h6 class="mb-3">Kontak Info</h6>
                    <div class="d-flex mb-2">
                        <i class="fas fa-map-marker-alt me-3 mt-1"></i>
                        <span class="text-light">Jl. Pertanian No. 123, Jakarta, Indonesia</span>
                    </div>
                    <div class="d-flex mb-2">
                        <i class="fas fa-phone me-3 mt-1"></i>
                        <span class="text-light">+62 21 123 4567</span>
                    </div>
                    <div class="d-flex mb-2">
                        <i class="fas fa-envelope me-3 mt-1"></i>
                        <span class="text-light">info@agriconsult.id</span>
                    </div>
                    <div class="d-flex">
                        <i class="fas fa-clock me-3 mt-1"></i>
                        <span class="text-light">Senin - Jumat: 08:00 - 17:00</span>
                    </div>
                </div>
            </div>
            
            <hr class="my-4 border-secondary">
            
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="mb-0 text-light">
                        &copy; <?= date('Y') ?> AgriConsult. Semua hak cipta dilindungi.
                    </p>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="#" class="footer-link me-3">Privacy Policy</a>
                    <a href="#" class="footer-link">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script>
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 100) {
                navbar.style.backgroundColor = 'rgba(255, 255, 255, 0.95)';
                navbar.style.backdropFilter = 'blur(10px)';
            } else {
                navbar.style.backgroundColor = 'white';
                navbar.style.backdropFilter = 'none';
            }
        });
    </script>
    
    <?= $this->renderSection('additional_js') ?>
</body>
</html>