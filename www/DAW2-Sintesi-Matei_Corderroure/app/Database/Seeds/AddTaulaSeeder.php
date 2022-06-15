<?php

namespace App\Database\Seeds;

use App\Models\TaulaModel;
use CodeIgniter\Database\Seeder;

class AddTaulaSeeder extends Seeder
{
    public function run()
    {
        $table = model(TaulaModel::class);

        $row = [
            'id' => 1,
            'id_restaurant' => 1,
            'toTakeAway' => 1,
            'state' => 1,
        ];

        $table->insert($row);

        $row2 = [
            'id' => 2,
            'id_restaurant' => 2,
            'toTakeAway' => 1,
            'state' => 1,
        ];

        $table->insert($row2);

        $row3 = [
            'id' => 3,
            'id_restaurant' => 1,
            'toTakeAway' => 1,
            'state' => null,
        ];

        $table->insert($row3);

        $row4 = [
            'id' => 4,
            'id_restaurant' => 2,
            'toTakeAway' => 1,
            'state' => null,
        ];

        $table->insert($row4);

        $row5 = [
            'id' => 5,
            'id_restaurant' => 2,
            'toTakeAway' => 1,
            'state' => null,
        ];

        $table->insert($row5);

        $row6 = [
            'id' => 6,
            'id_restaurant' => 2,
            'toTakeAway' => 1,
            'state' => null,
        ];

        $table->insert($row6);

        $row7 = [
            'id' => 7,
            'id_restaurant' => 2,
            'toTakeAway' => 1,
            'state' => null,
        ];

        $table->insert($row7);

        $row8 = [
            'id' => 8,
            'id_restaurant' => 2,
            'toTakeAway' => 1,
            'state' => null,
        ];

        $table->insert($row8);
    }
}
