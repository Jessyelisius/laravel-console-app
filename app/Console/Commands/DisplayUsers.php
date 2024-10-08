<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\UserModel;

class DisplayUsers extends Command
{
    // The name and signature of the console command.
    protected $signature = 'user:display {page=1}';

    // console command description.
    protected $description = 'Display all users with their respective passwords';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $page = $this->argument('page');
        //set user page
        $perPage = 5;
        // get users with their passwords using pagination
        $users = UserModel::with('userPassword')->paginate($perPage, ['*'], 'page', $page); 

        if($users->isEmpty()){
            $this->error("No user for this pagination.");
            return;
        }

        foreach ($users as $user) {
            $this->info("User: {$user->name}");
            foreach ($user->userPassword as $password) {
                $this->line(" - Platform: {$password->platform}, - Password: {$password->password}");
            }
        }

        // Check if there are more pages to display
        if ($users->hasMorePages()) {
            $this->info("There are more users. Use pagination to navigate.");
        }

        $this->info("Page number {$users->currentPage()} of {$users->lastPage()}");
    }
}
