<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class MakeUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:make-user {user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates a new user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        User::create([
            'name' => $this->argument('user'),
            'email' => $this->argument('user') . '@changeme.com',
            'password' => bcrypt($this->argument('user')),
        ]);
    }
}
