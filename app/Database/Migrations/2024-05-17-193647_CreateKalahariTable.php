<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKalahariTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'kalahari'        => ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
            'phone'           => ['type' => 'int', 'constraint' => 20],
        ]);

        $this->forge->addKey('kalahari', true);
        $this->forge->createTable('aba_kalahari', true);

        // ##############################
        
        $this->forge->addField([
            'id'            => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'abacus'        => ['type' => 'int', 'constraint' => 11],
            'kalahari'      => ['type' => 'int', 'constraint' => 11],
        ]);

        $this->forge->addKey('abacus', true);
        $this->forge->createTable('aba_address_kalahari', true);
    }

    public function down()
    {
        $this->forge->dropTable('aba_kalahari', true);
        $this->forge->dropTable('aba_address_kalahari', true);
    }
}
