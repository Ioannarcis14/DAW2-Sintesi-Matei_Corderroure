<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TaulaMigration extends Migration
{
    public function up()
    {
            $this->forge->addField([
                    'id'          => [
                            'type'           => 'INT',
                            'auto_increment' => true,
                            'constraint'     => 11,
                            'unsigned'       => true,
                            'null'           => false,
                    ],
                    'id_restaurant'          => [
                            'type'           => 'INT',
                            'constraint'     => 11,
                            'unsigned'       => true,
                            'null'           => false,
                    ],
                    'toTakeAway'          => [
                            'type'           => 'INT',
                            'constraint'     => 1,
                            'unsigned'       => true,
                            'null'           => true,
                    ],
            ]);
            $this->forge->addPrimaryKey('id', true);
            $this->forge->addForeignKey('id_restaurant', 'restaurant', 'id', 'CASCADE', 'CASCADE');
            $this->forge->createTable('table');

    }
    
    public function down()
    {
            $this->forge->dropTable('table');
    }
}
