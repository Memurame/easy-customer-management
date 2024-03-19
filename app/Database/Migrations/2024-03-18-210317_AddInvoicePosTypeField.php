<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddInvoicePosTypeField extends Migration
{
    public function up()
    {
        $fields = [
            'type' => ['type' => 'int', 'constraint' => 2, 'default' => 1],
            'ord' => ['type' => 'int', 'constraint' => 3]
        ];
        $this->forge->addColumn('invoices_position', $fields);
    }

    public function down()
    {
        //
    }
}
