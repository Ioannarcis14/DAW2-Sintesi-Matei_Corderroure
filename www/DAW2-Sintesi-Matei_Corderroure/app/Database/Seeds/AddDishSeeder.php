<?php

namespace App\Database\Seeds;

use App\Models\AllergenModel;
use App\Models\DishModel;
use CodeIgniter\Database\Seeder;

class AddDishSeeder extends Seeder
{
    public function run()
    {
        $dish = model(DishModel::class);

        $row = [
            'description' => 'Made with glamour pasta and incredible dedication',
            'name' => 'Pasta Carbonara',
            'price' => 8.45,
            'imgs' => 'public/img/dish.jpg',
            'short_description' => 'Includes spaghetti, béchamel sauce, bacon, oregano',
        ];

        $dish->insert($row);

        $row2 = [
            'description' => 'Made with artisanal stone oven',
            'name' => 'Pizza Margarita',
            'price' => 9.99,
            'imgs' => 'public/img/dish2.jpg',
            'short_description' => 'Includes Mozzarella, tomato and albahaca',
        ];

        $dish->insert($row2);

        $row3 = [
            'description' => 'Stuffed with maced meat ',
            'name' => 'Meat Raviolis',
            'price' => 6.77,
            'imgs' => 'public/img/dish3.jpg',
            'short_description' => 'Includes Ravioli Pasta, meat, béchamel',
        ];

        $dish->insert($row3);


        $row4 = [
            'description' => 'Try out the Hamburger that makes you live Switzerland with your taste buds',
            'name' => 'Swiss Hamburger',
            'price' => 10.00,
            'imgs' => 'public/img/dish4.jpg',
            'short_description' => 'Sesame bread, fondue cheese, cow burger meat, cherry tomatoes',
        ];

        $dish->insert($row4);
    }
}
