<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <?php if (session('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <?= session('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">Edit Penyuluh: <?= esc($penyuluh['nama']) ?></h5>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('admin/penyuluh/update/' . $penyuluh['id']) ?>" method="post" enctype="multipart/form-data" id="formPenyuluh">
                        <?= csrf_field() ?>
                        <input type="hidden" id="penyuluhId" value="<?= $penyuluh['id'] ?>">
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control <?= session('errors.nama') ? 'is-invalid' : '' ?>" 
                                           id="nama" name="nama" value="<?= old('nama', $penyuluh['nama']) ?>" required>
                                    <?php if (session('errors.nama')): ?>
                                        <div class="invalid-feedback">
                                            <i class="fas fa-exclamation-circle me-1"></i><?= session('errors.nama') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control <?= session('errors.email') ? 'is-invalid' : '' ?>" 
                                           id="email" name="email" value="<?= old('email', $penyuluh['email']) ?>" required>
                                    <div id="emailFeedback" class="invalid-feedback" style="display: none;">
                                        <i class="fas fa-exclamation-circle me-1"></i><span id="emailMessage"></span>
                                    </div>
                                    <?php if (session('errors.email')): ?>
                                        <div class="invalid-feedback">
                                            <i class="fas fa-exclamation-circle me-1"></i><?= session('errors.email') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="mb-3">
                                    <label for="phone" class="form-label">Nomor Telepon/WhatsApp</label>
                                    <input type="text" class="form-control <?= session('errors.phone') ? 'is-invalid' : '' ?>" 
                                           id="phone" name="phone" value="<?= old('phone', $penyuluh['phone']) ?>" required>
                                    <div id="phoneFeedback" class="invalid-feedback" style="display: none;">
                                        <i class="fas fa-exclamation-circle me-1"></i><span id="phoneMessage"></span>
                                    </div>
                                    <?php if (session('errors.phone')): ?>
                                        <div class="invalid-feedback">
                                            <i class="fas fa-exclamation-circle me-1"></i><?= session('errors.phone') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="mb-3">
                                    <label for="spesialisasi" class="form-label">Spesialisasi</label>
                                    <select class="form-select <?= session('errors.spesialisasi') ? 'is-invalid' : '' ?>" 
                                            id="spesialisasi" name="spesialisasi" required>
                                        <option value="">Pilih Spesialisasi</option>
                                        <option value="pertanian" <?= old('spesialisasi', $penyuluh['spesialisasi']) == 'pertanian' ? 'selected' : '' ?>>Pertanian</option>
                                        <option value="peternakan" <?= old('spesialisasi', $penyuluh['spesialisasi']) == 'peternakan' ? 'selected' : '' ?>>Peternakan</option>
                                        <option value="perikanan" <?= old('spesialisasi', $penyuluh['spesialisasi']) == 'perikanan' ? 'selected' : '' ?>>Perikanan</option>
                                        <option value="kehutanan" <?= old('spesialisasi', $penyuluh['spesialisasi']) == 'kehutanan' ? 'selected' : '' ?>>Kehutanan</option>
                                    </select>
                                    <?php if (session('errors.spesialisasi')): ?>
                                        <div class="invalid-feedback">
                                            <i class="fas fa-exclamation-circle me-1"></i><?= session('errors.spesialisasi') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="wilayah_kerja" class="form-label">Kecamatan</label>
                                    <select class="form-select <?= session('errors.wilayah_kerja') ? 'is-invalid' : '' ?>" 
                                            id="wilayah_kerja" name="wilayah_kerja" required>
                                        <option value="">Pilih Kecamatan</option>
                                        <?php foreach ($wilayahList as $kecamatan): ?>
                                            <option value="<?= esc($kecamatan) ?>" 
                                                <?= old('wilayah_kerja', $penyuluh['wilayah_kerja']) == $kecamatan ? 'selected' : '' ?>>
                                                <?= esc($kecamatan) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <small class="text-muted">Setiap kecamatan hanya boleh memiliki 1 penyuluh aktif</small>
                                    <div id="wilayahFeedback" class="invalid-feedback" style="display: none;">
                                        <i class="fas fa-exclamation-circle me-1"></i><span id="wilayahMessage"></span>
                                    </div>
                                    <?php if (session('errors.wilayah_kerja')): ?>
                                        <div class="invalid-feedback">
                                            <i class="fas fa-exclamation-circle me-1"></i><?= session('errors.wilayah_kerja') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="mb-3">
                                    <label for="pengalaman" class="form-label">Pengalaman (tahun)</label>
                                    <input type="number" class="form-control" 
                                           id="pengalaman" name="pengalaman" value="<?= old('pengalaman', $penyuluh['pengalaman']) ?>" min="0" step="1">
                                </div>

                                <div class="mb-3">
                                    <label for="foto" class="form-label">Foto Profil</label>
                                    <?php if ($penyuluh['foto']): ?>
                                        <div class="mb-2">
                                            <img src="<?= base_url('uploads/penyuluh/' . $penyuluh['foto']) ?>" 
                                                 alt="Foto <?= esc($penyuluh['nama']) ?>" 
                                                 class="img-thumbnail" style="max-width: 100px;">
                                            <small class="text-muted d-block">Foto saat ini</small>
                                        </div>
                                    <?php endif; ?>
                                    <input class="form-control" type="file" id="foto" name="foto" accept="image/*">
                                    <small class="text-muted">Biarkan kosong jika tidak ingin mengubah foto</small>
                                </div>

                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select" id="status" name="status" required>
                                        <option value="aktif" <?= old('status', $penyuluh['status']) == 'aktif' ? 'selected' : '' ?>>Aktif</option>
                                        <option value="nonaktif" <?= old('status', $penyuluh['status']) == 'nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="bio" class="form-label">Biografi Singkat</label>
                            <textarea class="form-control" id="bio" name="bio" rows="4"><?= old('bio', $penyuluh['bio']) ?></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Update
                        </button>
                        <a href="<?= base_url('admin/penyuluh') ?>" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i>Batal
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    let emailTimeout, phoneTimeout, wilayahTimeout;
    const penyuluhId = $('#penyuluhId').val();

    $('#email').on('input', function() {
        clearTimeout(emailTimeout);
        const email = $(this).val();
        
        if (email.length > 0) {
            emailTimeout = setTimeout(function() {
                $.post('<?= base_url('admin/penyuluh/checkEmail') ?>', {
                    email: email,
                    id: penyuluhId,
                    '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
                }, function(response) {
                    const $email = $('#email');
                    const $feedback = $('#emailFeedback');
                    const $message = $('#emailMessage');
                    
                    if (response.taken) {
                        $email.removeClass('is-valid').addClass('is-invalid');
                        $message.text(response.message);
                        $feedback.show();
                    } else {
                        $email.removeClass('is-invalid').addClass('is-valid');
                        $feedback.hide();
                    }
                });
            }, 500);
        }
    });

    $('#phone').on('input', function() {
        clearTimeout(phoneTimeout);
        const phone = $(this).val();
        
        if (phone.length > 0) {
            phoneTimeout = setTimeout(function() {
                $.post('<?= base_url('admin/penyuluh/checkPhone') ?>', {
                    phone: phone,
                    id: penyuluhId,
                    '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
                }, function(response) {
                    const $phone = $('#phone');
                    const $feedback = $('#phoneFeedback');
                    const $message = $('#phoneMessage');
                    
                    if (response.taken) {
                        $phone.removeClass('is-valid').addClass('is-invalid');
                        $message.text(response.message);
                        $feedback.show();
                    } else {
                        $phone.removeClass('is-invalid').addClass('is-valid');
                        $feedback.hide();
                    }
                });
            }, 500);
        }
    });

    function checkWilayah() {
        const wilayah = $('#wilayah_kerja').val();
        const status = $('#status').val();
        
        if (wilayah && status === 'aktif') {
            $.post('<?= base_url('admin/penyuluh/checkWilayah') ?>', {
                wilayah: wilayah,
                status: status,
                id: penyuluhId,
                '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
            }, function(response) {
                const $wilayah = $('#wilayah_kerja');
                const $feedback = $('#wilayahFeedback');
                const $message = $('#wilayahMessage');
                
                if (response.taken) {
                    $wilayah.removeClass('is-valid').addClass('is-invalid');
                    $message.text(response.message);
                    $feedback.show();
                } else {
                    $wilayah.removeClass('is-invalid').addClass('is-valid');
                    $feedback.hide();
                }
            });
        } else {
            $('#wilayah_kerja').removeClass('is-invalid is-valid');
            $('#wilayahFeedback').hide();
        }
    }

    $('#wilayah_kerja, #status').on('change', checkWilayah);

    $('#formPenyuluh').on('submit', function(e) {
        let hasError = false;
        
        if ($(this).find('.is-invalid').length > 0) {
            e.preventDefault();
            hasError = true;
            
            if ($('.alert-danger').length === 0) {
                const alertHtml = `
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Terdapat kesalahan pada form. Silakan perbaiki terlebih dahulu.
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                `;
                $('.container-fluid .row .col-12').prepend(alertHtml);
            }
        }
    });

    setTimeout(function() {
        $('.alert').fadeOut();
    }, 5000);
});
</script>
<?= $this->endSection() ?>