<?php

namespace App\Database\Seeds;

use App\Models\AllergenModel;
use App\Models\RestaurantModel;
use CodeIgniter\Database\Seeder;

class AddAllergenSeeder extends Seeder
{
    public function run()
    {
        $allergyModel= model(AllergenModel::class);

        $allergies = ['Cereals', 'Gluten', 'Crustacean', 'Eggs and derivatives', 'Fish', 'Peanut', 'Soy',
            'Milk and derivatives', 'Nuts', 'Celery and derivatives', 'Mustard and derivatives', 'Sesame and derivatives', 'Sulphite',
            'Lupines and lupine-based products', 'Molluscs and mollusc-based products'];

        foreach ($allergies as $allergy) {
            $row = [
                'name' => $allergy,
            ];

            $allergyModel->insert($row);

        }

    }
}
