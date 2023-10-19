<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class InstallSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['name' => 'MainWp Child', 'class' => 'text-bg-primary'],
            ['name' => 'Monitoring', 'class' => 'text-bg-dark'],
            ['name' => 'Pagelayer', 'class' => 'text-bg-primary'],
            ['name' => 'PopularFX', 'class' => 'text-bg-primary'],
            ['name' => 'Update Basic', 'class' => 'text-bg-info'],
            ['name' => 'Update Plus', 'class' => 'text-bg-info'],
            ['name' => 'WPForms', 'class' => 'text-bg-primary']
        ];

        // Using Query Builder
        $this->db->table('taglist')->insertBatch($data);
    }
}