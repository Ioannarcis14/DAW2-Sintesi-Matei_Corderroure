<?php

namespace App\Database\Seeds;

use App\Models\DishSupplementModel;
use CodeIgniter\Database\Seeder;

class DishSupplementSeeder extends Seeder
{
    public function run()
    {
        $dishSup = model(DishSupplementModel::class);

        $row = [
            'id_supplement' => 1,
            'id_dish' => 4,
        ];

        $dishSup->insert($row);

        $row2 = [
            'id_supplement' => 2,
            'id_dish' => 4,
        ];

        $dishSup->insert($row2);
    }
}
