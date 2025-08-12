<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBerandaContent extends Migration
{
   public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'judul_utama' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'subjudul' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'deskripsi' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'gambar_hero' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['aktif', 'nonaktif'],
                'default'    => 'aktif',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('beranda_content');

        // Insert default data
        $data = [
            'judul_utama' => 'Selamat Datang di AgriConnect',
            'subjudul' => 'Platform Terpercaya untuk Petani & Peternak Indonesia',
            'deskripsi' => 'Dapatkan informasi, konsultasi, dan panduan terlengkap untuk mengembangkan usaha pertanian dan peternakan Anda dengan teknologi modern dan bimbingan ahli.',
            'gambar_hero' => 'hero-farming.jpg',
            'status' => 'aktif',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $this->db->table('beranda_content')->insert($data);
    }

    public function down()
    {
        $this->forge->dropTable('beranda_content');
    }
}
