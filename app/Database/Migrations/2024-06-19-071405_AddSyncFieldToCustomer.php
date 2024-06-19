<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSyncFieldToCustomer extends Migration
{
    public function up()
    {
        $fields = [
            'addressnumber_sync' => ['type' => 'int', 'null' => true],
        ];
        $this->forge->addColumn('customers', $fields);
    }

    public function down()
    {
        //
    }
}
