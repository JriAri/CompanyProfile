<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<section class="hero-consultation bg-success bg-gradient text-white py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-5 fw-bold mb-3">Konsultasi Gratis</h1>
                <p class="lead mb-4">Dapatkan solusi terbaik untuk masalah pertanian dan peternakan Anda dari para penyuluh ahli berpengalaman di wilayah Anda.</p>
                <div class="d-flex align-items-center text-white-50">
                    <i class="fas fa-check-circle me-2"></i>
                    <span class="me-4">Konsultasi Gratis</span>
                    <i class="fas fa-user-tie me-2"></i>
                    <span class="me-4">Penyuluh Bersertifikat</span>
                    <i class="fas fa-clock me-2"></i>
                    <span>Respon Cepat</span>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <img src="<?= base_url('uploads/penyuluh.png') ?>" 
                     alt="Konsultasi Pertanian" class="img-fluid rounded-3 " style="max-height: 350px;">
            </div>
        </div>
    </div>
</section>

<?php if (session()->getFlashdata('success')): ?>
<div class="alert alert-success alert-dismissible fade show m-0" role="alert">
    <div class="container">
        <i class="fas fa-check-circle me-2"></i>
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
</div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
<div class="alert alert-danger alert-dismissible fade show m-0" role="alert">
    <div class="container">
        <i class="fas fa-exclamation-circle me-2"></i>
        <?= session()->getFlashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
</div>
<?php endif; ?>

<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-success text-white text-center py-4">
                        <h3 class="mb-0">
                            <i class="fas fa-comments me-2"></i>
                            Formulir Konsultasi
                        </h3>
                        <p class="mb-0 mt-2 opacity-75">Isi formulir di bawah untuk mendapatkan konsultasi gratis dari penyuluh di wilayah Anda</p>
                    </div>
                    <div class="card-body p-5">
                        <?= form_open('/konsultasi/kirim', ['class' => 'consultation-form']) ?>
                            
                            <div class="mb-4">
                                <label for="nama" class="form-label fw-bold">
                                    <i class="fas fa-user text-success me-2"></i>Nama Lengkap
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control form-control-lg <?= isset($errors['nama']) ? 'is-invalid' : '' ?>" 
                                       id="nama" 
                                       name="nama" 
                                       value="<?= old('nama') ?>"
                                       placeholder="Masukkan nama lengkap Anda"
                                       required>
                                <?php if (isset($errors['nama'])): ?>
                                    <div class="invalid-feedback"><?= $errors['nama'] ?></div>
                                <?php endif; ?>
                            </div>

                            <div class="mb-4">
                                <label for="email" class="form-label fw-bold">
                                    <i class="fas fa-envelope text-success me-2"></i>Email
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="email" 
                                    class="form-control form-control-lg <?= isset($errors['email']) ? 'is-invalid' : '' ?>" 
                                    id="email" 
                                    name="email" 
                                    value="<?= old('email') ?>"
                                    placeholder="Contoh: example@mail.com"
                                    required>
                                <?php if (isset($errors['email'])): ?>
                                    <div class="invalid-feedback"><?= $errors['email'] ?></div>
                                <?php endif; ?>
                            </div>

                            <div class="mb-4">
                                <label for="phone" class="form-label fw-bold">
                                    <i class="fas fa-phone text-success me-2"></i>Nomor Telepon
                                    <small class="text-muted">(Opsional)</small>
                                </label>
                                <input type="tel" 
                                       class="form-control form-control-lg <?= isset($errors['phone']) ? 'is-invalid' : '' ?>" 
                                       id="phone" 
                                       name="phone" 
                                       value="<?= old('phone') ?>"
                                       placeholder="Contoh: 081234567890">
                                <?php if (isset($errors['phone'])): ?>
                                    <div class="invalid-feedback"><?= $errors['phone'] ?></div>
                                <?php endif; ?>
                            </div>

                            <div class="mb-4">
                                <label for="wilayah" class="form-label fw-bold">
                                    <i class="fas fa-map-marker-alt text-success me-2"></i>Wilayah
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-select form-select-lg <?= isset($errors['wilayah']) ? 'is-invalid' : '' ?>" 
                                        id="wilayah" 
                                        name="wilayah" 
                                        required>
                                    <option value="">Pilih Wilayah Anda</option>
                                    <?php if (!empty($wilayah)): ?>
                                        <?php foreach ($wilayah as $key => $value): ?>
                                            <option value="<?= esc($key) ?>" <?= old('wilayah') == $key ? 'selected' : '' ?>>
                                                <?= esc($value) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <option value="" disabled>Belum ada penyuluh terdaftar</option>
                                    <?php endif; ?>
                                </select>
                                <?php if (isset($errors['wilayah'])): ?>
                                    <div class="invalid-feedback"><?= $errors['wilayah'] ?></div>
                                <?php endif; ?>
                                <div class="form-text">
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Konsultasi akan ditangani oleh penyuluh di wilayah yang Anda pilih
                                    </small>
                                </div>
                            </div>

                            <div id="penyuluh-info" class="mb-4" style="display: none;">
                                <div class="alert alert-info border-0">
                                    <h6 class="alert-heading mb-2">
                                        <i class="fas fa-user-tie me-2"></i>Penyuluh di Wilayah Ini
                                    </h6>
                                    <div id="penyuluh-list"></div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="pesan" class="form-label fw-bold">
                                    <i class="fas fa-comment-alt text-success me-2"></i>Pesan Konsultasi
                                    <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control <?= isset($errors['pesan']) ? 'is-invalid' : '' ?>" 
                                          id="pesan" 
                                          name="pesan" 
                                          rows="6"
                                          placeholder="Jelaskan masalah atau pertanyaan Anda dengan detail. Misalnya: jenis tanaman, kendala yang dihadapi, kondisi lahan, dll."
                                          required><?= old('pesan') ?></textarea>
                                <div class="form-text">
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Minimal 10 karakter. Semakin detail informasi yang Anda berikan, semakin tepat solusi yang kami berikan.
                                    </small>
                                </div>
                                <?php if (isset($errors['pesan'])): ?>
                                    <div class="invalid-feedback"><?= $errors['pesan'] ?></div>
                                <?php endif; ?>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-success btn-lg py-3">
                                    <i class="fas fa-paper-plane me-2"></i>
                                    Kirim Konsultasi
                                </button>
                            </div>

                        <?= form_close() ?>

                        <div class="row mt-4 pt-4 border-top">
                            <div class="col-md-4 text-center mb-3">
                                <i class="fas fa-clock text-success fa-2x mb-2"></i>
                                <h6 class="fw-bold">Respon Cepat</h6>
                                <small class="text-muted">Dalam 24 jam</small>
                            </div>
                            <div class="col-md-4 text-center mb-3">
                                <i class="fas fa-user-graduate text-success fa-2x mb-2"></i>
                                <h6 class="fw-bold">Penyuluh Ahli</h6>
                                <small class="text-muted">Berpengalaman & Bersertifikat</small>
                            </div>
                            <div class="col-md-4 text-center mb-3">
                                <i class="fas fa-shield-alt text-success fa-2x mb-2"></i>
                                <h6 class="fw-bold">100% Gratis</h6>
                                <small class="text-muted">Tidak ada biaya tersembunyi</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php if (!empty($wilayah)): ?>
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold text-success">Jangkauan Layanan</h2>
            <p class="lead text-muted">Kami melayani <?= count($wilayah) ?> wilayah dengan penyuluh berpengalaman</p>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card border-0 shadow-sm text-center h-100">
                    <div class="card-body p-4">
                        <i class="fas fa-map-marked-alt text-success fa-3x mb-3"></i>
                        <h4 class="fw-bold text-success"><?= count($wilayah) ?></h4>
                        <h6 class="fw-bold">Wilayah Terlayani</h6>
                        <small class="text-muted">Kecamatan di seluruh Indonesia</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card border-0 shadow-sm text-center h-100">
                    <div class="card-body p-4">
                        <i class="fas fa-users text-success fa-3x mb-3"></i>
                        <h4 class="fw-bold text-success"><?= count($penyuluh_tersedia) ?></h4>
                        <h6 class="fw-bold">Penyuluh Aktif</h6>
                        <small class="text-muted">Siap membantu petani & peternak</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card border-0 shadow-sm text-center h-100">
                    <div class="card-body p-4">
                        <i class="fas fa-comments text-success fa-3x mb-3"></i>
                        <h4 class="fw-bold text-success"><?= count($testimoni) ?>+</h4>
                        <h6 class="fw-bold">Konsultasi Selesai</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if (!empty($penyuluh_tersedia)): ?>
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold text-success">Tim Penyuluh Kami</h2>
            <p class="lead text-muted">Para ahli yang siap membantu menyelesaikan masalah pertanian dan peternakan Anda</p>
        </div>
        <div class="row">
            <?php foreach (array_slice($penyuluh_tersedia, 0, 8) as $penyuluh): ?>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card border-0 shadow-sm text-center h-100">
                    <div class="card-body p-4">
                        <img src="<?= base_url('uploads/penyuluh/' . ($penyuluh['foto'] ?? 'default-penyuluh.jpg')) ?>" 
                             alt="<?= esc($penyuluh['nama']) ?>" 
                             class="rounded-circle mb-3" 
                             style="width: 80px; height: 80px; object-fit: cover;">
                        <h6 class="fw-bold"><?= esc($penyuluh['nama']) ?></h6>
                        <small class="text-muted d-block mb-2">
                            <i class="fas fa-briefcase me-1"></i>
                            <?= esc($penyuluh['spesialisasi'] ?? 'Pertanian Umum') ?>
                        </small>
                        <small class="text-muted d-block mb-2">
                            <i class="fas fa-map-marker-alt me-1"></i>
                            <?= esc($penyuluh['wilayah_kerja']) ?>
                        </small>
                        <div class="mt-2">
                            <small class="badge bg-success">
                                <i class="fas fa-award me-1"></i>
                                <?= esc($penyuluh['pengalaman'] ?? '5+') ?> Tahun
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php if (count($penyuluh_tersedia) > 8): ?>
        <div class="text-center mt-4">
            <p class="text-muted">Dan <?= count($penyuluh_tersedia) - 8 ?> penyuluh lainnya siap membantu Anda</p>
        </div>
        <?php endif; ?>
    </div>
</section>
<?php endif; ?>

<style>
.hero-consultation {
    background: linear-gradient(135deg, #28a745, #20c997);
    min-height: 60vh;
}

.consultation-form .form-control:focus,
.consultation-form .form-select:focus {
    border-color: #28a745;
    box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
}

.card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important;
}

#penyuluh-info .alert {
    background: linear-gradient(45deg, #e3f2fd, #f3e5f5);
    border: 1px solid #90caf9;
}

.penyuluh-item {
    padding: 8px 12px;
    margin: 4px 0;
    background: rgba(255, 255, 255, 0.8);
    border-radius: 6px;
    border-left: 3px solid #28a745;
}

.penyuluh-item.clickable {
    cursor: pointer;
    transition: all 0.2s ease;
}

.penyuluh-item.clickable:hover {
    background: rgba(40, 167, 69, 0.1);
    transform: translateX(5px);
}

.penyuluh-item.selected {
    background: rgba(40, 167, 69, 0.15);
    border-left-color: #28a745;
    border-left-width: 4px;
}

.select-indicator {
    text-align: center;
    margin-top: 8px;
    font-size: 12px;
}

@media (max-width: 768px) {
    .hero-consultation {
        min-height: 50vh;
    }
    
    .card-body.p-5 {
        padding: 2rem !important;
    }
}
</style>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const penyuluhByWilayah = <?= json_encode($penyuluh_by_wilayah ?? []) ?>;
    
    const wilayahSelect = document.getElementById('wilayah');
    const penyuluhInfo = document.getElementById('penyuluh-info');
    const penyuluhList = document.getElementById('penyuluh-list');
    const pesanTextarea = document.getElementById('pesan');
    
    wilayahSelect.addEventListener('change', function() {
        const selectedWilayah = this.value;
        
        if (selectedWilayah && penyuluhByWilayah[selectedWilayah]) {
            const penyuluhData = penyuluhByWilayah[selectedWilayah];
            let html = '';
            
            penyuluhData.forEach(function(penyuluh) {
                html += `
                    <div class="penyuluh-item clickable" data-penyuluh-id="${penyuluh.id}">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <strong>${penyuluh.nama}</strong>
                                <br><small class="text-muted">${penyuluh.spesialisasi}</small>
                            </div>
                            <div class="text-end">
                                <small><i class="fas fa-phone text-success"></i> ${penyuluh.phone}</small>
                            </div>
                        </div>
                        <div class="select-indicator" style="display: none;">
                            <i class="fas fa-check-circle text-success"></i> Dipilih
                        </div>
                    </div>
                `;
            });
            
            penyuluhList.innerHTML = html;
            penyuluhInfo.style.display = 'block';
            
            document.querySelectorAll('.penyuluh-item.clickable').forEach(item => {
                item.addEventListener('click', function() {
                    const penyuluhId = this.getAttribute('data-penyuluh-id');
                    selectPenyuluh(penyuluhId);
                });
            });
            
        } else {
            penyuluhInfo.style.display = 'none';
        }
    });

    function selectPenyuluh(penyuluhId) {
        console.log('Selecting penyuluh:', penyuluhId);
        
        document.querySelectorAll('.penyuluh-item').forEach(item => {
            item.classList.remove('selected');
            const indicator = item.querySelector('.select-indicator');
            if (indicator) indicator.style.display = 'none';
        });
        
        const selectedItem = document.querySelector(`[data-penyuluh-id="${penyuluhId}"]`);
        if (selectedItem) {
            selectedItem.classList.add('selected');
            const indicator = selectedItem.querySelector('.select-indicator');
            if (indicator) indicator.style.display = 'block';
        }
        
        let hiddenInput = document.getElementById('selected_penyuluh_id');
        if (!hiddenInput) {
            hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.id = 'selected_penyuluh_id';
            hiddenInput.name = 'penyuluh_id';
            document.querySelector('.consultation-form').appendChild(hiddenInput);
        }
        hiddenInput.value = penyuluhId;
        
        console.log('Hidden input value:', hiddenInput.value);
    }

    const maxLength = 1000;
    
    if (pesanTextarea) {
        const counterDiv = document.createElement('div');
        counterDiv.className = 'text-end mt-1';
        counterDiv.innerHTML = `<small class="text-muted"><span id="char-count">0</span>/${maxLength}</small>`;
        pesanTextarea.parentNode.appendChild(counterDiv);
        
        const charCount = document.getElementById('char-count');
        
        pesanTextarea.addEventListener('input', function() {
            const currentLength = this.value.length;
            charCount.textContent = currentLength;
            
            if (currentLength > maxLength * 0.9) {
                charCount.parentNode.classList.remove('text-muted');
                charCount.parentNode.classList.add('text-warning');
            } else if (currentLength >= maxLength) {
                charCount.parentNode.classList.remove('text-warning', 'text-muted');
                charCount.parentNode.classList.add('text-danger');
            } else {
                charCount.parentNode.classList.remove('text-warning', 'text-danger');
                charCount.parentNode.classList.add('text-muted');
            }
        });
        
        pesanTextarea.dispatchEvent(new Event('input'));
    }

    const form = document.querySelector('.consultation-form');
    if (form) {
        form.addEventListener('submit', function(e) {
            const nama = document.getElementById('nama').value.trim();
            const wilayah = document.getElementById('wilayah').value;
            const pesan = document.getElementById('pesan').value.trim();
            const email = document.getElementById('email').value.trim();
            const phone = document.getElementById('phone').value.trim();
            
            if (nama.length < 3) {
                e.preventDefault();
                alert('Nama minimal 3 karakter.');
                document.getElementById('nama').focus();
                return;
            }
            
            if (!wilayah) {
                e.preventDefault();
                alert('Silakan pilih wilayah Anda.');
                document.getElementById('wilayah').focus();
                return;
            }

            const selectedPenyuluhId = document.getElementById('selected_penyuluh_id')?.value;

            if (!selectedPenyuluhId) {
                e.preventDefault();
                alert('Silakan pilih salah satu penyuluh yang tersedia.');
                return;
            }
            
            if (pesan.length < 10) {
                e.preventDefault();
                alert('Pesan konsultasi minimal 10 karakter.');
                document.getElementById('pesan').focus();
                return;
            }
            
            if (pesan.length > maxLength) {
                e.preventDefault();
                alert(`Pesan konsultasi maksimal ${maxLength} karakter.`);
                document.getElementById('pesan').focus();
                return;
            }
            
            if (email && !isValidEmail(email)) {
                e.preventDefault();
                alert('Format email tidak valid.');
                document.getElementById('email').focus();
                return;
            }
            
            if (phone && !isValidPhone(phone)) {
                e.preventDefault();
                alert('Format nomor telepon tidak valid. Contoh: 081234567890');
                document.getElementById('phone').focus();
                return;
            }
            
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mengirim Konsultasi...';
            submitBtn.disabled = true;
            
            setTimeout(() => {
                if (submitBtn.disabled) {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                }
            }, 10000);
        });
    }

    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }
    
    function isValidPhone(phone) {
        const phoneRegex = /^(\+62|62|0)[0-9]{8,13}$/;
        return phoneRegex.test(phone.replace(/[\s\-]/g, ''));
    }

    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            if (alert.classList.contains('show')) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }
        }, 5000);
    });

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
});
</script>
<?= $this->endSection() ?>

<?= $this->endSection() ?>