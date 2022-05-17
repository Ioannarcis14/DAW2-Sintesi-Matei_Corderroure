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
            'name' => "Cereals, gluten...",
        ];
        
        $theme->insert($row);

        $row = [
            'name' => "Crustàcis",
        ];

        $theme->insert($row);

        $row = [
            'name' => "Ous o derivats",
        ];

        $theme->insert($row);

        $row = [
            'name' => "Peix",
        ];

        $theme->insert($row);

        $row = [
            'name' => "Cacauets",
        ];

        $theme->insert($row);

        $row = [
            'name' => "Soja",
        ];

        $theme->insert($row);

        $row = [
            'name' => "Llet i derivats",
        ];

        $theme->insert($row);

        $row = [
            'name' => "Fruits secs",
        ];

        $theme->insert($row);

        $row = [
            'name' =>"Api i derivats",
        ];

        $theme->insert($row);

        $row = [
            'name' => "Mostassa i derivats",
        ];

        $theme->insert($row);

        $row = [
            'name' => "Sessam i derivats",
        ];

        $theme->insert($row);

        $row = [
            'name' => "Sulfits",
        ];

        $theme->insert($row);

        $row = [
            'name' => "Tramús i productes amb base tramusos",
        ];

        $theme->insert($row);

        $row = [
            'name' => "Moluscos i productes amb base molusc",
        ];

        $theme->insert($row);
    }
}
