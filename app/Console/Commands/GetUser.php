<?php

namespace App\Console\Commands;

use App\Models\UserModel;
use Illuminate\Console\Command;

class GetUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'getUser {userId}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Used to get user passwords and user details';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $userId = $this->argument('userId');

        $user = UserModel::with('userPassword')->where('id',$userId)->get();
        //
        $this->info($user);

    }
}
