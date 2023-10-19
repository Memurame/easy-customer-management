<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class InitTables extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'customer_id'           => ['type' => 'int', 'constraint' => 11],
            'project_id'              => ['type' => 'int', 'constraint' => 11, 'null' => true],
            'website_url'           => ['type' => 'varchar', 'constraint' => 50],
            'website_live'          => ['type' => 'date', 'null' => true],
            'website_installed'     => ['type' => 'date', 'null' => true],
            'notes'                 => ['type' => 'text'],
            'created_at'            => ['type' => 'int', 'constraint' => 50, 'null' => true],
            'updated_at'            => ['type' => 'int', 'constraint' => 50, 'null' => true],
            'deleted_at'            => ['type' => 'int', 'constraint' => 50, 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('websites', true);

        $this->forge->addField([
            'id'                    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name'                  => ['type' => 'varchar', 'constraint' => 100],
            'class'                 => ['type' => 'varchar', 'constraint' => 100, 'null' => true],
            'created_at'            => ['type' => 'int', 'constraint' => 50, 'null' => true],
            'updated_at'            => ['type' => 'int', 'constraint' => 50, 'null' => true],
            'deleted_at'            => ['type' => 'int', 'constraint' => 50, 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('taglist', true);


        $this->forge->addField([
            'id'                    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'website_id'            => ['type' => 'int', 'constraint' => 11, 'null' => true],
            'project_id'            => ['type' => 'int', 'constraint' => 11, 'null' => true],
            'customer_id'           => ['type' => 'int', 'constraint' => 11],
            'description'           => ['type' => 'varchar', 'constraint' => 100],
            'notes'                 => ['type' => 'text', 'null' => true],
            'invoice'               => ['type' => 'date', 'null' => true],
            'paid'                  => ['type' => 'int', 'constraint' => 1],
            'renewed'               => ['type' => 'int', 'constraint' => 1, 'null' => true],
            'renew'                 => ['type' => 'int', 'constraint' => 1],
            'renew_interval'        => ['type' => 'int', 'constraint' => 2],
            'amount'                => ['type' => 'float', 'constraint' => 10],
            'contact_name'          => ['type' => 'varchar', 'constraint' => 150],
            'contact_phone'         => ['type' => 'varchar', 'constraint' => 150],
            'contact_mail'          => ['type' => 'varchar', 'constraint' => 150],
            'created_at'            => ['type' => 'int', 'constraint' => 50, 'null' => true],
            'updated_at'            => ['type' => 'int', 'constraint' => 50, 'null' => true],
            'deleted_at'            => ['type' => 'int', 'constraint' => 50, 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('invoices', true);


        $this->forge->addField([
            'id'                    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'customername'          =>['type' => 'varchar', 'constraint' => 100],
            'mail'                  => ['type' => 'varchar', 'constraint' => 150],
            'phone'                 => ['type' => 'varchar', 'constraint' => 150],
            'street'                => ['type' => 'varchar', 'constraint' => 150],
            'postcode'              => ['type' => 'varchar', 'constraint' => 10],
            'city'                  => ['type' => 'varchar', 'constraint' => 150],
            'tel'                   => ['type' => 'varchar', 'constraint' => 150],
            'status'                => ['type' => 'int', 'constraint' => 2],
            'addressnumber'         => ['type' => 'int', 'constraint' => 20],
            'notes'                 => ['type' => 'text'],
            'main_contact'          => ['type' => 'int', 'constraint' => 11],
            'billing_contact'       => ['type' => 'int', 'constraint' => 11],
            'created_at'            => ['type' => 'int', 'constraint' => 50, 'null' => true],
            'updated_at'            => ['type' => 'int', 'constraint' => 50, 'null' => true],
            'deleted_at'            => ['type' => 'int', 'constraint' => 50, 'null' => true],
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
            'created_at'            => ['type' => 'int', 'constraint' => 50, 'null' => true],
            'updated_at'            => ['type' => 'int', 'constraint' => 50, 'null' => true],
            'deleted_at'            => ['type' => 'int', 'constraint' => 50, 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('projects', true);

        $this->forge->addField([
            'id'                    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'customer_id'           => ['type' => 'int', 'constraint' => 11],
            'project_id'            => ['type' => 'int', 'constraint' => 11],
            'invoice_id'            => ['type' => 'int', 'constraint' => 11],
            'website_id'            => ['type' => 'int', 'constraint' => 11],
            'comment_typ'           => ['type' => 'int', 'constraint' => 2],
            'comment'               => ['type' => 'text'],
            'created_at'            => ['type' => 'int', 'constraint' => 50, 'null' => true],
            'updated_at'            => ['type' => 'int', 'constraint' => 50, 'null' => true],
            'deleted_at'            => ['type' => 'int', 'constraint' => 50, 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('comments', true);

        $this->forge->addField([
            'tag_id'                => ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
            'website_id'            => ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
        ]);

        $this->forge->addForeignKey('website_id', 'websites', 'id', '', 'CASCADE');
        $this->forge->addForeignKey('tag_id', 'taglist', 'id', '', 'CASCADE');
        $this->forge->createTable('websites_tags', true);

        $this->forge->addField([
            'id'                    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'position'              => ['type' => 'int', 'constraint' => 11],
            'invoice_id'           => ['type' => 'int', 'constraint' => 11, 'unsigned' => true,],
            'title'                 => ['type' => 'varchar', 'constraint' => 100],
            'description'           => ['type' => 'varchar', 'constraint' => 200, 'null' => true],
            'user_id'               => ['type' => 'int', 'constraint' => 11],
            'price'                 => ['type' => 'float', 'constraint' => 11],
            'price_inkl'            => ['type' => 'int', 'constraint' => 2],
            'multiplication'        => ['type' => 'float', 'constraint' => 4],
            'mwst'                  => ['type' => 'varchar', 'constraint' => 4],
            'unit'                  => ['type' => 'varchar', 'constraint' => 20],
            'notes'                 => ['type' => 'text'],
            'created_at'            => ['type' => 'int', 'constraint' => 50, 'null' => true],
            'updated_at'            => ['type' => 'int', 'constraint' => 50, 'null' => true],
            'deleted_at'            => ['type' => 'int', 'constraint' => 50, 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('invoice_id', 'invoices', 'id', '', 'CASCADE');
        $this->forge->createTable('invoices_position', true);


        $this->forge->addField([
            'id'                    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'addressnumber'         => ['type' => 'int', 'constraint' => 20, 'null' => true],
            'customer_id'           => ['type' => 'int', 'constraint' => 11, 'unsigned' => true,],
            'lastname'              => ['type' => 'varchar', 'constraint' => 100],
            'firstname'             => ['type' => 'varchar', 'constraint' => 100],
            'street'                => ['type' => 'varchar', 'constraint' => 200, 'null' => true],
            'postcode'              => ['type' => 'varchar', 'constraint' => 10, 'null' => true],
            'city'                  => ['type' => 'varchar', 'constraint' => 150, 'null' => true],
            'phone'                 => ['type' => 'varchar', 'constraint' => 50, 'null' => true],
            'mail'                  => ['type' => 'varchar', 'constraint' => 200, 'null' => true],
            'typ'                   => ['type' => 'varchar', 'constraint' => 11],
            'created_at'            => ['type' => 'int', 'constraint' => 50, 'null' => true],
            'updated_at'            => ['type' => 'int', 'constraint' => 50, 'null' => true],
            'deleted_at'            => ['type' => 'int', 'constraint' => 50, 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('customer_id', 'customers', 'id', '', 'CASCADE');
        $this->forge->createTable('customers_contacts', true);

    }

    //--------------------------------------------------------------------

    public function down()
    {
		$this->forge->dropTable('websites', true);
        $this->forge->dropTable('invoices', true);
        $this->forge->dropTable('invoices_position', true);
        $this->forge->dropTable('customers', true);
        $this->forge->dropTable('customers_contacts', true);
        $this->forge->dropTable('projects', true);
        $this->forge->dropTable('websites_tags', true);
        $this->forge->dropTable('taglist', true);
        $this->forge->dropTable('comments', true);
    }
}