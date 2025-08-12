<?php

namespace App\Controllers;

use App\Models\PenyuluhModel;

class Penyuluh extends BaseController
{
    protected $penyuluhModel;
    
    public function __construct()
    {
        $this->penyuluhModel = new PenyuluhModel();
    }
    
    public function index()
    {
        $wilayah = $this->request->getGet('wilayah');
        $spesialisasi = $this->request->getGet('spesialisasi');
        $keyword = $this->request->getGet('search');
        
        if ($keyword || $wilayah || $spesialisasi) {
            $penyuluh = $this->penyuluhModel->searchPenyuluh($keyword, $wilayah, $spesialisasi);
        } else {
            $penyuluh = $this->penyuluhModel->getPenyuluhByWilayah();
        }
        
        $data = [
            'title' => 'Daftar Penyuluh - AgriConnect',
            'meta_description' => 'Temukan penyuluh pertanian dan peternakan terpercaya di wilayah Anda',
            'penyuluh' => $penyuluh,
            'wilayah_kerja' => $this->penyuluhModel->getWilayahKerja(),
            'statistik' => $this->penyuluhModel->getStatistik(),
            'filter' => [
                'wilayah' => $wilayah,
                'spesialisasi' => $spesialisasi,
                'keyword' => $keyword
            ]
        ];
        
        return view('penyuluh/index', $data);
    }
    
    public function detail($id)
    {
        $penyuluh = $this->penyuluhModel->find($id);
        
        if (!$penyuluh || $penyuluh['status'] !== 'aktif') {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        
        $whatsapp_number = $penyuluh['phone'] ?? '';
        $penyuluh['whatsapp_formatted'] = $this->penyuluhModel->formatWhatsApp($whatsapp_number);
        
        $penyuluh_wilayah = $this->penyuluhModel->getPenyuluhByWilayah($penyuluh['wilayah_kerja']);
        $penyuluh_lain = array_filter($penyuluh_wilayah, function($p) use ($id) {
            return $p['id'] != $id;
        });
        $penyuluh_lain = array_slice($penyuluh_lain, 0, 3);
        
        $data = [
            'title' => $penyuluh['nama'] . ' - Penyuluh ' . ucfirst($penyuluh['spesialisasi']),
            'meta_description' => 'Konsultasi dengan ' . $penyuluh['nama'] . ', penyuluh ' . $penyuluh['spesialisasi'] . ' berpengalaman di ' . $penyuluh['wilayah_kerja'],
            'penyuluh' => $penyuluh,
            'penyuluh_lain' => $penyuluh_lain
        ];
        
        return view('penyuluh/detail', $data);
    }
    
    public function getByWilayah()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['error' => 'Invalid request']);
        }
        
        $wilayah = $this->request->getPost('wilayah');
        $penyuluh = $this->penyuluhModel->getPenyuluhByWilayah($wilayah);
        
        return $this->response->setJSON([
            'success' => true,
            'data' => $penyuluh
        ]);
    }
    
    public function whatsapp($id)
    {
        $penyuluh = $this->penyuluhModel->find($id);
        
        if (!$penyuluh) {
            return redirect()->back()->with('error', 'Penyuluh tidak ditemukan');
        }

        $phone = $penyuluh['phone'];
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        if (substr($phone, 0, 1) === '0') {
            $phone = '62' . substr($phone, 1);
        }

        $message = "Halo, saya ingin berkonsultasi mengenai pertanian/peternakan...";
        $url = "https://api.whatsapp.com/send?phone={$phone}&text=" . urlencode($message);

        return redirect()->to($url);
    }
}