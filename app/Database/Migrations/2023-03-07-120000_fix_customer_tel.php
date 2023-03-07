<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FixCustomerTel extends Migration
{
    public function up()
    {
        $fields = [
            'contact_tel' => ['type' => 'varchar', 'constraint' => 150],
        ];
        $this->forge->addColumn('customers', $fields);
 
    }

    //--------------------------------------------------------------------

    public function down()
    {

    }
}