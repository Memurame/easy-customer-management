<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MakeProjectidNull extends Migration
{
    public function up()
    {
        $alterfields = [
            'project_id' => [
                'type' => 'Int',
                'null' => true
            ],
            'notes' => [
                'type' => 'TEXT',
                'null' => true
            ]
        ];
        $this->forge->modifyColumn('websites', $alterfields);
    }
    public function down()
    {

    }
}