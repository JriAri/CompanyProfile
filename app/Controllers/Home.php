<?php

namespace App\Controllers;

use App\Models\HomeModel;

class Home extends BaseController
{
    protected $homeModel;

    public function __construct()
    {
        $this->homeModel = new HomeModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Beranda - DISTAPANG',
            'meta_description' => 'Platform terpercaya untuk petani dan peternak Maluku Barat Daya. Dapatkan konsultasi, artikel, dan panduan terlengkap.',
            'konten_beranda' => $this->homeModel->getBerandaContent(),
            'statistik' => $this->homeModel->getStatistik(),
            'artikel_terbaru' => $this->homeModel->getArtikelTerbaru(3),
            'layanan_utama' => $this->homeModel->getLayananUtama()
        ];

        if (empty($data['konten_beranda'])) {
            $data['konten_beranda'] = [
                'judul_utama' => 'Selamat Datang di Distapang',
                'subjudul' => 'Platform Terpercaya untuk Petani & Peternak Maluku Barat Daya',
                'deskripsi' => 'Dapatkan informasi, konsultasi, dan panduan terlengkap untuk mengembangkan usaha pertanian dan peternakan Anda.',
                'gambar_hero' => 'hero-farming.jpg'
            ];
        }

        return view('home/index', $data);
    }

    public function getArtikelAjax()
    {
        if ($this->request->isAJAX()) {
            $artikel = $this->homeModel->getArtikelTerbaru(6);
            return $this->response->setJSON($artikel);
        }
        
        throw new \CodeIgniter\Exceptions\PageNotFoundException();
    }
}