<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SupplementMigration extends Migration
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
            'description'          => [
                'type'           => 'TEXT',
                'null'           => false,
            ],
            'name'          => [
                'type'           => 'CHAR',
                'constraint'     => '255',
                'null'           => false,
            ],
            'price'          => [
                'type'           => 'FLOAT',
                'constraint'     => '10',
                'unsigned'       => true,
                'null'           => false,
            ],
        ]);
        $this->forge->addPrimaryKey('id', true);
        $this->forge->createTable('supplement');
    }

    public function down()
    {
        $this->forge->dropTable('supplement');
    }
}
