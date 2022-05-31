<?php

namespace App\Database\Seeds;

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
            'price' => 0.50,
        ];

        $supplement->insert($row);

        $row2 = [
            'description' => 'In a cubic packaging',
            'name' => 'BBQ Sauce',
            'price' => 0.60,
        ];

        $supplement->insert($row2);
    }
}
