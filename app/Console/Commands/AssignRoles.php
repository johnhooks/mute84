<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AssignRoles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'role:assign
                            {user : The ID of the user}
                            {roles* : List of roles to assign to the user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign roles to user';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $user = \App\Models\User::find($this->argument('user'));

        if (!$user) {
            throw new \Exception('Unable to find a user with id ' . $this->argument('user'));
        }

        $user->assignRole($this->argument('roles'));

        $this->info('Roles successfully assigned to user.');

        return 0;
    }
}
