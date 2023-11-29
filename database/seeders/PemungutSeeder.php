<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pemungut;

class PemungutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pemunguts = [
            "namejidentitas" => "KTP",
            "noidentitas" => "1251038765430004",
            "namedipungut" => "Santosa",
         ];
         Pemungut::create($pemunguts);
    }
}
