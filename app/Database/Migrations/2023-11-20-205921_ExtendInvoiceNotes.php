<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ExtendInvoiceNotes extends Migration
{
    public function up()
    {
        $fields = [
            'notes_top' => ['type' => 'text', 'null' => true],
            'notes_bottom' => ['type' => 'text', 'null' => true]
        ];
        $this->forge->addColumn('invoices', $fields);
    }

    public function down()
    {
        //
    }
}