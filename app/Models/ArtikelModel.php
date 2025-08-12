<?php

namespace App\Models;

use CodeIgniter\Model;

class ArtikelModel extends Model
{
    protected $table = 'artikel';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'judul', 'slug', 'ringkasan', 'konten', 'gambar', 'kategori_id', 
        'penulis_id', 'tanggal', 'views', 'status', 'meta_keywords', 'created_at', 'updated_at'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getArtikelPaginated($perPage = 9, $page = 1)
    {
        return $this->select('artikel.*, kategori_artikel.nama as kategori_nama, kategori_artikel.slug as kategori_slug, penyuluh.nama as penulis_nama')
                    ->join('kategori_artikel', 'kategori_artikel.id = artikel.kategori_id', 'left')
                    ->join('penyuluh', 'penyuluh.id = artikel.penulis_id', 'left')
                    ->where('artikel.status', 'published')
                    ->orderBy('artikel.tanggal', 'DESC')
                    ->paginate($perPage, 'default', $page);
    }

    public function getArtikelById($id)
    {
        return $this->select('artikel.*, kategori_artikel.nama as kategori_nama, kategori_artikel.slug as kategori_slug, penyuluh.nama as penulis_nama')
                    ->join('kategori_artikel', 'kategori_artikel.id = artikel.kategori_id', 'left')
                    ->join('penyuluh', 'penyuluh.id = artikel.penulis_id', 'left')
                    ->where('artikel.id', $id)
                    ->where('artikel.status', 'published')
                    ->first();
    }

    public function getArtikelBySlug($slug)
    {
        return $this->select('artikel.*, kategori_artikel.nama as kategori_nama, kategori_artikel.slug as kategori_slug, penyuluh.nama as penulis_nama')
                    ->join('kategori_artikel', 'kategori_artikel.id = artikel.kategori_id', 'left')
                    ->join('penyuluh', 'penyuluh.id = artikel.penulis_id', 'left')
                    ->where('artikel.slug', $slug)
                    ->where('artikel.status', 'published')
                    ->first();
    }

    public function getArtikelByKategori($kategori_id, $perPage = 9, $page = 1)
    {
        return $this->select('artikel.*, kategori_artikel.nama as kategori_nama, kategori_artikel.slug as kategori_slug, penyuluh.nama as penulis_nama')
                    ->join('kategori_artikel', 'kategori_artikel.id = artikel.kategori_id', 'left')
                    ->join('penyuluh', 'penyuluh.id = artikel.penulis_id', 'left')
                    ->where('artikel.kategori_id', $kategori_id)
                    ->where('artikel.status', 'published')
                    ->orderBy('artikel.tanggal', 'DESC')
                    ->paginate($perPage, 'default', $page);
    }

    public function getArtikelPopuler($limit = 5)
    {
        return $this->select('artikel.*, kategori_artikel.nama as kategori_nama, kategori_artikel.slug as kategori_slug, penyuluh.nama as penulis_nama')
                    ->join('kategori_artikel', 'kategori_artikel.id = artikel.kategori_id', 'left')
                    ->join('penyuluh', 'penyuluh.id = artikel.penulis_id', 'left')
                    ->where('artikel.status', 'published')
                    ->orderBy('artikel.views', 'DESC')
                    ->orderBy('artikel.tanggal', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    public function getArtikelTerkait($kategori_id, $current_id, $limit = 4)
    {
        return $this->select('artikel.*, kategori_artikel.nama as kategori_nama, penyuluh.nama as penulis_nama')
                    ->join('kategori_artikel', 'kategori_artikel.id = artikel.kategori_id', 'left')
                    ->join('penyuluh', 'penyuluh.id = artikel.penulis_id', 'left')
                    ->where('artikel.kategori_id', $kategori_id)
                    ->where('artikel.id !=', $current_id)
                    ->where('artikel.status', 'published')
                    ->orderBy('artikel.tanggal', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    public function searchArtikel($keyword, $perPage = 9, $page = 1)
    {
        return $this->select('artikel.*, kategori_artikel.nama as kategori_nama, kategori_artikel.slug as kategori_slug, penyuluh.nama as penulis_nama')
                    ->join('kategori_artikel', 'kategori_artikel.id = artikel.kategori_id', 'left')
                    ->join('penyuluh', 'penyuluh.id = artikel.penulis_id', 'left')
                    ->groupStart()
                        ->like('artikel.judul', $keyword)
                        ->orLike('artikel.ringkasan', $keyword)
                        ->orLike('artikel.konten', $keyword)
                        ->orLike('artikel.meta_keywords', $keyword)
                    ->groupEnd()
                    ->where('artikel.status', 'published')
                    ->orderBy('artikel.tanggal', 'DESC')
                    ->paginate($perPage, 'default', $page);
    }

    public function getArtikelTerbaru($limit = 3)
    {
        return $this->select('artikel.*, kategori_artikel.nama as kategori_nama, penyuluh.nama as penulis_nama')
                    ->join('kategori_artikel', 'kategori_artikel.id = artikel.kategori_id', 'left')
                    ->join('penyuluh', 'penyuluh.id = artikel.penulis_id', 'left')
                    ->where('artikel.status', 'published')
                    ->orderBy('artikel.tanggal', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    public function getKategoriArtikel()
    {
        $db = \Config\Database::connect();
        return $db->table('kategori_artikel')
                  ->select('kategori_artikel.*, COUNT(artikel.id) as total_artikel')
                  ->join('artikel', 'artikel.kategori_id = kategori_artikel.id AND artikel.status = "published"', 'left')
                  ->groupBy('kategori_artikel.id')
                  ->orderBy('kategori_artikel.nama', 'ASC')
                  ->get()
                  ->getResultArray();
    }

    public function getKategoriBySlug($slug)
    {
        $db = \Config\Database::connect();
        return $db->table('kategori_artikel')
                  ->where('slug', $slug)
                  ->get()
                  ->getRowArray();
    }

    public function updateViews($id)
    {
        $this->set('views', 'views + 1', false)
             ->where('id', $id)
             ->update();
    }

    public function getAllArtikel()
    {
        return $this->select('artikel.*, kategori_artikel.nama as kategori_nama, penyuluh.nama AS penulis')
                    ->join('kategori_artikel', 'kategori_artikel.id = artikel.kategori_id', 'left')
                    ->join('penyuluh', 'penyuluh.id = artikel.penulis_id', 'left')
                    ->orderBy('tanggal', 'DESC')
                    ->paginate(10);
    }

    public function getTotalViews()
    {
        return $this->where('status', 'published')->selectSum('views')->first()['views'] ?? 0;
    }
}