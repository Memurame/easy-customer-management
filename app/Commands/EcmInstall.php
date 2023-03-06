<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use CodeIgniter\Commands\Database\Migrate;
use Config\Services;
use CodeIgniter\Shield\Models\UserModel;
use CodeIgniter\Shield\Entities\User;

class EcmInstall extends BaseCommand
{
    protected $group       = 'ecm';
    protected $name        = 'ecm:install';
    protected $description = 'Run the site installer';

    public function run(array $params)
    {
        $this->runMigrations();
        $this->runSeeder();
        $this->runCreateAdmin();
    
    }

    public function runMigrations()
    {
        CLI::write(CLI::color('1. Run migration', 'yellow'));

        $migrate = \Config\Services::migrations();
        
        
        try {
            $command = new Migrate(Services::logger(), Services::commands());
            $command->run(['all' => null]);
        } catch (Throwable $e) {
            CLI::write(CLI::color('Fehler bei der Migration', 'red'));
        }
        
    
    }

    public function runSeeder()
    {
        CLI::write(CLI::color('2. Example data', 'yellow'));

        try{
            $seeder = \Config\Database::seeder();
            $seeder->call('InstallSeeder');
            CLI::write(CLI::color('Example data inserted', 'green'));
        } catch (Throwable $e) {
            CLI::write(CLI::color('Fehler bei der Migration', 'red'));
        }
        
    }

    public function runCreateAdmin()
    {
        CLI::write(CLI::color('3. Benutzer erstellen', 'yellow'));

        $username = CLI::prompt('Username: ', null, 'required');
        $email = CLI::prompt('E-Mail: ', null, 'required|valid_email');
        $password = CLI::prompt('Passwort: ', null, 'required');

        $userModel = model('UserModel');
        
        $user = new User();
        $user->username = $username;
        $user->email = $email;
        $user->password = $password;
        
        $userModel->save($user);

        $user = $userModel->findById($userModel->getInsertID());

        $user->activate();
        $user->addGroup('superadmin');


        CLI::write(CLI::color('Benutzer '.$username.' erstellt', 'green'));
        CLI::write(CLI::color('DU kannst dich nun auf der Webseite anmelden', 'green'));
        CLI::write(CLI::color('INSTALLTION ABGESCHLOSSEN', 'green'));
        

        
        
    }
}