<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pengumuman;

class PengumumanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pengumuman::create([
            'judul' => 'Pendaftaran Gelombang Baru Telah Dibuka!',
            'isi' => 'Kami dengan gembira mengumumkan bahwa pendaftaran untuk program pelatihan gelombang terbaru kini telah resmi dibuka. Segera daftarkan diri Anda dan amankan tempat di kejuruan favorit Anda sebelum kuota terpenuhi.',
            'is_published' => true,
        ]);

        Pengumuman::create([
            'judul' => 'Jadwal Seleksi Peserta Pelatihan',
            'isi' => 'Bagi para calon peserta yang telah mendaftar, jadwal untuk seleksi akan diumumkan pada tanggal 1 Agustus 2025. Harap memantau terus halaman ini dan email Anda untuk informasi lebih lanjut mengenai detail waktu dan teknis pelaksanaan seleksi.',
            'is_published' => true,
        ]);

        Pengumuman::create([
            'judul' => 'Perawatan Sistem Website',
            'isi' => 'Akan diadakan perawatan rutin pada sistem website pada hari Sabtu, 27 Juli 2025 pukul 00:00 hingga 03:00 WIB. Selama periode tersebut, beberapa fitur mungkin tidak dapat diakses. Mohon maaf atas ketidaknyamanannya.',
            'is_published' => false,
        ]);
    }
}
