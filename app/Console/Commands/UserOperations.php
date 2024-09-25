<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
// use App\Models\User;
use App\Models\UserModel;

use function PHPUnit\Framework\isEmpty;

class UserOperations extends Command
{
    // The name and signature of the console command.
    protected $signature = 'user:operations';

    // The console command description.
    protected $description = 'Display a selection menu for user operations';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Display the menu to the user
        $this->info("Select the type of operation to perform:");
        $this->info("1. Select");
        $this->info("2. Update");
        $this->info("3. Delete");
        $this->info("4. Add/Insert");

        // Get user input
        $choice = $this->ask('Enter your choice (1-4)');

        // Handle the user's choice
        switch ($choice) {
            case '1':
                $this->selectOperation();
                break;
            case '2':
                $this->updateOperation();
                break;
            case '3':
                $this->deleteOperation();
                break;
            case '4':
                $this->addOperation();
                break;
            default:
                $this->error('Invalid choice. Please enter a number between 1 and 4.');
        }
    }

    private function selectOperation()
    {
        $userId = $this->ask('Enter the user ID to get user');
        $users = UserModel::with('userPassword')->where('id',$userId)->first();

        if (!$users)return $this->error('User not found.');

        $this->info("Displaying the user");
        $this->info("userId: $users->id");

        $this->info("username: $users->name");
        $this->info("profilePic: $users->profilePic");
        $this->info("address: $users->address");
        $this->info("phone: $users->phone");

        $this->info("
--------------------------------------------------
");

        // $this->info("password: $users->password");
        if($users->userPassword&&count($users->userPassword) > 0){
            foreach ($users->userPassword as $item) {
                $this->line("{$item->platform} : $$item->password");
            }
         }else{
            $this->info('no password found.');
         }
    }

    private function updateOperation()
    {
        // Example update operation logic
        $userId = $this->ask('Enter the user ID to update');
        $user = UserModel::find($userId);

        if ($user) {
            $newName = $this->ask('Enter the new name');
            $user->name = $newName;
            $user->save();
            $this->info('User updated successfully.');
        } else {
            $this->error('User not found.');
        }
    }

    private function deleteOperation()
    {
        $userId = $this->ask('Enter the user ID to delete');
        $user = UserModel::find($userId);
    
        if ($user) {
            // Delete all related passwords first
            $user->userPassword()->delete();  // Deletes related passwords
            
            $user->delete(); // Then delete the user
            $this->info('User deleted successfully.');
        } else {
            $this->error('User not found.');
        }
    }    

    private function addOperation()
    {
        // Example add operation logic
        $name = $this->ask('Enter the user name');
        $address = $this->ask('Enter the user address');
        $phone = $this->ask('Enter the user phone');
        $password = bcrypt($this->ask('Enter the user password'));

        UserModel::create([
            'name' => $name,
            'address' => $address,
            'phone' => $phone,
            'password' => $password,
        ]);

        $this->info('User added successfully.');
    }
}
