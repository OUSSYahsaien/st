<?php

namespace Database\Seeders;

use App\Models\OfferCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OfferCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OfferCategory::create([
            'name' => 'Développement Web',
            'description' => 'Offres liées au développement de sites et applications web.',
            'offer_id' => 1
        ]);

        OfferCategory::create([
            'name' => 'Développement Mobile',
            'description' => 'Offres concernant le développement d’applications mobiles.',
            'offer_id' => 2
        ]);

        OfferCategory::create([
            'name' => 'Intelligence Artificielle',
            'description' => 'Offres dans le domaine de l’intelligence artificielle et du machine learning.',
            'offer_id' => 3
        ]);

        OfferCategory::create([
            'name' => 'Sécurité Informatique',
            'description' => 'Offres dans la cybersécurité et la protection des systèmes informatiques.',
            'offer_id' => 4
        ]);

        OfferCategory::create([
            'name' => 'Réseaux et Systèmes',
            'description' => 'Offres pour la gestion et l’administration des réseaux et des systèmes informatiques.',
            'offer_id' => 5
        ]);

        OfferCategory::create([
            'name' => 'Big Data',
            'description' => 'Offres dans le traitement et l’analyse de grandes quantités de données.',
            'offer_id' => 6
        ]);
    }
}
