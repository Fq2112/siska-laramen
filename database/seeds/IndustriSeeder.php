<?php

use Illuminate\Database\Seeder;
use App\Industri;

class IndustriSeeder extends Seeder
{
    const INDUSTRI = [
        'Agribisnis',
        'Akuntan',
        'Alas Kaki',
        'Asuransi',
        'Bioteknologi / biologi',
        'Biro Perjalanan',
        'Kertas',
        'Desain Interior',
        'E-Commerce',
        'Ekspedisi / Agen cargo',
        'Elektronika',
        'Energi',
        'Farmasi',
        'Furnitur',
        'Garmen / Tekstil',
        'Hiburan',
        'Hotel',
        'Hukum',
        'Internet',
        'Jasa Pemindahan',
        'Jasa Pengamanan',
        'Kecantikan',
        'Kehutanan',
        'Kelautan',
        'Keramik',
        'Keuangan / Bank',
        'Kimia',
        'Komputer (IT Hardware)',
        'Komputer / TI',
        'Konstruksi',
        'Konsultan',
        'Kosmetik',
        'Kulit',
        'Kurir',
        'Logam',
        'Logistik',
        'Mainan',
        'Makanan Dan Minuman',
        'Manajemen Fasilitas',
        'Manufaktur',
        'Media',
        'Mekanik / Listrik',
        'Mesin / Peralatan',
        'Minyak dam Gas',
        'Otomotif',
        'Pemerintahan',
        'Pendidikan',
        'Penerbangan',
        'Perawatan Kesehatan',
        'Percetakan',
        'Perdagangan Komoditas',
        'Perdagangan Umum',
        'Pergudangan',
        'Perikanan',
        'Periklanan',
        'Permata dan Perhiasan',
        'Pertambangan dan Mineral',
        'Produk Konsumen',
        'Properti',
        'Pupuk Pestisida',
        'Ritel',
        'Servis',
        'Telekomunikasi',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (static::INDUSTRI as $industri) {
            Industri::create([
                'nama' => $industri
            ]);
        }
        Industri::where('id', 52)->update(['icon' => '1.svg']);
        Industri::where('id', 26)->update(['icon' => '2.svg']);
        Industri::where('id', 29)->update(['icon' => '3.svg']);
        Industri::where('id', 61)->update(['icon' => '4.svg']);
        Industri::where('id', 40)->update(['icon' => '5.svg']);
        Industri::where('id', 38)->update(['icon' => '6.svg']);
        Industri::where('id', 58)->update(['icon' => '7.svg']);
        Industri::where('id', 30)->update(['icon' => '8.svg']);
        Industri::where('id', 47)->update(['icon' => '9.svg']);
        Industri::where('id', 13)->update(['icon' => '10.svg']);
        Industri::where('id', 59)->update(['icon' => '11.svg']);
        Industri::where('id', 62)->update(['icon' => '12.svg']);
        Industri::where('id', 63)->update(['icon' => '13.svg']);
        Industri::where('id', 4)->update(['icon' => '14.svg']);
        Industri::where('id', 45)->update(['icon' => '15.svg']);
        Industri::where('id', 49)->update(['icon' => '16.svg']);
        Industri::where('id', 41)->update(['icon' => '17.svg']);
        Industri::where('id', 9)->update(['icon' => '18.svg']);
    }
}
