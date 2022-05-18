<?php

namespace App\Database\Seeds;

use App\Models\DishAllergenModel;
use CodeIgniter\Database\Seeder;

class DishAllergenSeeder extends Seeder
{
    public function run()
    {
        $dishAll = model(DishAllergenModel::class);

        $row = [
            'id_allergen' => 4,
            'id_dish' => 1,
        ];

        $dishAll->insert($row);
    }
}
