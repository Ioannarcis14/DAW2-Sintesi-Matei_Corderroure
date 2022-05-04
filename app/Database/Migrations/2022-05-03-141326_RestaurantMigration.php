<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RestaurantMigration extends Migration
{

    /* 
    Restaurant Data 
    This is the data, the user in charge of the restaurant is capable to modify 
    and it's added the first time when they enroll to the website
    */

    public function up()
    {
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_admin'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'null'           => false,
            ],
            'name'          => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
                'null'           => false,
            ],
            'city'          => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
                'null'           => false,
            ],
            'street'          => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
                'null'           => false,
            ],
            'postal_code'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'null'           => false,
            ],
            'description'          => [
                'type'           => 'TEXT',
                'null'           => false,
            ],
            'phone'          => [
                'type'           => 'INT',
                'constraint'     => 9,
                'unsigned'       => true,
                'null'           => false,
            ],
            'social_websites'          => [
                'type'           => 'TEXT',
            ],
            'img_gallery'          => [
                'type'           => 'TEXT',
                'null'           => false,
            ],
        ]);
        $this->forge->addPrimaryKey('id_restaurant', true);
        $this->forge->createTable('restaurant');
        $this->forge->addForeignKey('id_admin', 'users', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->forge->dropTable('restaurant');
    }
}
