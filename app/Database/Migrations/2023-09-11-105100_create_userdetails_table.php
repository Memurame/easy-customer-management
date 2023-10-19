<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUserdetailsTable extends Migration
{
    public function up()
    {

        $this->forge->addField([
            'user_id'               => ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
            'avatar'                => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'firstname'             => ['type' => 'varchar', 'constraint' => 100, 'null' => true],
            'lastname'              => ['type' => 'varchar', 'constraint' => 100, 'null' => true],
            'department'            => ['type' => 'varchar', 'constraint' => 100, 'null' => true]
        ]);

        $this->forge->addKey('user_id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', '', 'CASCADE');
        $this->forge->createTable('user_details', true);
    }
    public function down()
    {
        $this->forge->dropTable('user_details', true);
    }
}