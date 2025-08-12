<?php

namespace App\Models;

use CodeIgniter\Model;

class KomentarModel extends Model
{
    protected $table = 'komentar_artikel';
    protected $primaryKey = 'id';
    protected $allowedFields = ['artikel_id', 'nama', 'email', 'komentar', 'tanggal', 'parent_id', 'level'];
    protected $useTimestamps = false;

    public function getKomentarByArtikel($artikel_id)
    {
        $mainComments = $this->where('artikel_id', $artikel_id)
                            ->where('parent_id IS NULL OR parent_id = 0')
                            ->orderBy('tanggal', 'DESC')
                            ->findAll();

        foreach ($mainComments as &$comment) {
            $comment['replies'] = $this->where('artikel_id', $artikel_id)
                                      ->where('parent_id', $comment['id'])
                                      ->orderBy('tanggal', 'ASC')
                                      ->findAll();
        }

        return $mainComments;
    }

    public function saveKomentar($data)
    {
        return $this->insert($data);
    }

    public function getTotalKomentarByArtikel($artikel_id)
    {
        return $this->where('artikel_id', $artikel_id)->countAllResults();
    }
}