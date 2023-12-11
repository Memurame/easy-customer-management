<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPaymentTermsToInvoice extends Migration
{
    public function up()
    {
        $fields = [
            'payment_terms' => ['type' => 'int', 'constraint' => 11, 'null' => true],
        ];
        $this->forge->addColumn('invoices', $fields);
    }

    public function down()
    {
        //
    }
}