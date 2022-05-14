<?php

namespace App\Database\Seeds;

use App\Models\OrderModel;
use App\Models\SupplementModel;
use CodeIgniter\Database\Seeder;

class AddSupplementSeeder extends Seeder
{
    public function run()
    {
        $supplement = model(SupplementModel::class);

        $row = [
            'description' => 'Envelope of ketchup',
            'name' => 'Ketchup',
        ];

        $supplement->insert($row);

        $row2 = [
            'description' => 'In a cubic packaging',
            'name' => 'BBQ Sauce',
        ];

        $supplement->insert($row2);
    }
}
