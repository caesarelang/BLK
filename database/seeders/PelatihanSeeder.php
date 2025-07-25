<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pelatihan;

class PelatihanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Data Pelatihan
        $pelatihans = [
            [
                'nama_pelatihan' => 'Pelatihan Desain Grafis Profesional dengan Adobe Suite',
                'deskripsi' => 'Kuasai Adobe Photoshop, Illustrator, dan InDesign untuk menjadi desainer grafis andal. Cocok untuk pemula hingga menengah.',
                'tanggal_mulai' => '2025-08-04 09:00:00',
                'tanggal_berakhir' => '2025-08-08 16:00:00',
                'lokasi' => 'Balai Latihan Kerja (BLK) Plemahan',
                'kuota' => 30,
                'url_foto_pelatihan' => 'https://fgsvlkovvrtnlyxuxpkm.supabase.co/storage/v1/object/public/images//vecteezy_graphic-designer-s-workspace_1268226%20(1).jpg',
            ],
            [
                'nama_pelatihan' => 'Workshop Barista: Dari Biji Kopi hingga Secangkir Espresso',
                'deskripsi' => 'Belajar teknik dasar menyeduh kopi, kalibrasi grinder, latte art, dan manajemen kedai kopi dari para ahli.',
                'tanggal_mulai' => '2025-08-11 10:00:00',
                'tanggal_berakhir' => '2025-08-13 15:00:00',
                'lokasi' => 'Balai Latihan Kerja (BLK) Plemahan',
                'kuota' => 20,
                'url_foto_pelatihan' => 'https://fgsvlkovvrtnlyxuxpkm.supabase.co/storage/v1/object/public/images//medium-vecteezy_barista-pouring-cream-in-cup_1259395_medium%20(1).jpg',
            ],
            [
                'nama_pelatihan' => 'Kursus Menjahit dan Desain Pola Pakaian Wanita',
                'deskripsi' => 'Pelajari cara membuat pola dasar, teknik menjahit dengan mesin, hingga menyelesaikan sebuah gaun sederhana.',
                'tanggal_mulai' => '2025-08-18 09:00:00',
                'tanggal_berakhir' => '2025-08-29 16:00:00',
                'lokasi' => 'Balai Latihan Kerja (BLK) Plemahan',
                'kuota' => 25,
                'url_foto_pelatihan' => 'https://fgsvlkovvrtnlyxuxpkm.supabase.co/storage/v1/object/public/images//medium-vecteezy_person-sewing-blue-fabric_1946989_medium%20(1).jpg',
            ],
        ];

        foreach ($pelatihans as $pelatihan) {
            Pelatihan::create($pelatihan);
        }
    }
}
