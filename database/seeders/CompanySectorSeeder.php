<?php

namespace Database\Seeders;

use App\Models\Administration;
use App\Models\CompanySector;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySectorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sectors = [
            'Technology',
            'Healthcare',
            'Education',
            'Finance',
            'Manufacturing',
            'Retail',
            'Construction',
            'Real Estate',
            'Transportation',
            'Agriculture',
        ];


        // foreach ($sectors as $sector) {
        //     CompanySector::create(['name' => $sector]);
        // }

        Administration::create([
            'username' => 'Riham',
            'email' => 'riham@tecdata.es',
            'password' => bcrypt('securepassword'),
            'image_name' => 'riham_avatar.png',
        ]);
    }
}
