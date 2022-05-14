<?php

namespace App\Database\Seeds;

use App\Models\OrderDishSupplementModel;
use CodeIgniter\Database\Seeder;

class OrderDishSupplementSeeder extends Seeder
{
    public function run()
    {
        $orderDishSupp = model(OrderDishSupplementModel::class);

        $row = [
            'id_order_dish' => 1,
            'id_supplement' => 1,
        ];

        $orderDishSupp->insert($row);
    }
}
