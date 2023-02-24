<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCommentTables extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'customer_id'           => ['type' => 'int', 'constraint' => 11],
            'project_id'            => ['type' => 'int', 'constraint' => 11],
            'website_id'            => ['type' => 'int', 'constraint' => 11],
            'comment_typ'           => ['type' => 'int', 'constraint' => 2],
            'comment'               => ['type' => 'text'],
            'created_at'            => ['type' => 'int', 'constraint' => 50, 'null' => true],
            'updated_at'            => ['type' => 'int', 'constraint' => 50, 'null' => true],
            'deleted_at'            => ['type' => 'int', 'constraint' => 50, 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('comments', true);

    
 
    }

    //--------------------------------------------------------------------

    public function down()
    {

		$this->forge->dropTable('comments', true);
    }
}