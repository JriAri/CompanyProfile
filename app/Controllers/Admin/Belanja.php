<?php namespace App\Controllers\Admin;

use App\Controllers\BaseController;
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
        $data = [
            'title'     => 'Manajemen Toko Pertanian',
            'active'    => 'belanja',
            'toko'      => $this->tokoModel->findAll(),
            'kategori'  => $this->tokoModel->getKategoriToko(),
            'nama'      => session()->get('nama'),
            'role'      => session()->get('role')
        ];

        return view('admin/belanja/index', $data);
    }

    public function tambah()
    {
        $data = [
            'title'      => 'Tambah Toko Baru',
            'active'     => 'belanja',
            'kategori'   => $this->tokoModel->getKategoriToko(),
            'validation' => \Config\Services::validation(),
            'nama'       => session()->get('nama'),
            'role'       => session()->get('role')
        ];

        return view('admin/belanja/create', $data);
    }

    public function simpan()
    {
        $rules = [
            'nama_toko'  => 'required|min_length[3]|max_length[255]',
            'jenis_toko' => 'required',
            'alamat'     => 'required',
            'link_gmaps' => 'permit_empty|valid_url',
            'telepon'    => 'required|min_length[10]|max_length[15]',
            'gambar'     => 'uploaded[gambar]|max_size[gambar,2048]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $gambar = $this->request->getFile('gambar');
        $namaGambar = $gambar->getRandomName();
        $gambar->move(ROOTPATH . 'public/uploads/toko', $namaGambar);

        $data = [
            'nama_toko'  => $this->request->getPost('nama_toko'),
            'jenis_toko' => $this->request->getPost('jenis_toko'),
            'alamat'     => $this->request->getPost('alamat'),
            'deskripsi'  => $this->request->getPost('deskripsi'),
            'link_gmaps' => $this->request->getPost('link_gmaps'),
            'telepon'    => $this->request->getPost('telepon'),
            'gambar'     => $namaGambar
        ];

        if ($this->tokoModel->save($data)) {
            return redirect()->to('admin/belanja')->with('success', 'Toko berhasil ditambahkan');
        }

        return redirect()->back()->withInput()->with('error', 'Gagal menambahkan toko');
    }

    public function edit($id)
    {
        $toko = $this->tokoModel->find($id);
        if (!$toko) {
            return redirect()->to('admin/belanja')->with('error', 'Toko tidak ditemukan');
        }

        $data = [
            'title'      => 'Edit Toko',
            'active'     => 'belanja',
            'toko'       => $toko,
            'kategori'   => $this->tokoModel->getKategoriToko(),
            'validation' => \Config\Services::validation(),
            'nama'       => session()->get('nama'),
            'role'       => session()->get('role')
        ];

        return view('admin/belanja/edit', $data);
    }

    public function update($id)
    {
        $toko = $this->tokoModel->find($id);
        if (!$toko) {
            return redirect()->to('admin/belanja')->with('error', 'Toko tidak ditemukan');
        }

        $rules = [
            'nama_toko'  => 'required|min_length[3]|max_length[255]',
            'jenis_toko' => 'required',
            'alamat'     => 'required',
            'telepon'    => 'required|min_length[10]|max_length[15]',
            'link_gmaps' => 'permit_empty|valid_url'
        ];

        if ($this->request->getFile('gambar')->isValid()) {
            $rules['gambar'] = 'uploaded[gambar]|max_size[gambar,2048]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'id'         => $id,
            'nama_toko'  => $this->request->getPost('nama_toko'),
            'jenis_toko' => $this->request->getPost('jenis_toko'),
            'alamat'     => $this->request->getPost('alamat'),
            'deskripsi'  => $this->request->getPost('deskripsi'),
            'link_gmaps' => $this->request->getPost('link_gmaps'),
            'telepon'    => $this->request->getPost('telepon')
        ];

        $gambar = $this->request->getFile('gambar');
        if ($gambar && $gambar->isValid() && !$gambar->hasMoved()) {
            if ($toko['gambar'] && file_exists(ROOTPATH . 'public/uploads/toko/' . $toko['gambar'])) {
                unlink(ROOTPATH . 'public/uploads/toko/' . $toko['gambar']);
            }

            $namaGambar = $gambar->getRandomName();
            $gambar->move(ROOTPATH . 'public/uploads/toko', $namaGambar);
            $data['gambar'] = $namaGambar;
        }

        if ($this->tokoModel->save($data)) {
            return redirect()->to('admin/belanja')->with('success', 'Toko berhasil diperbarui');
        }

        return redirect()->back()->withInput()->with('error', 'Gagal memperbarui toko');
    }

    public function hapus($id)
    {
        $toko = $this->tokoModel->find($id);
        if (!$toko) {
            return redirect()->back()->with('error', 'Toko tidak ditemukan');
        }

        if ($toko['gambar'] && file_exists(ROOTPATH . 'public/uploads/toko/' . $toko['gambar'])) {
            unlink(ROOTPATH . 'public/uploads/toko/' . $toko['gambar']);
        }

        if ($this->tokoModel->delete($id)) {
            return redirect()->to('admin/belanja')->with('success', 'Toko berhasil dihapus');
        }

        return redirect()->back()->with('error', 'Gagal menghapus toko');
    }
}