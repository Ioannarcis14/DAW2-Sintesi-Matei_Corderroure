<?php

namespace App\Database\Seeds;

use App\Models\RestaurantModel;
use CodeIgniter\Database\Seeder;

class AddRestaurantSeeder extends Seeder
{
    public function run()
    {
        $restaurant = model(RestaurantModel::class);

        $row = [
            'id'   => 1,
            'name' => 'We DEVour',
            'city' => 'Washington DC',
            'street' => 'Lipton St.',
            'postal_code' => 36002,
            'description' => 'We can make your belly happy',
            'phone' => 123332123,
            'social_websites' => 'https://twitter.com/someones_tweet',
            'img_gallery'  => 'public/img/my_rest.jpg,public/img/my_rest2.jpg',
            'discharged' => 1,
        ];

        $restaurant->insert($row);

        $row2 = [
            'id'   => 2,
            'name' => 'RestAura',
            'city' => 'Illinois',
            'street' => 'Pelican St.',
            'postal_code' => 31402,
            'description' => 'Eat Vegan food for half price',
            'phone' => 145689113,
            'social_websites' => 'https://facebook.com/testing',
            'img_gallery'  => 'img/rest.jpeg,public/img/my_rest2.jpg',
            'discharged' => null,
        ];

        $restaurant->insert($row2);

        $row3 = [
            'id'   => 3,
            'name' => 'SpiceNjoy',
            'city' => 'New York',
            'street' => 'Baker St.',
            'postal_code' => 39221,
            'description' => 'New Indian flavours decorate our dishes',
            'phone' => 553882192,
            'social_websites' => 'https://twitter.com/spicey_ali',
            'img_gallery'  => 'img/rest.jpg,img/my_rest2.jpg',
            'discharged' => 1,
        ];


        $restaurant->insert($row3);
    }
}
