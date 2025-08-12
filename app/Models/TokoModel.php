<?php

namespace App\Models;

use CodeIgniter\Model;

class TokoModel extends Model
{
    protected $table = 'toko_pertanian';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nama_toko', 
        'jenis_toko', 
        'alamat', 
        'deskripsi', 
        'link_gmaps',
        'telepon', 
        'gambar'
    ];    
    protected $useTimestamps = true;

    public function getTokoByKategori($kategori = null)
    {
        if ($kategori) {
            return $this->where('jenis_toko', $kategori)->findAll();
        }
        return $this->findAll();
    }

    public function getKategoriToko()
    {
        return [
            ['jenis_toko' => 'bibit', 'label' => 'Bibit Tanaman'],
            ['jenis_toko' => 'pupuk', 'label' => 'Pupuk'],
            ['jenis_toko' => 'obat_hewan', 'label' => 'Obat Hewan Ternak'],
            ['jenis_toko' => 'alat_pertanian', 'label' => 'Alat Pertanian']
        ];
    }
}