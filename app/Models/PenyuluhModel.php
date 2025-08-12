<?php

namespace App\Models;

use CodeIgniter\Model;

class PenyuluhModel extends Model
{
    protected $table = 'penyuluh';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nama',
        'email',
        'phone',
        'spesialisasi',
        'pengalaman',
        'foto',
        'bio',
        'wilayah_kerja',
        'status',
        'created_at',
        'updated_at'
    ];
    
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    protected $validationRules = [
        'nama' => 'required|min_length[3]|max_length[100]',
        'spesialisasi' => 'required',
        'wilayah_kerja' => 'required|max_length[100]',
        'phone' => 'required|numeric|min_length[10]|max_length[15]',
        'email' => 'required|valid_email|max_length[100]|is_unique[penyuluh.email]',
        'status' => 'required|in_list[aktif,nonaktif]'
    ];
    
    protected $validationMessages = [
        'nama' => [
            'required' => 'Nama penyuluh harus diisi',
            'min_length' => 'Nama minimal 3 karakter',
            'max_length' => 'Nama maksimal 100 karakter'
        ],
        'spesialisasi' => [
            'required' => 'Spesialisasi harus dipilih'
        ],
        'wilayah_kerja' => [
            'required' => 'Wilayah kerja harus diisi'
        ],
        'phone' => [
            'required' => 'Nomor telepon harus diisi',
            'numeric' => 'Nomor telepon harus berupa angka'
        ],
        'email' => [
            'required' => 'Email harus diisi',
            'valid_email' => 'Format email tidak valid',
            'is_unique' => 'Email sudah digunakan oleh penyuluh lain'
        ]
    ];

    private $kecamatanList = [
        'Moa Lakor',
        'Damer',
        'Mndona Hiera',
        'Pulau-Pulau Babar',
        'Pulau-Pulau Babar Timur',
        'Pulau Wetang',
        'Pulau Masela',
        'Dawelor Dawera',
        'Kepulauan Romang',
        'Kisar Utara',
        'Pulau Letti',
        'Pulau Lakor',
        'Wetar Utara',
        'Wetar Barat'
    ];
    
    public function getValidationRulesForEdit($id)
    {
        return [
            'nama' => 'required|min_length[3]|max_length[100]',
            'spesialisasi' => 'required',
            'wilayah_kerja' => 'required|max_length[100]',
            'phone' => 'required|numeric|min_length[10]|max_length[15]',
            'email' => "required|valid_email|max_length[100]|is_unique[penyuluh.email,id,{$id}]",
            'status' => 'required|in_list[aktif,nonaktif]'
        ];
    }
    
    public function getPenyuluhByWilayah($wilayah = null)
    {
        $builder = $this->where('status', 'aktif');
        
        if ($wilayah) {
            $builder->like('wilayah_kerja', $wilayah);
        }
        
        return $builder->orderBy('nama', 'ASC')->findAll();
    }
    
    public function getPenyuluhBySpesialisasi($spesialisasi)
    {
        return $this->where([
            'spesialisasi' => $spesialisasi,
            'status' => 'aktif'
        ])->orderBy('nama', 'ASC')->findAll();
    }
    
    public function getWilayahKerja()
    {
        return $this->kecamatanList;
    }
    
    public function searchPenyuluh($keyword, $wilayah = null, $spesialisasi = null)
    {
        $builder = $this->where('status', 'aktif');
        
        if ($keyword) {
            $builder->groupStart()
                   ->like('nama', $keyword)
                   ->orLike('bio', $keyword)
                   ->groupEnd();
        }
        
        if ($wilayah) {
            $builder->like('wilayah_kerja', $wilayah);
        }
        
        if ($spesialisasi) {
            $builder->where('spesialisasi', $spesialisasi);
        }
        
        return $builder->orderBy('nama', 'ASC')->findAll();
    }
    
    public function getStatistik()
    {
        return [
            'total_penyuluh' => $this->where('status', 'aktif')->countAllResults(),
            'penyuluh_pertanian' => $this->where(['spesialisasi' => 'pertanian', 'status' => 'aktif'])->countAllResults(),
            'penyuluh_peternakan' => $this->where(['spesialisasi' => 'peternakan', 'status' => 'aktif'])->countAllResults(),
            'total_wilayah' => count($this->getWilayahKerja())
        ];
    }
    
    public function formatWhatsApp($nomor)
    {
        $nomor = preg_replace('/[^0-9]/', '', $nomor);
        
        if (substr($nomor, 0, 1) === '0') {
            $nomor = '62' . substr($nomor, 1);
        }
        
        if (substr($nomor, 0, 2) !== '62') {
            $nomor = '62' . $nomor;
        }
        
        return $nomor;
    }

    public function isKecamatanTaken($kecamatan, $excludeId = null)
    {
        $builder = $this->where('wilayah_kerja', $kecamatan)
                        ->where('status', 'aktif');

        if ($excludeId) {
            $builder->where('id !=', $excludeId);
        }

        return $builder->countAllResults() > 0;
    }

    public function isEmailTaken($email, $excludeId = null)
    {
        $builder = $this->where('email', $email);

        if ($excludeId) {
            $builder->where('id !=', $excludeId);
        }

        return $builder->countAllResults() > 0;
    }

    public function isPhoneTaken($phone, $excludeId = null)
    {
        $builder = $this->where('phone', $phone);

        if ($excludeId) {
            $builder->where('id !=', $excludeId);
        }

        return $builder->countAllResults() > 0;
    }
}