<?php

namespace App\Controllers;

use App\Models\GaleriModel;

class Galeri extends BaseController
{
    protected $galeriModel;

    public function __construct()
    {
        $this->galeriModel = new GaleriModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Galeri Kegiatan Penyuluhan',
            'galeri' => $this->galeriModel->getGaleri(),
            'active' => 'galeri'
        ];

        return view('galeri/index', $data);
    }
}