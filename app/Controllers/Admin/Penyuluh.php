<?php namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PenyuluhModel;

class Penyuluh extends BaseController
{
    protected $penyuluhModel;

    public function __construct()
    {
        $this->penyuluhModel = new PenyuluhModel();
    }

    public function index()
    {
        $data = [
            'title'     => 'Manajemen Penyuluh',
            'active'    => 'penyuluh',
            'penyuluh'  => $this->penyuluhModel->orderBy('nama', 'ASC')->findAll(),
            'stats'     => $this->penyuluhModel->getStatistik(),
            'nama'      => session()->get('nama'),
            'role'      => session()->get('role')
        ];

        return view('admin/penyuluh/index', $data);
    }

    public function tambah()
    {
        $data = [
            'title'       => 'Tambah Penyuluh Baru',
            'active'      => 'penyuluh',
            'wilayahList' => $this->penyuluhModel->getWilayahKerja(),
            'validation'  => \Config\Services::validation(),
            'nama'        => session()->get('nama'),
            'role'        => session()->get('role')
        ];

        return view('admin/penyuluh/create', $data);
    }

    public function simpan()
    {
        if (!$this->validate(
            $this->penyuluhModel->validationRules,
            $this->penyuluhModel->validationMessages
        )) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nama'          => $this->request->getPost('nama'),
            'email'         => $this->request->getPost('email'),
            'phone'         => $this->request->getPost('phone'),
            'spesialisasi'  => $this->request->getPost('spesialisasi'),
            'pengalaman'    => $this->request->getPost('pengalaman'),
            'bio'           => $this->request->getPost('bio'),
            'wilayah_kerja' => $this->request->getPost('wilayah_kerja'),
            'status'        => $this->request->getPost('status'),
        ];

        $foto = $this->request->getFile('foto');
        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $newName = $foto->getRandomName();
            $foto->move(ROOTPATH . 'public/uploads/penyuluh', $newName);
            $data['foto'] = $newName;
        }

        if ($this->penyuluhModel->save($data)) {
            return redirect()->to('admin/penyuluh')->with('success', 'Penyuluh berhasil ditambahkan');
        }

        return redirect()->back()->withInput()->with('error', 'Gagal menambahkan penyuluh');
    }

    public function edit($id)
    {
        $penyuluh = $this->penyuluhModel->find($id);

        if (!$penyuluh) {
            return redirect()->to('admin/penyuluh')->with('error', 'Penyuluh tidak ditemukan');
        }

        $data = [
            'title'       => 'Edit Penyuluh',
            'active'      => 'penyuluh',
            'penyuluh'    => $penyuluh,
            'wilayahList' => $this->penyuluhModel->getWilayahKerja(),
            'validation'  => \Config\Services::validation(),
            'nama'        => session()->get('nama'),
            'role'        => session()->get('role')
        ];

        return view('admin/penyuluh/edit', $data);
    }

    public function update($id)
    {
        // Validasi khusus untuk edit - exclude ID yang sedang diedit
        $validationRules = $this->penyuluhModel->validationRules;
        $validationRules['email'] = 'required|valid_email|is_unique[penyuluh.email,id,' . $id . ']';
        $validationRules['phone'] = 'required|is_unique[penyuluh.phone,id,' . $id . ']';

        if (!$this->validate(
            $validationRules,
            $this->penyuluhModel->validationMessages
        )) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $data = [
            'id'            => $id,
            'nama'          => $this->request->getPost('nama'),
            'email'         => $this->request->getPost('email'),
            'phone'         => $this->request->getPost('phone'),
            'spesialisasi'  => $this->request->getPost('spesialisasi'),
            'pengalaman'    => $this->request->getPost('pengalaman'),
            'bio'           => $this->request->getPost('bio'),
            'wilayah_kerja' => $this->request->getPost('wilayah_kerja'),
            'status'        => $this->request->getPost('status')
        ];

        $foto = $this->request->getFile('foto');
        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $oldFoto = $this->penyuluhModel->find($id)['foto'];
            if ($oldFoto && file_exists(ROOTPATH . 'public/uploads/penyuluh/' . $oldFoto)) {
                unlink(ROOTPATH . 'public/uploads/penyuluh/' . $oldFoto);
            }

            $newName = $foto->getRandomName();
            $foto->move(ROOTPATH . 'public/uploads/penyuluh', $newName);
            $data['foto'] = $newName;
        }

        if ($this->penyuluhModel->save($data)) {
            return redirect()->to('admin/penyuluh')->with('success', 'Penyuluh berhasil diperbarui');
        }

        return redirect()->back()->withInput()->with('error', 'Gagal memperbarui penyuluh');
    }

    public function hapus($id)
    {
        $penyuluh = $this->penyuluhModel->find($id);

        if (!$penyuluh) {
            return redirect()->back()->with('error', 'Penyuluh tidak ditemukan');
        }

        if ($penyuluh['foto'] && file_exists(ROOTPATH . 'public/uploads/penyuluh/' . $penyuluh['foto'])) {
            unlink(ROOTPATH . 'public/uploads/penyuluh/' . $penyuluh['foto']);
        }

        if ($this->penyuluhModel->delete($id)) {
            return redirect()->to('admin/penyuluh')->with('success', 'Penyuluh berhasil dihapus');
        }

        return redirect()->back()->with('error', 'Gagal menghapus penyuluh');
    }

    // AJAX methods untuk real-time validation
    public function checkEmail()
    {
        $email = $this->request->getPost('email');
        $id = $this->request->getPost('id') ?? null;
        
        $query = $this->penyuluhModel->where('email', $email);
        
        // Jika editing, exclude ID yang sedang diedit
        if ($id) {
            $query->where('id !=', $id);
        }
        
        $existing = $query->first();
        
        if ($existing) {
            return $this->response->setJSON([
                'taken' => true,
                'message' => 'Email sudah digunakan oleh penyuluh lain'
            ]);
        }
        
        return $this->response->setJSON([
            'taken' => false,
            'message' => 'Email tersedia'
        ]);
    }

    public function checkPhone()
    {
        $phone = $this->request->getPost('phone');
        $id = $this->request->getPost('id') ?? null;
        
        $query = $this->penyuluhModel->where('phone', $phone);
        
        // Jika editing, exclude ID yang sedang diedit
        if ($id) {
            $query->where('id !=', $id);
        }
        
        $existing = $query->first();
        
        if ($existing) {
            return $this->response->setJSON([
                'taken' => true,
                'message' => 'Nomor telepon sudah digunakan oleh penyuluh lain'
            ]);
        }
        
        return $this->response->setJSON([
            'taken' => false,
            'message' => 'Nomor telepon tersedia'
        ]);
    }

    public function checkWilayah()
    {
        $wilayah = $this->request->getPost('wilayah');
        $status = $this->request->getPost('status');
        $id = $this->request->getPost('id') ?? null;
        
        // Hanya cek jika status aktif
        if ($status !== 'aktif') {
            return $this->response->setJSON([
                'taken' => false,
                'message' => 'Wilayah tersedia'
            ]);
        }
        
        $query = $this->penyuluhModel->where('wilayah_kerja', $wilayah)->where('status', 'aktif');
        
        // Jika editing, exclude ID yang sedang diedit
        if ($id) {
            $query->where('id !=', $id);
        }
        
        $existing = $query->first();
        
        if ($existing) {
            return $this->response->setJSON([
                'taken' => true,
                'message' => 'Kecamatan ini sudah memiliki penyuluh aktif: ' . $existing['nama']
            ]);
        }
        
        return $this->response->setJSON([
            'taken' => false,
            'message' => 'Wilayah kerja tersedia'
        ]);
    }
}