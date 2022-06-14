<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\ThemeModel;

class ThemeSeeder extends Seeder
{
    public function run()
    {
        //
        $theme = model(ThemeModel::class);

        $row = [
            'name' => "Bugs or glitches in the website",
        ];
        
        $theme->insert($row);

        $row = [
            'name' => "The profile page doesn't work properly",
        ];

        $theme->insert($row);

        $row = [
            'name' => "I cannot discharge my restaurant",
        ];

        $theme->insert($row);

        $row = [
            'name' => "There's a missing component in the webpage of my restaurant",
        ];

        $theme->insert($row);
    }
}
