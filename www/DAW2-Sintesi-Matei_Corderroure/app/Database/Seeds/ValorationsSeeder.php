<?php

namespace App\Database\Seeds;

use App\Models\ValorationsModel;
use CodeIgniter\Database\Seeder;

class ValorationsSeeder extends Seeder
{
    public function run()
    {
        $valorations = model(ValorationsModel::class);

        $row = [
            'id_restaurant' => 1,
            'id_user' => 1,
            'score' => 9,
            'review' => 'I really enjoyed the food, too bad it had a bit expensive price'
        ];

        $valorations->insert($row);

        $row2 = [
            'id_restaurant' => 1,
            'id_user' => 2,
            'score' => 7,
            'review' => 'It was a bit saltier'
        ];

        $valorations->insert($row2);

        $row3 = [
            'id_restaurant' => 1,
            'id_user' => 3,
            'score' => 4,
            'review' => 'Served cold and I can see they bought frozen food'
        ];

        $valorations->insert($row3);

        $row4 = [
            'id_restaurant' => 2,
            'id_user' => 2,
            'score' => 10,
            'review' => 'I will come back to eat here with my whole family'
        ];

        $valorations->insert($row4);
    }
}
