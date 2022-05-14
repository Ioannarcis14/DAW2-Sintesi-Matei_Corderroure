<?php

namespace App\Database\Seeds;

use App\Models\DishModel;
use App\Models\MessagesModel;
use CodeIgniter\Database\Seeder;

class AddMessageSeeder extends Seeder
{
    public function run()
    {
        $message = model(MessagesModel::class);

        $row = [
            'id_user'   => 1,
            'id_restaurant' => 2,
            'theme' => 'issue',
            'message' => 'I profile image is not showing correctly',
        ];

        $message->insert($row);

        $row2 = [
            'id_user'   => 2,
            'id_restaurant' => 1,
            'theme' => 'improvement',
            'message' => 'May you guys add your own promo payment card?',
        ];

        $message->insert($row2);
    }
}
