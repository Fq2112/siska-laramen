<?php

use Illuminate\Database\Seeder;
use App\Provinces;

class ProvinceSeeder extends Seeder
{
    const PROVINCES = [
        'DI-Aceh',
        'Sumatera Utara',
        'Sumatera Barat',
        'Riau',
        'Kepulauan Riau',
        'Jambi',
        'Bengkulu',
        'Sumatera Selatan',
        'Kepulauan Bangka Belitung',
        'Lampung',
        'Banten',
        'Jawa Barat',
        'DKI-Jakarta',
        'Jawa Tengah',
        'DI-Yogyakarta',
        'Jawa Timur',
        'Bali',
        'Nusa Tenggara Barat',
        'Nusa Tenggara Timur',
        'Kalimantan Barat',
        'Kalimantan Selatan',
        'Kalimantan Tengah',
        'Kalimantan Timur',
        'Kalimantan Utara',
        'Gorontalo',
        'Sulawesi Selatan',
        'Sulawesi Tenggara',
        'Sulawesi Tengah',
        'Sulawesi Utara',
        'Sulawesi Barat',
        'Maluku',
        'Maluku Utara',
        'Papua',
        'Papua Barat',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (static::PROVINCES as $province) {
            Provinces::create([
                'name' => $province
            ]);
        }
    }
}
