<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class GroupPermissions extends Seeder
{
    public function run()
    {

        $data = [
            ['id' => 1, 'name' => 'superadmin', 'title' => 'Superadmin', 'description' => 'Haupt-Administrator, alle Berechtigungen.', 'is_admin' => true],
            ['id' => 2, 'name' => 'admin', 'title' => 'Administrator', 'description' => 'Administrator der Seite.', 'is_admin' => true],
            ['id' => 3, 'name' => 'user', 'title' => 'Benutzer', 'description' => 'Standart Gruppe.', 'is_admin' => false]
        ];

        // Using Query Builder
        $this->db->table('auth_groups')->insertBatch($data);

        $data = [
            ['group_id' => '2', 'permission' => 'admin.*'],
            ['group_id' => '2', 'permission' => 'user.add'],
            ['group_id' => '2', 'permission' => 'user.edit'],
            ['group_id' => '2', 'permission' => 'user.delete'],
            ['group_id' => '2', 'permission' => 'user.index'],
            ['group_id' => '2', 'permission' => 'customer.*'],
            ['group_id' => '2', 'permission' => 'comment.*'],
            ['group_id' => '2', 'permission' => 'website.*'],
            ['group_id' => '2', 'permission' => 'project.*'],
            ['group_id' => '2', 'permission' => 'invoice.*'],
            ['group_id' => '2', 'permission' => 'home.*'],
            ['group_id' => '2', 'permission' => 'message.*'],
            ['group_id' => '2', 'permission' => 'profile.*'],
            ['group_id' => '2', 'permission' => 'mail.*'],
            ['group_id' => '3', 'permission' => 'home.*'],
            ['group_id' => '3', 'permission' => 'profile.*'],
            ['group_id' => '3', 'permission' => 'message.*'],
            ['group_id' => '3', 'permission' => 'testimonial.*'],
        ];

        // Using Query Builder
        $this->db->table('auth_permissions_groups')->insertBatch($data);
    }
}