<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AllergenMigration extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'name'          => [
                'type'           => 'CHAR',
                'constraint'     => '255',
                'null'           => false,
            ],
        ]);
        $this->forge->addPrimaryKey('id', true);
        $this->forge->createTable('allergen');
    }

    public function down()
    {
        $this->forge->dropTable('allergen');
    }
}
