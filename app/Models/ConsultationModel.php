<?php

namespace App\Models;

use CodeIgniter\Model;

class ConsultationModel extends Model
{
    protected $table = 'konsultasi';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'nama',
        'wilayah', 
        'pesan',
        'email',
        'phone',
        'status',
        'penyuluh_id',
        'jawaban',
        'tiket',
        'tanggal_dijawab',
        'feedback'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'nama' => 'required|min_length[3]|max_length[100]',
        'wilayah' => 'required|max_length[100]',
        'pesan' => 'required|min_length[10]|max_length[1000]',
        'status' => 'in_list[pending,answered,closed]',
        'email' => 'permit_empty|valid_email|max_length[100]',
        'phone' => 'permit_empty|regex_match[/^(\+62|62|0)[0-9]{8,13}$/]'
    ];

    protected $validationMessages = [
        'nama' => [
            'required' => 'Nama harus diisi.',
            'min_length' => 'Nama minimal 3 karakter.',
            'max_length' => 'Nama maksimal 100 karakter.'
        ],
        'wilayah' => [
            'required' => 'Wilayah harus dipilih.',
            'max_length' => 'Nama wilayah terlalu panjang.'
        ],
        'pesan' => [
            'required' => 'Pesan konsultasi harus diisi.',
            'min_length' => 'Pesan minimal 10 karakter.',
            'max_length' => 'Pesan maksimal 1000 karakter.'
        ],
        'email' => [
            'valid_email' => 'Format email tidak valid.',
            'max_length' => 'Email terlalu panjang.'
        ],
        'phone' => [
            'regex_match' => 'Format nomor telepon tidak valid. Contoh: 081234567890'
        ]
    ];

    public function getPenyuluhTersedia()
    {
        return $this->db->table('penyuluh')
                       ->where('status', 'aktif')
                       ->orderBy('nama', 'ASC')
                       ->get()
                       ->getResultArray();
    }

    public function getTestimoni($limit = 5)
    {
        return $this->db->table('konsultasi k')
                       ->select('k.nama, k.wilayah, k.pesan, k.jawaban, k.created_at, p.nama as nama_penyuluh, p.spesialisasi')
                       ->join('penyuluh p', 'p.id = k.penyuluh_id', 'left')
                       ->where('k.status', 'answered')
                       ->where('k.jawaban IS NOT NULL')
                       ->where('k.jawaban !=', '')
                       ->orderBy('k.created_at', 'DESC')
                       ->limit($limit)
                       ->get()
                       ->getResultArray();
    }

    public function getKonsultasiWithPenyuluh($status = 'pending', $limit = null)
    {
        $builder = $this->db->table('konsultasi k')
                           ->select('k.*, p.nama as nama_penyuluh, p.spesialisasi, p.phone as phone_penyuluh')
                           ->join('penyuluh p', 'p.id = k.penyuluh_id', 'left')
                           ->where('k.status', $status)
                           ->orderBy('k.created_at', 'DESC');

        if ($limit) {
            $builder->limit($limit);
        }

        return $builder->get()->getResultArray();
    }

    public function getKonsultasiByPenyuluh($penyuluh_id, $status = null)
    {
        $builder = $this->where('penyuluh_id', $penyuluh_id);
        
        if ($status) {
            $builder->where('status', $status);
        }

        return $builder->orderBy('created_at', 'DESC')->findAll();
    }

    public function getStatistikKonsultasi()
    {
        $result = [
            'total' => $this->countAll(),
            'pending' => $this->where('status', 'pending')->countAllResults(),
            'answered' => $this->where('status', 'answered')->countAllResults(),
            'closed' => $this->where('status', 'closed')->countAllResults(),
            'this_month' => $this->where('MONTH(created_at)', date('m'))
                                ->where('YEAR(created_at)', date('Y'))
                                ->countAllResults(),
            'today' => $this->where('DATE(created_at)', date('Y-m-d'))
                           ->countAllResults(),
        ];

        $result['per_wilayah'] = $this->db->table('konsultasi')
                                         ->select('wilayah, COUNT(*) as total')
                                         ->groupBy('wilayah')
                                         ->orderBy('total', 'DESC')
                                         ->limit(10)
                                         ->get()
                                         ->getResultArray();

        $result['per_penyuluh'] = $this->db->table('konsultasi k')
                                          ->select('p.nama, COUNT(*) as total_konsultasi')
                                          ->join('penyuluh p', 'p.id = k.penyuluh_id', 'left')
                                          ->where('k.status', 'answered')
                                          ->groupBy('k.penyuluh_id')
                                          ->orderBy('total_konsultasi', 'DESC')
                                          ->limit(10)
                                          ->get()
                                          ->getResultArray();

        return $result;
    }

    public function jawabKonsultasi($id, $jawaban, $penyuluh_id)
    {
        if (empty($jawaban) || strlen($jawaban) < 10) {
            return ['success' => false, 'message' => 'Jawaban minimal 10 karakter.'];
        }

        $konsultasi = $this->find($id);
        if (!$konsultasi) {
            return ['success' => false, 'message' => 'Konsultasi tidak ditemukan.'];
        }

        if ($konsultasi['status'] !== 'pending') {
            return ['success' => false, 'message' => 'Konsultasi sudah dijawab sebelumnya.'];
        }

        $data = [
            'jawaban' => $jawaban,
            'penyuluh_id' => $penyuluh_id,
            'status' => 'answered',
            'tanggal_dijawab' => date('Y-m-d H:i:s')
        ];

        $updated = $this->update($id, $data);
        
        if ($updated) {
            return ['success' => true, 'message' => 'Konsultasi berhasil dijawab.'];
        } else {
            return ['success' => false, 'message' => 'Gagal menyimpan jawaban.'];
        }
    }

    public function getLaporanKonsultasi($start_date = null, $end_date = null, $wilayah = null, $status = null)
    {
        $builder = $this->db->table('konsultasi k')
                           ->select('k.*, p.nama as nama_penyuluh, p.spesialisasi, p.phone as phone_penyuluh')
                           ->join('penyuluh p', 'p.id = k.penyuluh_id', 'left')
                           ->orderBy('k.created_at', 'DESC');

        if ($start_date) {
            $builder->where('DATE(k.created_at) >=', $start_date);
        }

        if ($end_date) {
            $builder->where('DATE(k.created_at) <=', $end_date);
        }

        if ($wilayah) {
            $builder->where('k.wilayah', $wilayah);
        }

        if ($status) {
            $builder->where('k.status', $status);
        }

        return $builder->get()->getResultArray();
    }

    public function assignPenyuluh($konsultasi_id, $penyuluh_id)
    {
        $data = [
            'penyuluh_id' => $penyuluh_id,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        return $this->update($konsultasi_id, $data);
    }

    public function getKonsultasiOverdue($days = 3)
    {
        return $this->where('status', 'pending')
                   ->where('created_at <', date('Y-m-d H:i:s', strtotime("-{$days} days")))
                   ->findAll();
    }

    public function getTrendBulanan($year = null)
    {
        if (!$year) {
            $year = date('Y');
        }

        return $this->db->table('konsultasi')
                       ->select('MONTH(created_at) as bulan, COUNT(*) as total')
                       ->where('YEAR(created_at)', $year)
                       ->groupBy('MONTH(created_at)')
                       ->orderBy('bulan', 'ASC')
                       ->get()
                       ->getResultArray();
    }
}
