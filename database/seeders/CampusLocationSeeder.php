<?php

namespace Database\Seeders;

use App\Models\CampusLocation;
use Illuminate\Database\Seeder;

class CampusLocationSeeder extends Seeder
{
    public function run(): void
    {
        $locations = [
            ['name' => 'Registrar', 'usage_scope' => 'visit', 'description' => 'Visitor purpose destination', 'sort_order' => 10],
            ['name' => 'Academic Building', 'usage_scope' => 'visit', 'description' => 'Visitor purpose destination', 'sort_order' => 20],
            ['name' => 'Science Building', 'usage_scope' => 'visit', 'description' => 'Visitor purpose destination', 'sort_order' => 30],
            ['name' => 'Architecture Building', 'usage_scope' => 'visit', 'description' => 'Visitor purpose destination', 'sort_order' => 40],
            ['name' => 'Technology Building', 'usage_scope' => 'visit', 'description' => 'Visitor purpose destination', 'sort_order' => 50],
            ['name' => 'EVSU Library', 'usage_scope' => 'visit', 'description' => 'Visitor purpose destination', 'sort_order' => 60],
            ['name' => 'Graduate School', 'usage_scope' => 'visit', 'description' => 'Visitor purpose destination', 'sort_order' => 70],
            ['name' => 'College Building', 'usage_scope' => 'visit', 'description' => 'Visitor purpose destination', 'sort_order' => 80],
            ['name' => 'Gabaldon Building', 'usage_scope' => 'visit', 'description' => 'Visitor purpose destination', 'sort_order' => 90],
            ['name' => 'EVSU Landmark', 'usage_scope' => 'visit', 'description' => 'Visitor purpose destination', 'sort_order' => 100],
            ['name' => 'EVSU Executive House', 'usage_scope' => 'visit', 'description' => 'Visitor purpose destination', 'sort_order' => 110],
            ['name' => 'Leyte Sports Development Center', 'usage_scope' => 'visit', 'description' => 'Visitor purpose destination', 'sort_order' => 120],
            ['name' => 'Leyte Sports Academy', 'usage_scope' => 'visit', 'description' => 'Visitor purpose destination', 'sort_order' => 130],
            ['name' => 'City Central School', 'usage_scope' => 'visit', 'description' => 'Visitor purpose destination', 'sort_order' => 140],
            ['name' => 'Cafeteria', 'usage_scope' => 'visit', 'description' => 'Visitor purpose destination', 'sort_order' => 150],
            ['name' => 'Auditorium', 'usage_scope' => 'visit', 'description' => 'Visitor purpose destination', 'sort_order' => 160],

            ['name' => 'Main Gate (Entrance Gate)', 'usage_scope' => 'scanner', 'description' => 'Scanner station location', 'sort_order' => 10],
            ['name' => 'Main Gate (Exit Gate)', 'usage_scope' => 'scanner', 'description' => 'Scanner station location', 'sort_order' => 20],
            ['name' => "Registrar's Office", 'usage_scope' => 'scanner', 'description' => 'Scanner station location', 'sort_order' => 30],
            ['name' => "Dean's Office", 'usage_scope' => 'scanner', 'description' => 'Scanner station location', 'sort_order' => 40],
            ['name' => 'Accounting Department', 'usage_scope' => 'scanner', 'description' => 'Scanner station location', 'sort_order' => 50],
            ['name' => 'University Library', 'usage_scope' => 'scanner', 'description' => 'Scanner station location', 'sort_order' => 60],
        ];

        foreach ($locations as $location) {
            CampusLocation::updateOrCreate(
                [
                    'name' => $location['name'],
                    'usage_scope' => $location['usage_scope'],
                ],
                $location
            );
        }
    }
}