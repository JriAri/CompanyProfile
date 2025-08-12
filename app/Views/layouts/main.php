<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'AgriConnect - Platform Petani & Peternak' ?></title>
    <meta name="description" content="<?= $meta_description ?? 'Platform terpercaya untuk petani dan peternak Indonesia' ?>">
    <meta name="keywords" content="pertanian, peternakan, konsultasi, artikel, penyuluh, galeri">
    <meta name="author" content="AgriConnect">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-green: #28a745;
            --secondary-green: #20c997;
            --dark-green: #1e7e34;
            --light-green: #d4edda;
        }
        
        * {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }
        
        body {
            line-height: 1.6;
            color: #333;
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
        }
        
        .navbar {
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            background-color: white !important;
        }
        
        .nav-link {
            font-weight: 500;
            transition: color 0.3s ease;
        }
        
        .nav-link:hover {
            color: var(--primary-green) !important;
        }
        
        .btn-success {
            background-color: var(--primary-green);
            border-color: var(--primary-green);
        }
        
        .btn-success:hover {
            background-color: var(--dark-green);
            border-color: var(--dark-green);
        }
        
        .text-success {
            color: var(--primary-green) !important;
        }
        
        .bg-success {
            background-color: var(--primary-green) !important;
        }
        
        footer {
            background-color: #2c3e50;
        }
    </style>
    
    <?= $this->renderSection('styles') ?>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
        <div class="container">
            <a class="navbar-brand text-success" href="<?= base_url() ?>">
                <i class="fas fa-seedling me-2"></i>DISTAPANG
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link <?= uri_string() == '' ? 'active text-success fw-bold' : '' ?>" href="<?= base_url('/') ?>">
                            <i class="fas fa-home me-1"></i>Beranda
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= strpos(uri_string(), 'konsultasi') !== false ? 'active text-success fw-bold' : '' ?>" href="<?= base_url('konsultasi') ?>">
                            <i class="fas fa-comments me-1"></i>Konsultasi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= strpos(uri_string(), 'artikel') !== false ? 'active text-success fw-bold' : '' ?>" href="<?= base_url('artikel') ?>">
                            <i class="fas fa-newspaper me-1"></i>Artikel
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= strpos(uri_string(), 'penyuluh') !== false ? 'active text-success fw-bold' : '' ?>" href="<?= base_url('penyuluh') ?>">
                            <i class="fas fa-user-tie me-1"></i>Penyuluh
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= strpos(uri_string(), 'galeri') !== false ? 'active text-success fw-bold' : '' ?>" href="<?= base_url('galeri') ?>">
                            <i class="fas fa-images me-1"></i>Galeri
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= strpos(uri_string(), 'belanja') !== false ? 'active text-success fw-bold' : '' ?>" href="<?= base_url('belanja') ?>">
                            <i class="fas fa-shopping-cart me-1"></i>Toko
                        </a>
                    </li>
                </ul>

                <form class="d-flex" action="<?= base_url('/konsultasi/tracking') ?>" method="get">
                    <div class="input-group">
                    <input type="text" 
                            class="form-control form-control-sm" 
                            name="tiket" 
                            placeholder="Cari tiket konsultasi"
                            aria-label="Nomor Tiket">
                    <button class="btn btn-light" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                    </div>
                </form>
                
            </div>
        </div>
    </nav>

    <main>
        <?= $this->renderSection('content') ?>
    </main>

    <footer class="text-light py-5 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <h5 class="fw-bold mb-3">
                        <i class="fas fa-seedling me-2"></i>AgriConnect
                    </h5>
                    <p class="mb-3">Platform terpercaya yang menghubungkan petani, peternak, dan ahli pertanian untuk berkembang bersama.</p>
                    <div class="d-flex gap-3">
                        <a href="#" class="text-light"><i class="fab fa-facebook-f fa-lg"></i></a>
                        <a href="#" class="text-light"><i class="fab fa-instagram fa-lg"></i></a>
                        <a href="#" class="text-light"><i class="fab fa-twitter fa-lg"></i></a>
                        <a href="#" class="text-light"><i class="fab fa-youtube fa-lg"></i></a>
                    </div>
                </div>
                
                <div class="col-lg-2 col-md-6 mb-4">
                    <h6 class="fw-bold mb-3">Layanan</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="/konsultasi" class="text-light text-decoration-none">Konsultasi</a></li>
                        <li class="mb-2"><a href="/artikel" class="text-light text-decoration-none">Artikel</a></li>
                        <li class="mb-2"><a href="/penyuluh" class="text-light text-decoration-none">Penyuluh</a></li>
                        <li class="mb-2"><a href="/galeri" class="text-light text-decoration-none">Galeri</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-2 col-md-6 mb-4">
                    <h6 class="fw-bold mb-3">Lainnya</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="/belanja" class="text-light text-decoration-none">Belanja</a></li>
                        <li class="mb-2"><a href="/tentang" class="text-light text-decoration-none">Tentang Kami</a></li>
                        <li class="mb-2"><a href="/kontak" class="text-light text-decoration-none">Kontak</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-4 mb-4">
                    <h6 class="fw-bold mb-3">Kontak Kami</h6>
                    <div class="mb-2">
                        <i class="fas fa-map-marker-alt me-2"></i>
                        Jl. Pertanian No. 123, Malang, Jawa Timur 65111
                    </div>
                    <div class="mb-2">
                        <i class="fas fa-phone me-2"></i>
                        <a href="tel:+6281234567890" class="text-light text-decoration-none">+62 812-3456-7890</a>
                    </div>
                    <div class="mb-2">
                        <i class="fas fa-envelope me-2"></i>
                        <a href="mailto:info@agriconnect.id" class="text-light text-decoration-none">info@agriconnect.id</a>
                    </div>
                    <div>
                        <i class="fas fa-clock me-2"></i>
                        Senin - Jumat: 08:00 - 17:00 WIB
                    </div>
                </div>
            </div>
            
            <hr class="my-4">
            
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="mb-0">&copy; <?= date('Y') ?> AgriConnect. Seluruh hak cipta dilindungi.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="/privacy" class="text-light text-decoration-none me-3">Kebijakan Privasi</a>
                    <a href="/terms" class="text-light text-decoration-none">Syarat & Ketentuan</a>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
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

        const backToTopButton = document.createElement('button');
        backToTopButton.innerHTML = '<i class="fas fa-arrow-up"></i>';
        backToTopButton.className = 'btn btn-success rounded-circle position-fixed';
        backToTopButton.style.cssText = `
            bottom: 20px;
            right: 20px;
            width: 50px;
            height: 50px;
            display: none;
            z-index: 1000;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        `;
        backToTopButton.onclick = () => window.scrollTo({ top: 0, behavior: 'smooth' });
        document.body.appendChild(backToTopButton);

        window.addEventListener('scroll', function() {
            if (window.scrollY > 300) {
                backToTopButton.style.display = 'block';
            } else {
                backToTopButton.style.display = 'none';
            }
        });
    </script>
    
    <?= $this->renderSection('scripts') ?>
</body>
</html>