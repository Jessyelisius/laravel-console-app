<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\UserModel;

class DisplayUsers extends Command
{
    // The name and signature of the console command.
    protected $signature = 'user:display';

    // The console command description.
    protected $description = 'Display all users with their respective passwords';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Fetch users with their passwords using pagination
        $users = UserModel::with('userPassword')->paginate(2); 

        foreach ($users as $user) {
            $this->info("User: {$user->name}");
            foreach ($user->userPassword as $password) {
                $this->line(" - Platform: {$password->platform}, - Password: {$password->password}");
            }
        }

        // Check if there are more pages
        if ($users->hasMorePages()) {
            $this->info("There are more users. Use pagination to navigate.");
        }
    }
}
