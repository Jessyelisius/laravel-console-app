<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
// use App\Models\User;
use App\Models\UserModel;

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
        $users = UserModel::all();
        $this->info("Displaying all users:");
        foreach ($users as $user) {
            $this->line("User ID: {$user->id}, Name: {$user->name}");
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
