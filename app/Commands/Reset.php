<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use CodeIgniter\Commands\Database\MigrateRollback;
use Config\Services;
use App\Commands\Install;


class Reset extends BaseCommand
{
    protected $group       = 'ecm';
    protected $name        = 'ecm:reset';
    protected $description = 'Delete all tables';

    protected array $params;

    public function run(array $params)
    {
        $this->params = $params;
        $this->runRollback();

        $this->call(
            'ecm:install',
            ['q' => null]
        );
        
    }

    public function runRollback()
    {


        if(!array_key_exists('y', $this->params)){
            CLI::write(CLI::color('Do you really want to delete all data?', 'yellow'));
            $confirm = CLI::prompt(CLI::color('Confirm [y/n]', 'yellow'), null, 'required');
        } else {
            $confirm = 'y';
        }


        if($confirm == 'y'){
            try {
                $command = new MigrateRollback(Services::logger(), Services::commands());
                $command->run(['b' => 0]);
            } catch (Throwable $e) {
                CLI::write(CLI::color('Rollback error', 'red'));
            }
        } else {
            CLI::write(CLI::color('Reset was canceled by user', 'red'));
        }


    }
}