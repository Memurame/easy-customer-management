<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAbacusTables extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'abacus'                => ['type' => 'int', 'constraint' => 10, 'null' => true],
            'email'                 => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'salutation'            => ['type' => 'int', 'constraint' => 5, 'null' => true],
            'firstname'             => ['type' => 'varchar', 'constraint' => 100, 'null' => true],
            'lastname'              => ['type' => 'varchar', 'constraint' => 100, 'null' => true],
            'street'                => ['type' => 'varchar', 'constraint' => 200, 'null' => true],
            'postcode'              => ['type' => 'varchar', 'constraint' => 10, 'null' => true],
            'city'                  => ['type' => 'varchar', 'constraint' => 100, 'null' => true],
            'phone1'                => ['type' => 'varchar', 'constraint' => 50, 'null' => true],
            'phone2'                => ['type' => 'varchar', 'constraint' => 50, 'null' => true],
            'mobile'                => ['type' => 'varchar', 'constraint' => 50, 'null' => true],
            'member_typ'            => ['type' => 'varchar', 'constraint' => 10, 'null' => true],
            'paid_percent'          => ['type' => 'int', 'constraint' => 3, 'null' => true],
            'paid_date'             => ['type' => 'date', 'null' => true],
            'paid_percent'          => ['type' => 'int', 'constraint' => 3, 'null' => true],
            'bebv_regio'            => ['type' => 'varchar', 'constraint' => 150, 'null' => true],
            'bebv_subregio'         => ['type' => 'varchar', 'constraint' => 150, 'null' => true],
            'inactive'              => ['type' => 'int', 'constraint' => 11, 'null' => true],
            'newsletter_active'     => ['type' => 'bool', 'null' => true],
            'newsletter_unsubscribeid'  => ['type' => 'varchar', 'constraint' => 100, 'null' => true],
            'lastsync'              => ['type' => 'datetime', 'null' => true],
            'website_username'      => ['type' => 'varchar', 'constraint' => 200, 'null' => true],
            'website_lastsync'      => ['type' => 'datetime', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('aba_address', true);

        //############################################

        $this->forge->addField([
            'id'                    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'group_id'              => ['type' => 'int', 'constraint' => 11],
            'address_id'            => ['type' => 'int', 'constraint' => 11],
            'lastsync'              => ['type' => 'datetime', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('aba_address_groups', true);

        //############################################

        $this->forge->addField([
            'id'                    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
            'group_name'            => ['type' => 'varchar', 'constraint' => 150],
            'lastsync'              => ['type' => 'datetime', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('aba_groups', true);

        //############################################

        $this->forge->addField([
            'id'                    => ['type' => 'varchar', 'constraint' => 10],
            'name'                  => ['type' => 'varchar', 'constraint' => 100],
            'lastsync'              => ['type' => 'datetime', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('aba_list_membertypes', true);

        //############################################

        $this->forge->addField([
            'id'                    => ['type' => 'varchar', 'constraint' => 10,],
            'salutation'            => ['type' => 'varchar', 'constraint' => 20],
            'text'                  => ['type' => 'varchar', 'constraint' => 100],
            'lastsync'              => ['type' => 'datetime', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('aba_list_salutation', true);

        //############################################

        $this->forge->addField([
            'kalahari'        => ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
            'phone'           => ['type' => 'int', 'constraint' => 20],
        ]);

        $this->forge->addKey('kalahari', true);
        $this->forge->createTable('aba_kalahari', true);

        // ##############################
        
        $this->forge->addField([
            'id'            => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'abacus'        => ['type' => 'int', 'constraint' => 11],
            'kalahari'      => ['type' => 'int', 'constraint' => 11],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('aba_address_kalahari', true);
    }

    public function down()
    {
        $this->forge->dropTable('aba_address', true);
        $this->forge->dropTable('aba_address_groups', true);
        $this->forge->dropTable('aba_groups', true);
        $this->forge->dropTable('aba_list_membertypes', true);
        $this->forge->dropTable('aba_list_salutation', true);
        $this->forge->dropTable('aba_kalahari', true);
        $this->forge->dropTable('aba_address_kalahari', true);
    }
}
