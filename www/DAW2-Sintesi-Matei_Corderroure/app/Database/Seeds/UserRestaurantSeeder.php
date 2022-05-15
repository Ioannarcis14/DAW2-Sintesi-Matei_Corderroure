<?php

namespace App\Database\Seeds;

use App\Models\OrderDishSupplementModel;
use App\Models\UserRestaurantModel;
use CodeIgniter\Database\Seeder;

class UserRestaurantSeeder extends Seeder
{
    public function run()
    {
        $userRest = model(UserRestaurantModel::class);

        $row = [
            'id_user' => 2,
            'id_restaurant' => 1,
        ];

        $userRest->insert($row);
    }
}
