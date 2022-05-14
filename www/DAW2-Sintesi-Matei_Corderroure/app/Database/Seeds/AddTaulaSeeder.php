<?php

namespace App\Database\Seeds;

use App\Models\SupplementModel;
use App\Models\TableModel;
use CodeIgniter\Database\Seeder;

class AddTaulaSeeder extends Seeder
{
    public function run()
    {
        $table = model(TableModel::class);

        $row = [
            'id' => 1,
            'id_restaurant' => 1,
            'toTakeAway' => 1,
        ];

        $table->insert($row);

        $row2 = [
            'id' => 2,
            'id_restaurant' => 2,
            'toTakeAway' => 1,
        ];

        $table->insert($row2);

        $row3 = [
            'id' => 3,
            'id_restaurant' => 1,
            'toTakeAway' => 1,
        ];

        $table->insert($row3);
    }
}
