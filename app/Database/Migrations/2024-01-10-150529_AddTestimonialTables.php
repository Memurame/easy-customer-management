<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTestimonialTables extends Migration
{
    public function up()
    {
        /*
         * Testimonial Tables
         */
        $this->forge->addField([
            'id'               => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'token'            => ['type' => 'varchar', 'constraint' => 255],
            'title'            => ['type' => 'varchar', 'constraint' => 255],
            'description'      => ['type' => 'varchar', 'constraint' => 255],
            'active'           => ['type' => 'int', 'constraint' => 1],
            'data'             => ['type' => 'text'],
            'created_at'       => ['type' => 'datetime', 'null' => true],
            'updated_at'       => ['type' => 'datetime', 'null' => true],
            'deleted_at'       => ['type' => 'datetime', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('testimonials_forms', true);

        $this->forge->addField([
            'id'               => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'token_view'       => ['type' => 'varchar', 'constraint' => 255],
            'token_edit'       => ['type' => 'varchar', 'constraint' => 255],
            'firstname'        => ['type' => 'varchar', 'constraint' => 255],
            'lastname'         => ['type' => 'varchar', 'constraint' => 255],
            'email'            => ['type' => 'varchar', 'constraint' => 255],
            'form'             => ['type' => 'int', 'constraint' => 5],
            'data'             => ['type' => 'text'],
            'notes'            => ['type' => 'varchar', 'constraint' => 255],
            'active'           => ['type' => 'int', 'constraint' => 1],
            'created_at'       => ['type' => 'datetime', 'null' => true],
            'updated_at'       => ['type' => 'datetime', 'null' => true],
            'deleted_at'       => ['type' => 'datetime', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('testimonials', true);
    }

    public function down()
    {
        $this->forge->dropTable('testimonials_forms', true);
        $this->forge->dropTable('testimonials', true);
    }
}
