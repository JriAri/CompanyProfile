<?php

namespace App\Models;

use CodeIgniter\Model;

class GaleriModel extends Model
{
    protected $table = 'galeri';
    protected $primaryKey = 'id';
    protected $allowedFields = ['judul', 'deskripsi', 'gambar', 'tanggal'];
    protected $useTimestamps = true;

    public function getGaleri($limit = 12)
    {
        return $this->orderBy('tanggal', 'DESC')->findAll($limit);
    }
}