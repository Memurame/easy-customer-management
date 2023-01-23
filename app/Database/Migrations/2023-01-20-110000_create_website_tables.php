<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateWebsiteTables extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'contact_lastname'      => ['type' => 'varchar', 'constraint' => 50],
            'contact_firstname'     => ['type' => 'varchar', 'constraint' => 50],
            'contact_company'       => ['type' => 'varchar', 'constraint' => 100],
            'contact_mail'          => ['type' => 'varchar', 'constraint' => 100],
            'bebv_member'           => ['type' => 'int', 'constraint' => 1],
            'website_url'           => ['type' => 'varchar', 'constraint' => 50],
            'website_live'          => ['type' => 'date', 'null' => true],
            'website_installed'     => ['type' => 'date', 'null' => true],
            'update_abo'            => ['type' => 'varchar', 'constraint' => 50],
            'license_popularfx'     => ['type' => 'int', 'constraint' => 1],
            'notes'                 => ['type' => 'varchar', 'constraint' => 255],
            'created_at'            => ['type' => 'varchar', 'constraint' => 50, 'null' => true],
            'updated_at'            => ['type' => 'varchar', 'constraint' => 50, 'null' => true],
            'deleted_at'            => ['type' => 'varchar', 'constraint' => 50, 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('websites', true);

        $this->forge->addField([
            'id'                    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'website_id'            => ['type' => 'int', 'constraint' => 11],
            'invoice'               => ['type' => 'date', 'null' => true],
            'paid'                  => ['type' => 'int', 'constraint' => 1],
            'renew'                  => ['type' => 'int', 'constraint' => 1],
            'created_at'            => ['type' => 'varchar', 'constraint' => 50, 'null' => true],
            'updated_at'            => ['type' => 'varchar', 'constraint' => 50, 'null' => true],
            'deleted_at'            => ['type' => 'varchar', 'constraint' => 50, 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('invoices', true);
    }

    //--------------------------------------------------------------------

    public function down()
    {

		$this->forge->dropTable('websites', true);
        $this->forge->dropTable('invoices', true);

    }
}