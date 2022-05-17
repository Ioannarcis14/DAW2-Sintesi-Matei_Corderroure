<?php

namespace App\Database\Seeds;

use App\Models\CategoryModel;
use CodeIgniter\Database\Seeder;

class AddCategorySeeder extends Seeder
{
    public function run()
    {
        $category = model(CategoryModel::class);

        $row = [
            'id_restaurant'   => 2,
            'id_category_parent' => null,
            'name' => 'Menu of the day',
            'observation_msg' => '',
        ];

        $category->insert($row);

        $row2 = [
            'id_restaurant'   => 2,
            'id_category_parent' => 1,
            'name' => 'First Course',
            'observation_msg' => '',
        ];

        $category->insert($row2);

        $row3 = [
            'id_restaurant'   => 2,
            'id_category_parent' => 1,
            'name' => 'Second Course',
            'observation_msg' => '',
        ];

        $category->insert($row3);

        $row4 = [
            'id_restaurant'   => 2,
            'id_category_parent' => null,
            'name' => 'Kids Menu ',
            'observation_msg' => 'Must have below 12 years old to order the menu',
        ];

        $category->insert($row4);
    }
}
