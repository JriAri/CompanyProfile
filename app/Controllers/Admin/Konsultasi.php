<?php namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ConsultationModel;
use App\Models\PenyuluhModel;

class Konsultasi extends BaseController
{
    protected $consultationModel;
    protected $penyuluhModel;

    public function __construct()
    {
        $this->consultationModel = new ConsultationModel();
        $this->penyuluhModel     = new PenyuluhModel();
    }

    public function index()
    {
        $status = $this->request->getGet('status') ?? 'pending';

        $pending  = $this->consultationModel->where('status', 'pending')->orderBy('created_at', 'DESC')->findAll();
        $answered = $this->consultationModel->where('status', 'answered')->orderBy('created_at', 'DESC')->findAll();
        $closed   = $this->consultationModel->where('status', 'closed')->orderBy('created_at', 'DESC')->findAll();

        $data = [
            'title'     => 'Manajemen Konsultasi',
            'active'    => 'konsultasi',
            'pending'   => $pending,
            'answered'  => $answered,
            'closed'    => $closed,
            'status'    => $status,
            'stats'     => $this->consultationModel->getStatistikKonsultasi(),
            'nama'      => session()->get('nama'),
            'role'      => session()->get('role')
        ];

        return view('admin/konsultasi/index', $data);
    }

    public function detail($id)
    {
        $consultation = $this->consultationModel->find($id);

        if (!$consultation) {
            return redirect()->back()->with('error', 'Konsultasi tidak ditemukan');
        }

        $penyuluhTersedia = $this->consultationModel->getPenyuluhTersedia();
        $penyuluh         = !empty($consultation['penyuluh_id']) 
                          ? $this->penyuluhModel->find($consultation['penyuluh_id']) 
                          : null;

        $data = [
            'title'             => 'Detail Konsultasi',
            'active'            => 'konsultasi',
            'consultation'      => $consultation,
            'penyuluhTersedia'  => $penyuluhTersedia,
            'penyuluh'          => $penyuluh,
            'nama'              => session()->get('nama'),
            'role'              => session()->get('role')
        ];

        return view('admin/konsultasi/detail', $data);
    }

    public function jawab($id)
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'jawaban' => 'required|min_length[10]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $consultation = $this->consultationModel->find($id);
        if (!$consultation) {
            return redirect()->back()->with('error', 'Konsultasi tidak ditemukan');
        }

        $data = [
            'jawaban'         => $this->request->getPost('jawaban'),
            'status'          => 'answered',
            'tanggal_dijawab' => date('Y-m-d H:i:s')
        ];

        if ($this->consultationModel->update($id, $data)) {
            $this->sendAnswerNotification($consultation, $data['jawaban']);
            return redirect()->to('admin/konsultasi')->with('success', 'Konsultasi berhasil dijawab');
        }

        return redirect()->back()->with('error', 'Gagal menjawab konsultasi');
    }

    private function sendAnswerNotification($consultation, $jawaban)
    {
        $email = \Config\Services::email();

        $email->setTo($consultation['email']);
        $email->setSubject('Jawaban Konsultasi - Tiket #' . $consultation['tiket']);

        $message  = "Halo " . $consultation['nama'] . ",\n\n";
        $message .= "Konsultasi Anda dengan nomor tiket #" . $consultation['tiket'] . " telah dijawab.\n\n";
        $message .= "Pertanyaan Anda:\n" . $consultation['pesan'] . "\n\n";
        $message .= "Jawaban:\n" . $jawaban . "\n\n";
        $message .= "Anda dapat melihat detail konsultasi di link berikut:\n";
        $message .= base_url('/konsultasi/tracking?tiket=' . $consultation['tiket']) . "\n\n";
        $message .= "Hormat kami,\nTim AgriConnect";

        $email->setMessage($message);
        $email->send();
    }

    public function updateStatus($id)
    {
        $status = $this->request->getPost('status');

        if ($this->consultationModel->update($id, ['status' => $status])) {
            return redirect()->back()->with('success', 'Status berhasil diperbarui');
        }

        return redirect()->back()->with('error', 'Gagal memperbarui status');
    }

    public function delete($id)
    {
        if ($this->consultationModel->delete($id)) {
            return redirect()->to('admin/konsultasi')->with('success', 'Konsultasi berhasil dihapus');
        }

        return redirect()->back()->with('error', 'Gagal menghapus konsultasi');
    }
}