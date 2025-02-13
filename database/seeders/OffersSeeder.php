<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OffersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('offers')->insert([
            [
                'id_company' => 1,
                'title' => 'Développeur Backend',
                'nbr_candidat_max' => 5,
                'nbr_candidat_confermed' => 0,
                'place' => 'Paris, France',
                'work_type' => 'Tiempo completo',
                'starting_salary' => 3500.00,
                'final_salary' => 4500.00,
                'category' => 'Informatique',
                'experience_years' => 3,
                'priority' => 'yes',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_company' => 2,
                'title' => 'Analyste des données',
                'nbr_candidat_max' => 4,
                'nbr_candidat_confermed' => 2,
                'place' => 'Lyon, France',
                'work_type' => 'Hibrido',
                'starting_salary' => 3000.00,
                'final_salary' => 4000.00,
                'category' => 'Informatique',
                'experience_years' => 2,
                'priority' => 'no',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_company' => 3,
                'title' => 'Chef de Projet IT',
                'nbr_candidat_max' => 3,
                'nbr_candidat_confermed' => 1,
                'place' => 'Bruxelles, Belgique',
                'work_type' => 'Remoto',
                'starting_salary' => 5000.00,
                'final_salary' => 6000.00,
                'category' => 'Informatique',
                'experience_years' => 5,
                'priority' => 'yes',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_company' => 4,
                'title' => 'Designer UI/UX',
                'nbr_candidat_max' => 6,
                'nbr_candidat_confermed' => 0,
                'place' => 'Madrid, Espagne',
                'work_type' => 'Media jornada',
                'starting_salary' => 2000.00,
                'final_salary' => 2500.00,
                'category' => 'Informatique',
                'experience_years' => 1,
                'priority' => 'no',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_company' => 5,
                'title' => 'Architecte logiciel',
                'nbr_candidat_max' => 2,
                'nbr_candidat_confermed' => 1,
                'place' => 'Berlin, Allemagne',
                'work_type' => 'Jornada intensiva',
                'starting_salary' => 7000.00,
                'final_salary' => 8000.00,
                'category' => 'Informatique',
                'experience_years' => 8,
                'priority' => 'yes',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_company' => 6,
                'title' => 'Spécialiste Sécurité Informatique',
                'nbr_candidat_max' => 4,
                'nbr_candidat_confermed' => 0,
                'place' => 'Casablanca, Maroc',
                'work_type' => 'Tiempo completo',
                'starting_salary' => 4000.00,
                'final_salary' => 5000.00,
                'category' => 'Informatique',
                'experience_years' => 4,
                'priority' => 'no',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_company' => 7,
                'title' => 'Ingénieur DevOps',
                'nbr_candidat_max' => 3,
                'nbr_candidat_confermed' => 1,
                'place' => 'Lisbonne, Portugal',
                'work_type' => 'Hibrido',
                'starting_salary' => 4500.00,
                'final_salary' => 5500.00,
                'category' => 'Informatique',
                'experience_years' => 3,
                'priority' => 'yes',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_company' => 8,
                'title' => 'Développeur Full Stack',
                'nbr_candidat_max' => 5,
                'nbr_candidat_confermed' => 0,
                'place' => 'Tunis, Tunisie',
                'work_type' => 'Remoto',
                'starting_salary' => 3000.00,
                'final_salary' => 4000.00,
                'category' => 'Informatique',
                'experience_years' => 2,
                'priority' => 'no',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_company' => 9,
                'title' => 'Expert Cloud Computing',
                'nbr_candidat_max' => 2,
                'nbr_candidat_confermed' => 0,
                'place' => 'Dubaï, EAU',
                'work_type' => 'Tiempo completo',
                'starting_salary' => 7000.00,
                'final_salary' => 9000.00,
                'category' => 'Informatique',
                'experience_years' => 6,
                'priority' => 'yes',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_company' => 10,
                'title' => 'Développeur Mobile',
                'nbr_candidat_max' => 4,
                'nbr_candidat_confermed' => 1,
                'place' => 'Montréal, Canada',
                'work_type' => 'Hibrido',
                'starting_salary' => 3500.00,
                'final_salary' => 4500.00,
                'category' => 'Informatique',
                'experience_years' => 3,
                'priority' => 'no',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_company' => 11,
                'title' => 'Administrateur Réseau',
                'nbr_candidat_max' => 3,
                'nbr_candidat_confermed' => 1,
                'place' => 'Dakar, Sénégal',
                'work_type' => 'Media jornada',
                'starting_salary' => 2500.00,
                'final_salary' => 3500.00,
                'category' => 'Informatique',
                'experience_years' => 2,
                'priority' => 'no',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_company' => 12,
                'title' => 'Ingénieur Big Data',
                'nbr_candidat_max' => 5,
                'nbr_candidat_confermed' => 0,
                'place' => 'New York, USA',
                'work_type' => 'Tiempo completo',
                'starting_salary' => 8000.00,
                'final_salary' => 10000.00,
                'category' => 'Informatique',
                'experience_years' => 5,
                'priority' => 'yes',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_company' => 13,
                'title' => 'Consultant IT',
                'nbr_candidat_max' => 4,
                'nbr_candidat_confermed' => 0,
                'place' => 'Rome, Italie',
                'work_type' => 'Jornada intensiva',
                'starting_salary' => 6000.00,
                'final_salary' => 7500.00,
                'category' => 'Informatique',
                'experience_years' => 4,
                'priority' => 'no',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
