<?php

namespace App\Database\Seeds;

use App\Models\OrderDishModel;
use CodeIgniter\Database\Seeder;

class OrderDishSeeder extends Seeder
{
    public function run()
    {
        $orderDish = model(OrderDishModel::class);

        $row = [
            'id_order' => 1,
            'id_dish' => 4,
            'quantity' => 1,
            'observation' => "Remove cheese",
            'startTime' => '1652531611',
            'finishedTime' => '1652535211',
            'state' => 'finished',
            'lastTimeAction' => '1652535211',
        ];

        $orderDish->insert($row);
    }
}
