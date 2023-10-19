<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTelToUserdetail extends Migration
{
    public function up()
    {

        $fields = [
            'phone' => ['type' => 'varchar', 'constraint' => 20, 'null' => true]
        ];
        $this->forge->addColumn('user_details', $fields);
    }
    public function down()
    {

    }
}