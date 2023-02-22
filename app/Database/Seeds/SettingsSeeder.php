<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['key' => 'auth.allowRegistration', 'value' => 1],
            ['key' => 'auth.allowRemembering', 'value' => 1]
            
        ];

        // Using Query Builder
        $this->db->table('settings')->insertBatch($data);
    }
}