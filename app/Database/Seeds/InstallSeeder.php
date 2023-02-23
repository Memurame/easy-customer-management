<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class InstallSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['name' => 'PopularFX', 'class' => 'text-bg-primary'],
            ['name' => 'Pagelayer', 'class' => 'text-bg-primary'],
            ['name' => 'Update Basic', 'class' => 'text-bg-info'],
            ['name' => 'Update Plus', 'class' => 'text-bg-info'],
            ['name' => 'WPForms', 'class' => 'text-bg-primary'],
            ['name' => 'MainWp Child', 'class' => 'text-bg-primary'],
            
        ];

        // Using Query Builder
        $this->db->table('taglist')->insertBatch($data);
    }
}