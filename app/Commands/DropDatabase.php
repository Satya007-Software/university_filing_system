<?php namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use Config\Database;

class DropDatabase extends BaseCommand
{
    protected $group = 'Database';
    protected $name = 'db:drop';
    protected $description = 'Drops the current database';

    public function run(array $params)
    {
        $dbName = Database::connect()->database;
        
        if (CLI::prompt("Drop database {$dbName}? [y/n]", ['y', 'n']) === 'y') {
            Database::forge()->dropDatabase($dbName);
            CLI::write("Database {$dbName} dropped successfully!", 'green');
        }
    }
}