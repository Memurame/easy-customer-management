<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FixTestimonialformField extends Migration
{
    public function up()
    {
        $fields = [
            'mail_new' => ['type' => 'text', 'null' => true],
        ];
        $this->forge->addColumn('testimonials_forms', $fields);
    }

    public function down()
    {
        //
    }
}
