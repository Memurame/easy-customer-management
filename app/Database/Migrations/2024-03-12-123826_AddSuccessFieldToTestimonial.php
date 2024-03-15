<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSuccessFieldToTestimonial extends Migration
{
    public function up()
    {
        $fields = [
            'message_success' => ['type' => 'text', 'null' => true],
            'mail_confirmation' => ['type' => 'text', 'null' => true],
            'mail_approved' => ['type' => 'text', 'null' => true],
            'mail_rejected' => ['type' => 'text', 'null' => true],
            'mail_new' => ['type' => 'text', 'null' => true],
            'notify' => ['type' => 'text', 'null' => true],
        ];
        $this->forge->addColumn('testimonials_forms', $fields);

        $fields = [
            'log' => ['type' => 'text', 'null' => true]
        ];
        $this->forge->addColumn('testimonials', $fields);
    }

    public function down()
    {
        //
    }
}
