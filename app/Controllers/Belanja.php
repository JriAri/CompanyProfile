<?php

namespace App\Controllers;

use App\Models\TokoModel;

class Belanja extends BaseController
{
    protected $tokoModel;

    public function __construct()
    {
        $this->tokoModel = new TokoModel();
    }

    public function index()
    {
        $kategori = $this->request->getGet('kategori');
        
        $data = [
            'title' => 'Lokasi Toko Pertanian',
            'tokoList' => $this->tokoModel->getTokoByKategori($kategori),
            'kategoriList' => $this->tokoModel->getKategoriToko(),
            'activeKategori' => $kategori
        ];

        return view('belanja/index', $data);
    }
}