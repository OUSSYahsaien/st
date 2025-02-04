<?php

namespace Database\Seeders;

use App\Models\Administration;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Administration::factory()->create([
        //     'username' => 'Riham',
        //     'email' => 'riham@tecdata.es',
        //     'password' => bcrypt('securepassword'),
        //     'image_name' => 'riham_avatar.png',
        // ]);
        
        $this->call([
            // OffersSeeder::class,
            CompanySectorSeeder::class,
        ]);
    }
}
