<?php

namespace App\Database\Seeds;

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

        $row2 = [
            'id_user' => 1,
            'id_restaurant' => 2,
        ];

        $userRest->insert($row2);

        $row3 = [
            'id_user' => 1,
            'id_restaurant' => 2,
        ];

        $userRest->insert($row3);

        $row4 = [
            'id_user' => 1,
            'id_restaurant' => 2,
        ];

        $userRest->insert($row4);

        $row5 = [
            'id_user' => 1,
            'id_restaurant' => 2,
        ];

        $userRest->insert($row5);
    }
}
