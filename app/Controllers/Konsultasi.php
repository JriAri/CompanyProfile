<?php

namespace App\Controllers;

use App\Models\ConsultationModel;
use App\Models\PenyuluhModel;

class Konsultasi extends BaseController
{
    protected $consultationModel;
    protected $penyuluhModel;

    public function __construct()
    {
        $this->consultationModel = new ConsultationModel();
        $this->penyuluhModel = new PenyuluhModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Konsultasi - AgriConnect',
            'meta_description' => 'Dapatkan konsultasi gratis dari penyuluh ahli pertanian dan peternakan terpercaya.',
            'wilayah' => $this->getWilayahFromPenyuluh(),
            'penyuluh_tersedia' => $this->penyuluhModel->getPenyuluhByWilayah(),
            'testimoni' => $this->consultationModel->getTestimoni(5),
            'penyuluh_by_wilayah' => $this->getPenyuluhGroupedByWilayah()
        ];

        return view('konsultasi/index', $data);
    }

    public function kirim()
    {
        $validation = \Config\Services::validation();
        
        $validation->setRules([
            'nama' => 'required|min_length[3]|max_length[100]',
            'wilayah' => 'required',
            'pesan' => 'required|min_length[10]|max_length[1000]',
            'email' => 'required|valid_email',
        ]);

        $input = $this->request->getPost();

        if (!$validation->run($input)) {
            return redirect()->back()
                           ->withInput()
                           ->with('errors', $validation->getErrors());
        }

        $tiket = 'TKT-' . date('Ymd') . '-' . strtoupper(substr(md5(uniqid(rand(), true)), 0, 6));

        $penyuluhTerpilih = $this->penyuluhModel->getPenyuluhByWilayah($this->request->getPost('wilayah'));
        $penyuluh_id = !empty($penyuluhTerpilih) ? $penyuluhTerpilih[0]['id'] : null;

        $consultationData = [
            'nama' => $this->request->getPost('nama'),
            'wilayah' => $this->request->getPost('wilayah'),
            'pesan' => $this->request->getPost('pesan'),
            'email' => $this->request->getPost('email'),
            'penyuluh_id' => $penyuluh_id,
            'status' => 'pending',
            'tiket' => $tiket,
            'created_at' => date('Y-m-d H:i:s')
        ];

        $consultationId = $this->consultationModel->insert($consultationData);

        if ($consultationId) {
            $this->sendEmailNotification($consultationData, $penyuluhTerpilih[0] ?? null, $tiket);

            return redirect()->to('/konsultasi/tracking?tiket=' . $tiket)
                           ->with('success', 'Konsultasi berhasil dikirim! Nomor tiket Anda: ' . $tiket);
        } else {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Terjadi kesalahan. Silakan coba lagi.');
        }
    }

    public function tracking()
    {
        $tiket = $this->request->getGet('tiket');
        
        if (!$tiket) {
            return view('konsultasi/tracking_form', [
                'title' => 'Lacak Konsultasi - AgriConnect'
            ]);
        }
        
        $konsultasi = $this->consultationModel->where('tiket', $tiket)->first();
        
        if (!$konsultasi) {
            return redirect()->to('/konsultasi/tracking')
                           ->with('error', 'Tiket tidak ditemukan. Silakan cek kembali.');
        }
        
        $penyuluh = null;
        if ($konsultasi['penyuluh_id']) {
            $penyuluh = $this->penyuluhModel->find($konsultasi['penyuluh_id']);
        }
        
        $data = [
            'title' => 'Detail Konsultasi - AgriConnect',
            'konsultasi' => $konsultasi,
            'penyuluh' => $penyuluh
        ];
        
        return view('konsultasi/tracking_detail', $data);
    }

    private function sendEmailNotification($data, $penyuluh = null, $tiket)
    {
        $email = \Config\Services::email();
        
        $this->sendUserConfirmationEmail($email, $data, $tiket);
        
        if ($penyuluh && !empty($penyuluh['email'])) {
            $this->sendPenyuluhNotificationEmail($email, $data, $penyuluh, $tiket);
        }
    }

    private function sendUserConfirmationEmail($email, $data, $tiket)
    {
        $email->setTo($data['email']);
        $email->setFrom('noreply@agriconnect.id', 'AgriConnect Indonesia');
        $email->setSubject('✅ Konsultasi Anda Telah Diterima - Tiket #' . $tiket);
        
        $message = $this->buildUserEmailTemplate($data, $tiket);
        
        $email->setMessage($message);
        
        if (!$email->send()) {
            log_message('error', 'Failed to send confirmation email to user: ' . $data['email']);
        }
    }

    private function sendPenyuluhNotificationEmail($email, $data, $penyuluh, $tiket)
    {
        $email->clear();
        
        $email->setTo($penyuluh['email']);
        $email->setFrom('system@agriconnect.id', 'AgriConnect System');
        $email->setSubject('🔔 Konsultasi Baru Menunggu Respons - Tiket #' . $tiket);
        
        $message = $this->buildPenyuluhEmailTemplate($data, $penyuluh, $tiket);
        
        $email->setMessage($message);
        
        if (!$email->send()) {
            log_message('error', 'Failed to send notification email to penyuluh: ' . $penyuluh['email']);
        }
    }

    private function buildUserEmailTemplate($data, $tiket)
    {
        $trackingUrl = base_url('/konsultasi/tracking?tiket=' . $tiket);
        $currentDate = date('d F Y, H:i');
        
        $template = "
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset='UTF-8'>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .header { background: #2E7D32; color: white; padding: 20px; text-align: center; border-radius: 8px 8px 0 0; }
            .content { background: #f9f9f9; padding: 30px; border-radius: 0 0 8px 8px; }
            .info-box { background: white; padding: 20px; margin: 20px 0; border-radius: 8px; border-left: 4px solid #4CAF50; }
            .button { display: inline-block; background: #4CAF50; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; margin: 20px 0; }
            .footer { text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #ddd; color: #666; font-size: 12px; }
            .status-badge { background: #FFC107; color: #000; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: bold; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h1>🌾 AgriConnect Indonesia</h1>
                <p>Konsultasi Pertanian Terpercaya</p>
            </div>
            
            <div class='content'>
                <h2>Konsultasi Berhasil Diterima!</h2>
                
                <p>Halo <strong>{$data['nama']}</strong>,</p>
                
                <p>Terima kasih telah mempercayakan konsultasi pertanian Anda kepada <strong>AgriConnect</strong>. 
                Konsultasi Anda telah berhasil diterima dan akan segera ditangani oleh penyuluh pertanian ahli di wilayah Anda.</p>
                
                <div class='info-box'>
                    <h3>📋 Detail Konsultasi</h3>
                    <table style='width: 100%; border-collapse: collapse;'>
                        <tr><td style='padding: 8px 0; font-weight: bold;'>Nomor Tiket:</td><td style='padding: 8px 0;'><code>{$tiket}</code></td></tr>
                        <tr><td style='padding: 8px 0; font-weight: bold;'>Tanggal Pengajuan:</td><td style='padding: 8px 0;'>{$currentDate} WIB</td></tr>
                        <tr><td style='padding: 8px 0; font-weight: bold;'>Wilayah:</td><td style='padding: 8px 0;'>{$data['wilayah']}</td></tr>
                        <tr><td style='padding: 8px 0; font-weight: bold;'>Status:</td><td style='padding: 8px 0;'><span class='status-badge'>PENDING</span></td></tr>
                    </table>
                </div>
                
                <div class='info-box'>
                    <h3>💬 Pesan Konsultasi</h3>
                    <p style='background: #fff; padding: 15px; border-radius: 5px; border: 1px solid #ddd;'>" . nl2br(htmlspecialchars($data['pesan'])) . "</p>
                </div>
                
                <div style='text-align: center; margin: 30px 0;'>
                    <a href='{$trackingUrl}' class='button'>🔍 Lacak Status Konsultasi</a>
                </div>
                
                <div class='info-box'>
                    <h3>⏱️ Estimasi Waktu Respons</h3>
                    <p>Penyuluh kami akan merespons konsultasi Anda dalam waktu <strong>1-2 hari kerja</strong>. 
                    Anda akan menerima notifikasi email ketika ada update terbaru.</p>
                </div>
                
                <div class='info-box'>
                    <h3>📞 Butuh Bantuan Lebih Lanjut?</h3>
                    <p>Jika Anda memiliki pertanyaan mengenai konsultasi ini, silakan hubungi kami:</p>
                    <ul>
                        <li>📧 Email: support@agriconnect.id</li>
                        <li>📱 WhatsApp: +62 812-3456-7890</li>
                        <li>🌐 Website: www.agriconnect.id</li>
                    </ul>
                </div>
            </div>
            
            <div class='footer'>
                <p><strong>AgriConnect Indonesia</strong></p>
                <p>Memajukan Pertanian Indonesia Melalui Teknologi Digital</p>
                <p>Email ini dikirim secara otomatis, mohon tidak membalas langsung ke email ini.</p>
            </div>
        </div>
    </body>
    </html>";

        return $template;
    }

    private function buildPenyuluhEmailTemplate($data, $penyuluh, $tiket)
    {
        $dashboardUrl = base_url('/admin/konsultasi');
        $currentDate = date('d F Y, H:i');
        
        $template = "
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset='UTF-8'>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .header { background: #1976D2; color: white; padding: 20px; text-align: center; border-radius: 8px 8px 0 0; }
            .content { background: #f9f9f9; padding: 30px; border-radius: 0 0 8px 8px; }
            .info-box { background: white; padding: 20px; margin: 20px 0; border-radius: 8px; border-left: 4px solid #2196F3; }
            .urgent-box { background: #FFF3E0; padding: 20px; margin: 20px 0; border-radius: 8px; border-left: 4px solid #FF9800; }
            .button { display: inline-block; background: #2196F3; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; margin: 20px 0; }
            .footer { text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #ddd; color: #666; font-size: 12px; }
            .priority-high { background: #F44336; color: white; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: bold; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h1>🌾 AgriConnect - Penyuluh Dashboard</h1>
                <p>Konsultasi Baru Menunggu Respons Anda</p>
            </div>
            
            <div class='content'>
                <h2>Konsultasi Baru Diterima</h2>
                
                <p>Halo <strong>{$penyuluh['nama']}</strong>,</p>
                
                <p>Selamat! Anda menerima konsultasi baru dari petani di wilayah <strong>{$data['wilayah']}</strong>. 
                Mohon segera memberikan respons terbaik untuk membantu petani tersebut.</p>
                
                <div class='urgent-box'>
                    <h3>⚡ Status: <span class='priority-high'>BUTUH RESPONS</span></h3>
                    <p>Konsultasi ini membutuhkan respons dalam <strong>24 jam</strong> untuk menjaga kualitas layanan AgriConnect.</p>
                </div>
                
                <div class='info-box'>
                    <h3>📋 Detail Konsultasi</h3>
                    <table style='width: 100%; border-collapse: collapse;'>
                        <tr><td style='padding: 8px 0; font-weight: bold;'>Nomor Tiket:</td><td style='padding: 8px 0;'><code>{$tiket}</code></td></tr>
                        <tr><td style='padding: 8px 0; font-weight: bold;'>Tanggal Diterima:</td><td style='padding: 8px 0;'>{$currentDate} WIB</td></tr>
                        <tr><td style='padding: 8px 0; font-weight: bold;'>Nama Petani:</td><td style='padding: 8px 0;'>{$data['nama']}</td></tr>
                        <tr><td style='padding: 8px 0; font-weight: bold;'>Email:</td><td style='padding: 8px 0;'>{$data['email']}</td></tr>
                        <tr><td style='padding: 8px 0; font-weight: bold;'>Wilayah:</td><td style='padding: 8px 0;'>{$data['wilayah']}</td></tr>
                    </table>
                </div>
                
                <div class='info-box'>
                    <h3>💬 Pesan Konsultasi</h3>
                    <p style='background: #fff; padding: 15px; border-radius: 5px; border: 1px solid #ddd;'>" . nl2br(htmlspecialchars($data['pesan'])) . "</p>
                </div>
                
                <div style='text-align: center; margin: 30px 0;'>
                    <a href='{$dashboardUrl}' class='button'>📝 Buka Dashboard & Balas Konsultasi</a>
                </div>
                
                <div class='info-box'>
                    <h3>📊 Tips Memberikan Respons Berkualitas</h3>
                    <ul>
                        <li>Baca pesan konsultasi dengan teliti</li>
                        <li>Berikan solusi yang spesifik dan actionable</li>
                        <li>Sertakan referensi atau sumber jika diperlukan</li>
                        <li>Gunakan bahasa yang mudah dipahami petani</li>
                        <li>Tanyakan detail tambahan jika perlu</li>
                    </ul>
                </div>
            </div>
            
            <div class='footer'>
                <p><strong>AgriConnect Indonesia - Penyuluh System</strong></p>
                <p>Terima kasih atas dedikasi Anda dalam memajukan pertanian Indonesia</p>
                <p>Email ini dikirim secara otomatis dari sistem AgriConnect.</p>
            </div>
        </div>
    </body>
    </html>";

        return $template;
    }

    private function getWilayahFromPenyuluh()
    {
        $penyuluhAktif = $this->penyuluhModel->where('status', 'aktif')->findAll();
        $wilayahList = [];

        foreach ($penyuluhAktif as $penyuluh) {
            $wilayah = $penyuluh['wilayah_kerja'];
            if (!empty($wilayah) && !isset($wilayahList[$wilayah])) {
                $wilayahList[$wilayah] = $wilayah;
            }
        }

        asort($wilayahList);
        
        return $wilayahList;
    }

    private function getPenyuluhGroupedByWilayah()
    {
        $penyuluhAktif = $this->penyuluhModel->where('status', 'aktif')->findAll();
        $grouped = [];

        foreach ($penyuluhAktif as $penyuluh) {
            $wilayah = $penyuluh['wilayah_kerja'];
            if (!isset($grouped[$wilayah])) {
                $grouped[$wilayah] = [];
            }
            $grouped[$wilayah][] = [
                'id' => $penyuluh['id'],
                'nama' => $penyuluh['nama'],
                'spesialisasi' => $penyuluh['spesialisasi'],
                'phone' => $penyuluh['phone']
            ];
        }

        return $grouped;
    }

    public function getPenyuluhByWilayahAPI()
    {
        $wilayah = $this->request->getGet('wilayah');
        
        if (!$wilayah) {
            return $this->response->setJSON(['error' => 'Wilayah tidak ditemukan']);
        }

        $penyuluh = $this->penyuluhModel->getPenyuluhByWilayah($wilayah);
        
        return $this->response->setJSON([
            'success' => true,
            'data' => $penyuluh
        ]);
    }

    private function sendNotification($data, $penyuluh = null)
    {
        $message = "Konsultasi baru diterima dari: " . $data['nama'] . 
                  " (Wilayah: " . $data['wilayah'] . ")";
        
        if ($penyuluh) {
            $message .= " - Ditugaskan ke: " . $penyuluh['nama'];
        }
        
        log_message('info', $message);
        
        if ($penyuluh && !empty($penyuluh['phone'])) {
            $this->sendWhatsAppNotification($penyuluh['phone'], $data);
        }
    }

    private function sendWhatsAppNotification($phone, $consultationData)
    {
        $message = "🌾 *KONSULTASI BARU - AgriConnect*\n\n";
        $message .= "Nama: " . $consultationData['nama'] . "\n";
        $message .= "Wilayah: " . $consultationData['wilayah'] . "\n";
        $message .= "Pesan: " . substr($consultationData['pesan'], 0, 100) . "...\n\n";
        $message .= "Segera cek dashboard untuk memberikan jawaban!";
        
        log_message('info', 'WhatsApp notification sent to: ' . $phone);
    }

    public function riwayat()
    {
        $data = [
            'title' => 'Riwayat Konsultasi - AgriConnect',
            'konsultasi' => []
        ];

        return view('konsultasi/riwayat', $data);
    }

    public function admin()
    {
        if (!session()->get('is_admin')) {
            return redirect()->to('/login');
        }

        $data = [
            'title' => 'Kelola Konsultasi - Admin',
            'konsultasi_pending' => $this->consultationModel->getKonsultasiWithPenyuluh('pending'),
            'konsultasi_answered' => $this->consultationModel->getKonsultasiWithPenyuluh('answered'),
            'statistik' => $this->consultationModel->getStatistikKonsultasi(),
            'penyuluh_list' => $this->penyuluhModel->where('status', 'aktif')->findAll()
        ];

        return view('admin/konsultasi', $data);
    }
}