<?php namespace App\Controllers\Admin;

use App\Controllers\BaseController;
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
            'title'     => 'Manajemen Galeri',
            'active'    => 'galeri',
            'galeri'    => $this->galeriModel->orderBy('tanggal', 'DESC')->findAll(),
            'nama'      => session()->get('nama'),
            'role'      => session()->get('role')
        ];

        return view('admin/galeri/index', $data);
    }

    public function tambah()
    {
        $data = [
            'title'      => 'Tambah Galeri Baru',
            'active'     => 'galeri',
            'validation' => \Config\Services::validation(),
            'nama'       => session()->get('nama'),
            'role'       => session()->get('role')
        ];

        return view('admin/galeri/create', $data);
    }

    public function simpan()
    {
        $rules = [
            'judul'     => 'required|min_length[3]|max_length[255]',
            'deskripsi' => 'max_length[500]',
            'gambar'    => 'uploaded[gambar]|max_size[gambar,2048]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $gambar = $this->request->getFile('gambar');
        $namaGambar = $gambar->getRandomName();
        $gambar->move(ROOTPATH . 'public/uploads/galeri', $namaGambar);

        $data = [
            'judul'     => $this->request->getPost('judul'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'gambar'    => $namaGambar,
            'tanggal'   => date('Y-m-d H:i:s')
        ];

        if ($this->galeriModel->save($data)) {
            return redirect()->to('admin/galeri')->with('success', 'Gambar berhasil ditambahkan ke galeri');
        }

        return redirect()->back()->withInput()->with('error', 'Gagal menambahkan gambar ke galeri');
    }

    public function edit($id)
    {
        $galeri = $this->galeriModel->find($id);
        if (!$galeri) {
            return redirect()->to('admin/galeri')->with('error', 'Data galeri tidak ditemukan');
        }

        $data = [
            'title'      => 'Edit Galeri',
            'active'     => 'galeri',
            'galeri'     => $galeri,
            'validation' => \Config\Services::validation(),
            'nama'       => session()->get('nama'),
            'role'       => session()->get('role')
        ];

        return view('admin/galeri/edit', $data);
    }

    public function update($id)
    {
        $galeri = $this->galeriModel->find($id);
        if (!$galeri) {
            return redirect()->to('admin/galeri')->with('error', 'Data galeri tidak ditemukan');
        }

        $rules = [
            'judul'     => 'required|min_length[3]|max_length[255]',
            'deskripsi' => 'max_length[500]',
        ];

        if ($this->request->getFile('gambar')->isValid()) {
            $rules['gambar'] = 'uploaded[gambar]|max_size[gambar,2048]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'id'        => $id,
            'judul'     => $this->request->getPost('judul'),
            'deskripsi' => $this->request->getPost('deskripsi')
        ];

        $gambar = $this->request->getFile('gambar');
        if ($gambar && $gambar->isValid() && !$gambar->hasMoved()) {
            if ($galeri['gambar'] && file_exists(ROOTPATH . 'public/uploads/galeri/' . $galeri['gambar'])) {
                unlink(ROOTPATH . 'public/uploads/galeri/' . $galeri['gambar']);
            }

            $namaGambar = $gambar->getRandomName();
            $gambar->move(ROOTPATH . 'public/uploads/galeri', $namaGambar);
            $data['gambar'] = $namaGambar;
        }

        if ($this->galeriModel->save($data)) {
            return redirect()->to('admin/galeri')->with('success', 'Data galeri berhasil diperbarui');
        }

        return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data galeri');
    }

    public function hapus($id)
    {
        $galeri = $this->galeriModel->find($id);
        if (!$galeri) {
            return redirect()->back()->with('error', 'Data galeri tidak ditemukan');
        }

        if ($galeri['gambar'] && file_exists(ROOTPATH . 'public/uploads/galeri/' . $galeri['gambar'])) {
            unlink(ROOTPATH . 'public/uploads/galeri/' . $galeri['gambar']);
        }

        if ($this->galeriModel->delete($id)) {
            return redirect()->to('admin/galeri')->with('success', 'Data galeri berhasil dihapus');
        }

        return redirect()->back()->with('error', 'Gagal menghapus data galeri');
    }
}
