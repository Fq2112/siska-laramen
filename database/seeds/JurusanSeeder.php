<?php

use Illuminate\Database\Seeder;
use App\Jurusanpend;

class JurusanSeeder extends Seeder
{
    const JURUSAN = [
        'Administrasi Bisnis Keuangan',
        'Administrasi Bisnis Menajamen',
        'Administrasi Perkantoran',
        'Agroteknologi',
        'Ahli Gizi',
        'Akutansi',
        'Antropologi Sosial',
        'Arkeologi',
        'Arsitektur',
        'Bahasa China',
        'Bahasa Inggris',
        'Bahasa Indonesia',
        'Bahasa Jepang',
        'Bahasa Jerman',
        'Bahasa Prancis',
        'Bidan',
        'Bimbingan Konseling',
        'Bio Kimia',
        'Bio Teknologi',
        'Budidaya PErairan',
        'Desain Interior',
        'Desain Komunikasi Visual',
        'Dsain Produk',
        'Ekonomi Pembangunan',
        'Elektronika',
        'Farmasi',
        'Fotografi',
        'Geofisika',
        'Geografi',
        'Geologi',
        'Hubungan Internasinal',
        'Hukum',
        'Ilmu Administrasi FIskal',
        'Ilmu Administrasi Negara',
        'Ilmu Agama',
        'Ilmu Biologi',
        'Ilmu Filsafat',
        'Ilmu Fisika',
        'Ilmu Kelautan',
        'Ilmu Perairan',
        'Ilmu kimia',
        'Ilmu Komputer',
        'Ilmu Komunikasi',
        'Ilmu Perpustakaan',
        'Ilmu Sosial Politik',
        'Jurnalistik',
        'Kedokteran Gigi',
        'Kedokteran Hewan',
        'Kedokteran Umum',
        'Kehutanan',
        'Kesehatan Masyarakat',
        'Lingkungan Hidup',
        'Makanan Dan Minuman',
        'Manajemen Informatika',
        'Manajemen',
        'Manajemen Transportasi',
        'Matematika Dan Statistika',
        'Meteorologi',
        'Musik',
        'Pariwisata dan Perhotelan',
        'Teknik Biomedis',
        'Teknik Ekologi',
        'Teknik Elektro',
        'Teknik Geodesi',
        'Teknik Industri',
        'Teknik Informatia',
        'Teknik Instrumentasi',
        'Teknik Kimia',
        'Teknik Komputer',
        'Teknik Lainnya',
        'Teknik Mesin',
        'Teknik Nuklir',
        'Teknik Perkapalan',
        'Teknik Pertambangan',
        'Teknik Perminyakan',
        'Teknik Pertanian',

    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (static::JURUSAN as $kota) {
            Jurusanpend::create([
                'name' => $kota
            ]);
        }
    }
}
