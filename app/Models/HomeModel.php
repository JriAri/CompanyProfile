<?php

namespace App\Models;

use CodeIgniter\Model;

class HomeModel extends Model
{
    protected $table = 'artikel';
    protected $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

    public function getBerandaContent()
    {
        if ($this->db->tableExists('konten_beranda')) {
            return $this->db->table('konten_beranda')
                           ->where('status', 'aktif')
                           ->get()
                           ->getRowArray();
        }
        
        return [];
    }

    public function getStatistik()
    {
        $statistik = [];
        
        if ($this->db->tableExists('artikel')) {
            $statistik['total_artikel'] = $this->db->table('artikel')
                                                  ->where('status', 'published')
                                                  ->countAllResults();
        } else {
            $statistik['total_artikel'] = 25;
        }
        
        if ($this->db->tableExists('konsultasi')) {
            $statistik['total_konsultasi'] = $this->db->table('konsultasi')
                                                     ->where('status', 'answered')
                                                     ->countAllResults();
        } else {
            $statistik['total_konsultasi'] = 150;
        }
        
        if ($this->db->tableExists('penyuluh')) {
            $statistik['total_penyuluh'] = $this->db->table('penyuluh')
                                                   ->where('status', 'aktif')
                                                   ->countAllResults();
        } else {
            $statistik['total_penyuluh'] = 12;
        }
        
        if ($this->db->tableExists('users')) {
            $statistik['total_anggota'] = $this->db->table('users')
                                                  ->where('status', 'active')
                                                  ->countAllResults();
        } else {
            $statistik['total_anggota'] = 1250;
        }
        
        return $statistik;
    }

    public function getArtikelTerbaru($limit = 6)
    {
        if ($this->db->tableExists('artikel')) {
            return $this->db->table('artikel')
                           ->select('id, judul, slug, ringkasan, gambar, tanggal, penulis_id')
                           ->where('status', 'published')
                           ->orderBy('tanggal', 'DESC')
                           ->limit($limit)
                           ->get()
                           ->getResultArray();
        }
        
        return [];
    }

    public function getLayananUtama()
    {
        return [
            [
                'nama' => 'Konsultasi Gratis',
                'deskripsi' => 'Dapatkan saran dari penyuluh ahli untuk masalah pertanian dan peternakan Anda',
                'icon' => 'fas fa-comments',
                'url' => '/konsultasi'
            ],
            [
                'nama' => 'Artikel & Tips',
                'deskripsi' => 'Informasi terbaru dan tips praktis untuk meningkatkan produktivitas usaha',
                'icon' => 'fas fa-newspaper',
                'url' => '/artikel'
            ],
            [
                'nama' => 'Penyuluh Ahli',
                'deskripsi' => 'Tim penyuluh berpengalaman dan bersertifikat siap membantu Anda',
                'icon' => 'fas fa-user-tie',
                'url' => '/penyuluh'
            ],
            [
                'nama' => 'Galeri Inspirasi',
                'deskripsi' => 'Lihat foto-foto hasil panen dan praktik terbaik dari petani sukses',
                'icon' => 'fas fa-images',
                'url' => '/galeri'
            ],
            [
                'nama' => 'Marketplace',
                'deskripsi' => 'Belanja kebutuhan pertanian dan jual hasil panen dengan mudah',
                'icon' => 'fas fa-shopping-cart',
                'url' => '/belanja'
            ],
            [
                'nama' => 'Forum Diskusi',
                'deskripsi' => 'Diskusi dan berbagi pengalaman dengan sesama petani dan peternak',
                'icon' => 'fas fa-users',
                'url' => '/diskusi'
            ]
        ];
    }

    public function getTotalKonsultasi()
    {
        if ($this->db->tableExists('konsultasi')) {
            return $this->db->table('konsultasi')->countAllResults();
        }
        return 0;
    }

    public function getKonsultasiBulanIni()
    {
        if ($this->db->tableExists('konsultasi')) {
            return $this->db->table('konsultasi')
                           ->where('MONTH(created_at)', date('m'))
                           ->where('YEAR(created_at)', date('Y'))
                           ->countAllResults();
        }
        return 0;
    }
}