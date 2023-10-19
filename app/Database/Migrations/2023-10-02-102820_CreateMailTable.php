<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMailTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'user_id'               => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'type'                  => ['type' => 'varchar', 'constraint' => 50],
            'name'                  => ['type' => 'varchar', 'constraint' => 100, 'null' => true],
            'reply_to'              => ['type' => 'varchar', 'constraint' => 200, 'null' => true],
            'receiver'              => ['type' => 'varchar', 'constraint' => 200, 'null' => true],
            'subject'               => ['type' => 'varchar', 'constraint' => 200],
            'text'                  => ['type' => 'text'],
            'error'                 => ['type' => 'text', 'null' => true],
            'error_retries'         => ['type' => 'int','constraint' => 1, 'null' => true],
            'sent_at'               => ['type' => 'int', 'constraint' => 50, 'null' => true],
            'created_at'            => ['type' => 'int', 'constraint' => 50, 'null' => true],
            'updated_at'            => ['type' => 'int', 'constraint' => 50, 'null' => true],
            'deleted_at'            => ['type' => 'int', 'constraint' => 50, 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('mails', true);
    }

    public function down()
    {
        $this->forge->dropTable('mails', true);
    }
}