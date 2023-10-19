<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMessengerTable extends Migration
{
    public function up()
    {

        $this->forge->addField([
            'id'                    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'user1_id'              => ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
            'user2_id'              => ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
            'locked'                => ['type' => 'int', 'constraint' => 1, 'null' => true],
            'created_at'            => ['type' => 'int', 'constraint' => 50, 'null' => true],
            'updated_at'            => ['type' => 'int', 'constraint' => 50, 'null' => true],
            'deleted_at'            => ['type' => 'int', 'constraint' => 50, 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user1_id', 'users', 'id', '', 'CASCADE');
        $this->forge->addForeignKey('user2_id', 'users', 'id', '', 'CASCADE');
        $this->forge->createTable('chat', true);

        $this->forge->addField([
            'id'                    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'chat_id'               => ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
            'user_id'               => ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
            'is_read'               => ['type' => 'int', 'constraint' => 1, 'null' => true],
            'message'               => ['type' => 'text'],
            'created_at'            => ['type' => 'int', 'constraint' => 50, 'null' => true],
            'updated_at'            => ['type' => 'int', 'constraint' => 50, 'null' => true],
            'deleted_at'            => ['type' => 'int', 'constraint' => 50, 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('chat_id', 'chat', 'id', '', 'CASCADE');
        $this->forge->createTable('message', true);
    }
    public function down()
    {
        $this->forge->dropTable('message', true);
        $this->forge->dropTable('chat', true);
    }
}