<?php namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ArtikelModel;
use App\Models\KategoriArtikelModel;
use App\Models\PenyuluhModel;

class Artikel extends BaseController
{
    protected $artikelModel;
    protected $penyuluhModel;
    protected $kategoriModel;

    public function __construct()
    {
        $this->artikelModel = new ArtikelModel();
        $this->kategoriModel = new KategoriArtikelModel();
        $this->penyuluhModel = new PenyuluhModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Kelola Artikel',
            'nama'  => session('nama'),
            'role'  => session('role'),
            'active' => 'artikel',
            'artikels' => $this->artikelModel->getAllArtikel(),
            'pager' => $this->artikelModel->pager
        ];

        return view('admin/artikel/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Artikel Baru',
            'nama'  => session('nama'),
            'role'  => session('role'),
            'active' => 'artikel',
            'kategoris' => $this->kategoriModel->findAll(),
            'validation' => \Config\Services::validation(),
            'penyuluhList' => $this->penyuluhModel->findAll()
        ];

        return view('admin/artikel/create', $data);
    }

    public function store()
    {
        $rules = [
            'judul' => 'required|min_length[5]|max_length[255]',
            'slug' => 'required|is_unique[artikel.slug]',
            'ringkasan' => 'required|min_length[10]',
            'konten' => 'required|min_length[50]',
            'kategori_id' => 'required',
            'penulis_id' => 'required',
            'status' => 'required',
            'gambar' => 'uploaded[gambar]|max_size[gambar,2048]|is_image[gambar]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        try {
            $gambar = $this->request->getFile('gambar');

            if (!$gambar || !$gambar->isValid()) {
                return redirect()->back()->withInput()->with('error', 'Error upload gambar: ' . $gambar->getErrorString());
            }

            $namaGambar = $gambar->getRandomName();
            $uploadPath = ROOTPATH . 'public/uploads/artikel/';

            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            if (!$gambar->move($uploadPath, $namaGambar)) {
                return redirect()->back()->withInput()->with('error', 'Gagal memindahkan file gambar');
            }

            $data = [
                'judul' => $this->request->getPost('judul'),
                'slug' => $this->request->getPost('slug'),
                'ringkasan' => $this->request->getPost('ringkasan'),
                'konten' => $this->request->getPost('konten'),
                'gambar' => $namaGambar,
                'kategori_id' => $this->request->getPost('kategori_id'),
                'penulis_id' => $this->request->getPost('penulis_id'),
                'tanggal' => date('Y-m-d'),
                'status' => $this->request->getPost('status'),
                'meta_keywords' => $this->request->getPost('meta_keywords')
            ];

            $this->artikelModel->save($data);

            return redirect()->to('/admin/artikel')->with('success', 'Artikel berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $artikel = $this->artikelModel->find($id);

        if (!$artikel) {
            return redirect()->to('/admin/artikel')->with('error', 'Artikel tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Artikel',
            'nama'  => session('nama'),
            'role'  => session('role'),
            'active' => 'artikel',
            'artikel' => $artikel,
            'kategoris' => $this->kategoriModel->findAll(),
            'penyuluhList' => $this->penyuluhModel->findAll(),
            'validation' => \Config\Services::validation()
        ];

        return view('admin/artikel/edit', $data);
    }

    public function update($id)
    {
        $artikel = $this->artikelModel->find($id);

        $slugRules = 'required';
        if ($this->request->getPost('slug') !== $artikel['slug']) {
            $slugRules .= '|is_unique[artikel.slug]';
        }

        $rules = [
            'judul' => 'required|min_length[5]|max_length[255]',
            'slug' => $slugRules,
            'ringkasan' => 'required|min_length[10]',
            'konten' => 'required|min_length[50]',
            'kategori_id' => 'required',
            'penulis_id' => 'required',
            'status' => 'required',
            'gambar' => 'max_size[gambar,2048]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $data = [
            'id' => $id,
            'judul' => $this->request->getPost('judul'),
            'slug' => $this->request->getPost('slug'),
            'ringkasan' => $this->request->getPost('ringkasan'),
            'konten' => $this->request->getPost('konten'),
            'kategori_id' => $this->request->getPost('kategori_id'),
            'penulis_id' => $this->request->getPost('penulis_id'),
            'status' => $this->request->getPost('status'),
            'meta_keywords' => $this->request->getPost('meta_keywords')
        ];

        $gambar = $this->request->getFile('gambar');
        if ($gambar->isValid() && !$gambar->hasMoved()) {
            if ($artikel['gambar'] && file_exists(ROOTPATH . 'public/uploads/artikel/' . $artikel['gambar'])) {
                unlink(ROOTPATH . 'public/uploads/artikel/' . $artikel['gambar']);
            }

            $namaGambar = $gambar->getRandomName();
            $gambar->move(ROOTPATH . 'public/uploads/artikel', $namaGambar);
            $data['gambar'] = $namaGambar;
        }

        $this->artikelModel->save($data);
        return redirect()->to('/admin/artikel')->with('success', 'Artikel berhasil diperbarui');
    }

    public function delete($id)
    {
        $artikel = $this->artikelModel->find($id);

        if (!$artikel) {
            return redirect()->to('/admin/artikel')->with('error', 'Artikel tidak ditemukan');
        }

        if ($artikel['gambar'] && file_exists(ROOTPATH . 'public/uploads/artikel/' . $artikel['gambar'])) {
            unlink(ROOTPATH . 'public/uploads/artikel/' . $artikel['gambar']);
        }

        $this->artikelModel->delete($id);
        return redirect()->to('/admin/artikel')->with('success', 'Artikel berhasil dihapus');
    }
}