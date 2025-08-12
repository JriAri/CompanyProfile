<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\ArtikelModel;
use App\Models\KategoriArtikelModel;
use App\Models\GaleriModel;
use App\Models\PenyuluhModel;
use App\Models\TokoModel;

class Sitemap extends Controller
{
    public function index()
    {
        $this->response->setHeader('Content-Type', 'application/xml; charset=utf-8');
        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"></urlset>');
        $baseUrl = base_url();
        $this->addStaticPages($xml, $baseUrl);
        $this->addArtikel($xml, $baseUrl);
        $this->addKategoriArtikel($xml, $baseUrl);
        $this->addPenyuluh($xml, $baseUrl);
        $this->addGaleri($xml, $baseUrl);
        return $this->response->setBody($xml->asXML());
    }

    private function addStaticPages($xml, $baseUrl)
    {
        $staticPages = [
            '' => ['priority' => '1.0', 'changefreq' => 'daily'],
            'artikel' => ['priority' => '0.9', 'changefreq' => 'daily'],
            'konsultasi' => ['priority' => '0.8', 'changefreq' => 'weekly'],
            'konsultasi/riwayat' => ['priority' => '0.6', 'changefreq' => 'weekly'],
            'konsultasi/tracking' => ['priority' => '0.6', 'changefreq' => 'weekly'],
            'penyuluh' => ['priority' => '0.8', 'changefreq' => 'weekly'],
            'galeri' => ['priority' => '0.7', 'changefreq' => 'weekly'],
            'belanja' => ['priority' => '0.8', 'changefreq' => 'weekly'],
            'diskusi' => ['priority' => '0.7', 'changefreq' => 'daily'],
            'tentang' => ['priority' => '0.6', 'changefreq' => 'monthly'],
            'kontak' => ['priority' => '0.6', 'changefreq' => 'monthly'],
            'privacy' => ['priority' => '0.3', 'changefreq' => 'yearly'],
            'terms' => ['priority' => '0.3', 'changefreq' => 'yearly'],
        ];

        foreach ($staticPages as $page => $config) {
            $url = $xml->addChild('url');
            $url->addChild('loc', $baseUrl . $page);
            $url->addChild('lastmod', date('Y-m-d'));
            $url->addChild('changefreq', $config['changefreq']);
            $url->addChild('priority', $config['priority']);
        }
    }

    private function addArtikel($xml, $baseUrl)
    {
        $artikelModel = new ArtikelModel();
        $artikel = $artikelModel->where('status', 'published')
            ->orWhere('status', 'aktif')
            ->orderBy('updated_at', 'DESC')
            ->limit(1000)
            ->findAll();

        foreach ($artikel as $item) {
            $url = $xml->addChild('url');
            $url->addChild('loc', $baseUrl . 'artikel/' . $item['slug']);
            $url->addChild('lastmod', date('Y-m-d', strtotime($item['updated_at'])));
            $priority = '0.7';
            if (isset($item['featured']) && $item['featured'] == 1) {
                $priority = '0.8';
            } elseif (isset($item['views']) && $item['views'] > 1000) {
                $priority = '0.75';
            }
            $url->addChild('changefreq', 'weekly');
            $url->addChild('priority', $priority);
        }
    }

    private function addKategoriArtikel($xml, $baseUrl)
    {
        $kategoriModel = new KategoriArtikelModel();
        $kategori = $kategoriModel->where('status', 'aktif')
            ->orWhere('status', 'published')
            ->orderBy('urutan', 'ASC')
            ->findAll();

        foreach ($kategori as $item) {
            $url = $xml->addChild('url');
            $url->addChild('loc', $baseUrl . 'artikel/kategori/' . $item['slug']);
            $url->addChild('lastmod', date('Y-m-d', strtotime($item['updated_at'])));
            $url->addChild('changefreq', 'weekly');
            $url->addChild('priority', '0.8');
        }
    }

    private function addPenyuluh($xml, $baseUrl)
    {
        $penyuluhModel = new PenyuluhModel();
        $penyuluh = $penyuluhModel->where('status', 'aktif')
            ->orderBy('nama', 'ASC')
            ->findAll();

        foreach ($penyuluh as $item) {
            $url = $xml->addChild('url');
            $url->addChild('loc', $baseUrl . 'penyuluh/detail/' . $item['id']);
            $url->addChild('lastmod', date('Y-m-d', strtotime($item['updated_at'])));
            $url->addChild('changefreq', 'monthly');
            $url->addChild('priority', '0.6');
        }
    }

    private function addGaleri($xml, $baseUrl)
    {
        // Hanya halaman utama galeri
    }

    public function generate()
    {
        try {
            $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"></urlset>');
            $baseUrl = base_url();
            $this->addStaticPages($xml, $baseUrl);
            $this->addArtikel($xml, $baseUrl);
            $this->addKategoriArtikel($xml, $baseUrl);
            $this->addPenyuluh($xml, $baseUrl);
            $sitemapPath = FCPATH . 'sitemap.xml';
            file_put_contents($sitemapPath, $xml->asXML());
            $urlCount = count($xml->url);

            return $this->response->setJSON([
                'status' => 'success',
                'message' => "Sitemap berhasil dibuat dengan {$urlCount} URL",
                'path' => $sitemapPath,
                'url' => base_url('sitemap.xml')
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Gagal membuat sitemap: ' . $e->getMessage()
            ]);
        }
    }

    public function refresh()
    {
        cache()->delete('sitemap_xml');
        return $this->generate();
    }
}
