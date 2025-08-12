<?php

namespace App\Controllers;

use App\Models\ArtikelModel;
use CodeIgniter\Controller;
use App\Models\KomentarModel;

class ArtikelController extends Controller
{
    protected $artikelModel;
    protected $komentarModel;
    
    public function __construct()
    {
        $this->artikelModel = new ArtikelModel();
        $this->komentarModel = new KomentarModel();
    }

    public function index($kategori_slug = null)
    {
        if ($kategori_slug) {
            return $this->kategori($kategori_slug);
        }

        $data = [
            'title' => 'Artikel Pertanian & Peternakan - AgriConnect',
            'meta_description' => 'Kumpulan artikel terlengkap tentang pertanian dan peternakan modern untuk meningkatkan produktivitas usaha Anda',
            'artikel_list' => $this->artikelModel->getArtikelPaginated(9, $this->request->getVar('page') ?? 1),
            'pager' => $this->artikelModel->pager,
            'kategori_list' => $this->artikelModel->getKategoriArtikel(),
            'artikel_populer' => $this->artikelModel->getArtikelPopuler(5),
            'total_artikel' => $this->artikelModel->countAll(),
            'total_views' => $this->artikelModel->getTotalViews(),
            'search_query' => $this->request->getVar('q') ?? ''
        ];

        return view('artikel/index', $data);
    }

    public function detail($slug)
    {
        $artikel = $this->artikelModel->getArtikelBySlug($slug);
        
        if (!$artikel) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Artikel tidak ditemukan');
        }

        $this->artikelModel->updateViews($artikel['id']);

        $data = [
            'title' => $artikel['judul'] . ' - AgriConnect',
            'meta_description' => $artikel['ringkasan'],
            'artikel' => $artikel,
            'artikel_terkait' => $this->artikelModel->getArtikelTerkait($artikel['kategori_id'], $artikel['id'], 4),
            'komentar' => $this->komentarModel->getKomentarByArtikel($artikel['id']),
            'total_komentar' => $this->komentarModel->getTotalKomentarByArtikel($artikel['id']) // Add this line
        ];

        return view('artikel/detail', $data);
    }

    public function postKomentar()
    {
        $validation = \Config\Services::validation();
        
        $validation->setRules([
            'nama' => 'required|max_length[100]',
            'email' => 'permit_empty|valid_email|max_length[100]',
            'komentar' => 'required',
            'artikel_id' => 'required|integer',
            'parent_id' => 'permit_empty|integer'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $parent_id = $this->request->getVar('parent_id');
        
        $data = [
            'artikel_id' => $this->request->getVar('artikel_id'),
            'nama' => $this->request->getVar('nama'),
            'email' => $this->request->getVar('email') ?: null,
            'komentar' => $this->request->getVar('komentar'),
            'tanggal' => date('Y-m-d H:i:s'),
            'parent_id' => $parent_id ?: null,
            'level' => $parent_id ? 1 : 0
        ];

        $this->komentarModel->saveKomentar($data);

        $message = $parent_id ? 'Balasan berhasil ditambahkan!' : 'Komentar berhasil ditambahkan!';
        return redirect()->back()->with('success', $message);
    }

    public function kategori($kategori_slug)
    {
        $kategori = $this->artikelModel->getKategoriBySlug($kategori_slug);
        
        if (!$kategori) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Kategori tidak ditemukan');
        }

        $data = [
            'title' => 'Artikel ' . $kategori['nama'] . ' - AgriConnect',
            'meta_description' => 'Kumpulan artikel tentang ' . $kategori['nama'] . ' untuk petani dan peternak',
            'artikel_list' => $this->artikelModel->getArtikelByKategori($kategori['id'], 9, $this->request->getVar('page') ?? 1),
            'pager' => $this->artikelModel->pager,
            'kategori' => $kategori,
            'kategori_list' => $this->artikelModel->getKategoriArtikel(),
            'artikel_populer' => $this->artikelModel->getArtikelPopuler(5),
            'total_artikel' => $this->artikelModel->countAll(),
            'total_views' => $this->artikelModel->getTotalViews(),
            'search_query' => $this->request->getVar('q') ?? ''
        ];

        return view('artikel/index', $data);
    }

    public function search()
    {
        $keyword = $this->request->getVar('q');
        
        if (empty($keyword)) {
            return redirect()->to('/artikel');
        }

        $data = [
            'title' => 'Pencarian: ' . $keyword . ' - AgriConnect',
            'meta_description' => 'Hasil pencarian artikel untuk: ' . $keyword,
            'artikel_list' => $this->artikelModel->searchArtikel($keyword, 9, $this->request->getVar('page') ?? 1),
            'pager' => $this->artikelModel->pager,
            'keyword' => $keyword,
            'kategori_list' => $this->artikelModel->getKategoriArtikel(),
            'artikel_populer' => $this->artikelModel->getArtikelPopuler(5),
            'search_query' => $keyword
        ];

        return view('artikel/search', $data);
    }
}