<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class GroupPermissions extends Seeder
{
    public function run()
    {

        $data = [
            ['id' => 1, 'name' => 'superadmin', 'title' => 'Superadmin', 'description' => 'Haupt-Administrator, alle Berechtigungen.', 'is_admin' => true],
            ['id' => 2, 'name' => 'admin', 'title' => 'Administrator', 'description' => 'Administrator der Seite, alle Berechtigungen ausser Admin und Superadmin bearbeiten/erstellen.', 'is_admin' => true],
            ['id' => 3, 'name' => 'user', 'title' => 'Benutzer', 'description' => 'Standart Gruppe.', 'is_admin' => false]
        ];

        // Using Query Builder
        $this->db->table('auth_groups')->insertBatch($data);

        $data = [
            ['group_id' => '3', 'permission' => 'home.*'],
            ['group_id' => '3', 'permission' => 'profile.*'],
            ['group_id' => '3', 'permission' => 'message.*']
        ];

        // Using Query Builder
        $this->db->table('auth_permissions_groups')->insertBatch($data);
    }
}