<?php

use Illuminate\Database\Seeder;
use App\FungsiKerja;

class FungsikerjaSeeder extends Seeder
{
    const FUNGSI = [
        'Administrasi',
        'Administrasi Import',
        'Administrasi Export',
        'Ahli Ekonomi',
        'Ahli Gegrafi',
        'Akuntan Perpajakan',
        'Akuntansi Keuangan',
        'Farmasi',
        'Arsitek',
        'Asisten Teknis Kesehatan',
        'Awak Kapal Laut',
        'Awak Penerbangan',
        'Bagian Umum',
        'Bidan',
        'Broker Asuransi',
        'Desain Grafis Komputer',
        'Dokter Gigi',
        'Dokter Hewan',
        'Dokter Umumn',
        'Dokter Spesialis',
        'Editor',
        'Fotografer',
        'Guru / Tentor',
        'Hubungan Masyarakat',
        'Hukum',
        'Jurnalis',
        'Juru Gambar',
        'Juru Masak',
        'Kepala Sekolah',
        'Konsultan',
        'Kurir',
        'Laboratorium',
        'Layanan Pelanggan',
        'Logistik',
        'Maintenance',
        'Makanan Dan Minuman',
        'Manajemen Trainee',
        'Manajemen Merk/Produk',
        'Manajemen Pabrik',
        'Manajemen Properti',
        'Manajemen Proyek',
        'Manajemen Portofolio',
        'Model Fashion',
        'Opersai Gudang',
        'Opersai Hotel',
        'Operasi Perbankan',
        'Opersai Restoran',
        'Operasi Ritel',
        'Operator',
        'Pemandu Wisata',
        'Pemasaran Internet',
        'Pemasaran (Non-Teknis)',
        'Pemasaran (Teknis)',
        'Pemerintahan',
        'Penerjemah',
        'Pemngembangan Bisnis',
        'Pengembangan Produk',
        'Penggajian Dan Faisilitas',
        'Penjualan dan Pemasaran',
        'Penjualan (Non-Teknis)',
        'Penjualan (Teknis)',
        'Penyiar TV/Radio',
        'Periklanan',
        'Perawat',
        'Peternakan',
        'Procurement',
        'Programmer',
        'Quality Control',
        'Reporter',
        'Resepsionis',
        'Riset',
        'Sekretaris',
        'Sekuritas',
        'Staf TIket',
        'Supir',
        'Sumber Daya Manusia',
        'Teknik Elektro',
        'Teknik Jaringan',
        'Teknik Informatika',
        'Teknik Keselamatan',
        'Teknik Komputer',
        'Teknik Perminyakan',
        'Teknisi',
        'Telemarketing',
        'TI, Administrator',
        'TI, Network Engineer',
        'TI, Programmer',
        'TI, System Analys',
        'TI, System Engineer',
        'TI, WEB Developer',
        'TI, Webmaster',
        'Transportasi',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (static::FUNGSI as $fungsi) {
            FungsiKerja::create([
                'nama' => $fungsi
            ]);
        }
    }
}
