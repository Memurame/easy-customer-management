<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use CodeIgniter\Commands\Database\Migrate;
use Config\Services;
use App\Models\UserDetailsModel;
use App\Entities\UserDetails;
use CodeIgniter\Shield\Models\UserModel;
use CodeIgniter\Shield\Entities\User;

class Install extends BaseCommand
{
    protected $group       = 'ecm';
    protected $name        = 'ecm:install';
    protected $description = 'Run the site installer';

    protected array $params;

    public function run(array $params)
    {
        helper('custom');

        $this->params = $params;
        $this->runMigrations();
        $this->runSeeder();
        $this->runCreateAdmin();
    
    }

    public function runMigrations()
    {
        CLI::write(CLI::color('1. Run migration', 'yellow'));

        try {
            $command = new Migrate(Services::logger(), Services::commands());
            $command->run(['all' => null]);
        } catch (Throwable $e) {
            CLI::write(CLI::color('Migration error', 'red'));
        }
        
    
    }

    public function runSeeder()
    {
        CLI::write(CLI::color('2. Example data', 'yellow'));
        $seeder = \Config\Database::seeder();

        try{
            $seeder->call('InstallSeeder');
            CLI::write(CLI::color('Example data inserted', 'green'));
        } catch (Throwable $e) {
            CLI::write(CLI::color('Sample data could not be inserted.', 'red'));
        }


        try{
            $seeder->call('GroupPermissions');
            CLI::write(CLI::color('Groups and Permissions inserted', 'green'));
        } catch (Throwable $e) {
            CLI::write(CLI::color('Groups and Permissions could not be inserted.', 'red'));
        }

        
    }

    public function runCreateAdmin()
    {
        CLI::write(CLI::color('3. Create admin', 'yellow'));
        $username = null;
        $password = null;
        $email = null;

        // Set default credentials if quiet mode set
        if(array_key_exists('q', $this->params)){
            $username = 'admin';
            $password = createRandomPassword(12);
            $email = 'admin@ecm.ch';

        }

        // Set or overwrite credentials if they are given as parameters
        if(array_key_exists('u', $this->params) AND !empty($this->params['u'])) {
            $username = $this->params['u'];
        }

        if(array_key_exists('e', $this->params) AND !empty($this->params['e'])) {
            $email = $this->params['e'];
        }

        if(array_key_exists('p', $this->params) AND !empty($this->params['p'])) {
            $password = $this->params['p'];
        }


        if(!array_key_exists('q', $this->params)){
            if(!$username){
                $username = CLI::prompt('Username', null, 'required');
            }
            if(!$email){
                $email = CLI::prompt('E-Mail', null, 'required|valid_email');
            }
            if(!$password){
                $password = CLI::prompt('Password', null, 'required');
            }
        }




        $userModel = model('UserModel');
        
        $user = new User();
        $user->username = $username;
        $user->email = $email;
        $user->password = $password;
        $userModel->save($user);

        $user = $userModel->findById($userModel->getInsertID());

        $user->activate();
        $user->addGroup('superadmin');

        $userDetail = new UserDetails();
        $userDetail->user_id = $user->id;
        $userDetail->firstname = 'Admin';
        $userDetail->avatar = get_gravatar($user->email);
        model('UserDetailsModel')->save($userDetail);


        CLI::write(CLI::color('Admin created', 'green'));
        CLI::write(CLI::color('You can now log in to the website with your credentials', 'green'));
        CLI::write(CLI::color('E-Mail: ' . $email, 'blue'));
        CLI::write(CLI::color('Password: ' . $password, 'blue'));
        CLI::write(CLI::color('INSTALLTION COMPLETED', 'green'));
        

        
        
    }
}