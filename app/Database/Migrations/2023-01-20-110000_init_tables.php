<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class InitTables extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'customer_id'           => ['type' => 'int', 'constraint' => 11],
            'order_id'              => ['type' => 'int', 'constraint' => 11],
            'website_url'           => ['type' => 'varchar', 'constraint' => 50],
            'website_live'          => ['type' => 'date', 'null' => true],
            'website_installed'     => ['type' => 'date', 'null' => true],
            'notes'                 => ['type' => 'text'],
            'created_at'            => ['type' => 'varchar', 'constraint' => 50, 'null' => true],
            'updated_at'            => ['type' => 'varchar', 'constraint' => 50, 'null' => true],
            'deleted_at'            => ['type' => 'varchar', 'constraint' => 50, 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('websites', true);

        $this->forge->addField([
            'tag_id'                => ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
            'website_id'            => ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
        ]);

        $this->forge->addKey(['website_id', 'tag_id']);
        $this->forge->createTable('websites_tags', true);

        $this->forge->addField([
            'id'                    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'website_id'            => ['type' => 'int', 'constraint' => 11, 'null' => true],
            'project_id'            => ['type' => 'int', 'constraint' => 11, 'null' => true],
            'customer_id'            => ['type' => 'int', 'constraint' => 11],
            'description'            => ['type' => 'varchar', 'constraint' => 100],
            'notes'                 => ['type' => 'text', 'null' => true],
            'invoice'               => ['type' => 'date', 'null' => true],
            'paid'                  => ['type' => 'int', 'constraint' => 1],
            'renew'                  => ['type' => 'int', 'constraint' => 1],
            'renew_interval'         => ['type' => 'int', 'constraint' => 2],
            'amount'                  => ['type' => 'float', 'constraint' => 10],
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
            'postcode'              => ['type' => 'varchar', 'constraint' => 10],
            'city'                  => ['type' => 'varchar', 'constraint' => 150],
            'status'                => ['type' => 'int', 'constraint' => 2],
            'customernumber'        => ['type' => 'int', 'constraint' => 20],
            'notes'                 => ['type' => 'text'],
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
        $this->forge->createTable('projects', true);

        $this->forge->addField([
            'id'                    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name'                  => ['type' => 'varchar', 'constraint' => 100],
            'class'                 => ['type' => 'varchar', 'constraint' => 100, 'null' => true],
            'created_at'            => ['type' => 'varchar', 'constraint' => 50, 'null' => true],
            'updated_at'            => ['type' => 'varchar', 'constraint' => 50, 'null' => true],
            'deleted_at'            => ['type' => 'varchar', 'constraint' => 50, 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('taglist', true);

        /*
         * Settings Table
         */
        $this->forge->addField([
            'key'              => ['type' => 'varchar', 'constraint' => 100],
            'value'            => ['type' => 'varchar', 'constraint' => 255],
        ]);

        $this->forge->addKey('key', true);
        $this->forge->createTable('settings', true);
    }

    //--------------------------------------------------------------------

    public function down()
    {

		$this->forge->dropTable('websites', true);
        $this->forge->dropTable('invoices', true);
        $this->forge->dropTable('customers', true);
        $this->forge->dropTable('projects', true);
        $this->forge->dropTable('website_tags', true);
        $this->forge->dropTable('taglist', true);
    }
}