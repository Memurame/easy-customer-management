<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class InitTables extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'customer_id'            => ['type' => 'int', 'constraint' => 11],
            'order_id'            => ['type' => 'int', 'constraint' => 11],
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
            'order_id'            => ['type' => 'int', 'constraint' => 11],
            'customer_id'            => ['type' => 'int', 'constraint' => 11],
            'invoice'               => ['type' => 'date', 'null' => true],
            'paid'                  => ['type' => 'int', 'constraint' => 1],
            'renew'                  => ['type' => 'int', 'constraint' => 1],
            'created_at'            => ['type' => 'varchar', 'constraint' => 50, 'null' => true],
            'updated_at'            => ['type' => 'varchar', 'constraint' => 50, 'null' => true],
            'deleted_at'            => ['type' => 'varchar', 'constraint' => 50, 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('invoices', true);


        $this->forge->addField([
            'id'                    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'company'               =>['type' => 'varchar', 'constraint' => 100],
            'contact_firstname'     => ['type' => 'varchar', 'constraint' => 50],
            'contact_lastname'      => ['type' => 'varchar', 'constraint' => 50],
            'contact_mail'          => ['type' => 'varchar', 'constraint' => 150],
            'street'                => ['type' => 'varchar', 'constraint' => 150],
            'postalcode'            => ['type' => 'varchar', 'constraint' => 10],
            'city'                  => ['type' => 'varchar', 'constraint' => 150],
            'customernumber'        => ['type' => 'int', 'constraint' => 20],
            'created_at'            => ['type' => 'varchar', 'constraint' => 50, 'null' => true],
            'updated_at'            => ['type' => 'varchar', 'constraint' => 50, 'null' => true],
            'deleted_at'            => ['type' => 'varchar', 'constraint' => 50, 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('customers', true);


        $this->forge->addField([
            'id'                    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'customer_id'           => ['type' => 'int', 'constraint' => 11],
            'name'                  =>['type' => 'varchar', 'constraint' => 100],
            'status'                => ['type' => 'int', 'constraint' => 1],
            'date_offer'            => ['type' => 'date', 'null' => true],
            'date_order'            => ['type' => 'date', 'null' => true],
            'date_finish'           => ['type' => 'date', 'null' => true],
            'notes'                 => ['type' => 'varchar', 'constraint' => 255],
            'created_at'            => ['type' => 'varchar', 'constraint' => 50, 'null' => true],
            'updated_at'            => ['type' => 'varchar', 'constraint' => 50, 'null' => true],
            'deleted_at'            => ['type' => 'varchar', 'constraint' => 50, 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('orders', true);
    }

    //--------------------------------------------------------------------

    public function down()
    {

		$this->forge->dropTable('websites', true);
        $this->forge->dropTable('invoices', true);
        $this->forge->dropTable('customers', true);
        $this->forge->dropTable('orders', true);

    }
}