<?php

namespace App\Database\Seeds;

use App\Models\DishAllergenModel;
use App\Models\DishCategoryModel;
use CodeIgniter\Database\Seeder;

class DishCategorySeeder extends Seeder
{
    public function run()
    {
        $dishCat = model(DishCategoryModel::class);

        $row = [
            'id_category' => 1,
            'id_dish' => 1,
        ];

        $dishCat->insert($row);

        $row2 = [
            'id_category' => 2,
            'id_dish' => 1,
        ];

        $dishCat->insert($row2);

        $row3 = [
            'id_category' => 1,
            'id_dish' => 2,
        ];

        $dishCat->insert($row3);

        $row4 = [
            'id_category' => 1,
            'id_dish' => 3,
        ];

        $dishCat->insert($row4);

        $row5 = [
            'id_category' => 1,
            'id_dish' => 4,
        ];

        $dishCat->insert($row5);
    }
}
