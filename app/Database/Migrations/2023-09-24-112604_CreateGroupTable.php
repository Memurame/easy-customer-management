<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateGroupTable extends Migration
{
    public function up()
    {

        $this->forge->addField([
            'id'                    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name'                  => ['type' => 'varchar', 'constraint' => 50],
            'title'                 => ['type' => 'varchar', 'constraint' => 100],
            'description'           => ['type' => 'varchar', 'constraint' => 255],
            'is_admin'              => ['type' => 'int', 'constraint' => 1, 'null' => true],
            'created_at'            => ['type' => 'int', 'constraint' => 50, 'null' => true],
            'updated_at'            => ['type' => 'int', 'constraint' => 50, 'null' => true],
            'deleted_at'            => ['type' => 'int', 'constraint' => 50, 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('auth_groups', true);

        $this->forge->addField([
            'id'                    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'group_id'              => ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
            'permission'            => ['type' => 'varchar', 'constraint' => 100],
            'created_at'            => ['type' => 'int', 'constraint' => 50, 'null' => true],
            'updated_at'            => ['type' => 'int', 'constraint' => 50, 'null' => true],
            'deleted_at'            => ['type' => 'int', 'constraint' => 50, 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('group_id', 'auth_groups', 'id', '', 'CASCADE');
        $this->forge->createTable('auth_permissions_groups', true);
    }

    public function down()
    {
        $this->forge->dropTable('auth_groups', true);
        $this->forge->dropTable('auth_permissions_groups', true);
    }
}