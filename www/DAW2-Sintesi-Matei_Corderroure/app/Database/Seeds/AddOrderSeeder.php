<?php

namespace App\Database\Seeds;

use App\Models\OrderModel;
use CodeIgniter\Database\Seeder;

class AddOrderSeeder extends Seeder
{
    public function run()
    {
        $order = model(OrderModel::class);
        
        $row = [
            'id_restaurant' => 2,
            'id_client' => 1,
            'id_taula' => 2,
            'diners' => 3,
            'state' => 'preparing',
            'timestamp' => '2000-12-1 12:12:12',
        ];

        $order->insert($row);
        

        $row2 = [
            'id_restaurant' => 1,
            'id_client' => 5,
            'id_taula' => 1,
            'diners' => 2,
            'state' => 'preparing',
            'timestamp' => '2000-12-1 12:12:12',
        ];

        $order->insert($row2);
    }
}
