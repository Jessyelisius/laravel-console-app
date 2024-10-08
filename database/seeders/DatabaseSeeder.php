<?php

namespace Database\Seeders;

use App\Models\PasswordModel;
use App\Models\UserModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       // Create a user directly without a factory

       $faker = Faker::create();

       for ($i = 0; $i < 50; $i++) {
            $user = UserModel::create([
                'name' => $faker->name,
                'profilePic' => $faker->imageUrl(),
                'address' => $faker->address,
                'phone' => $faker->phoneNumber,
                'password' => Hash::make($faker->password),
            ]);

            for ($x = 0; $x < 5; $x++) {
                // Create a related password record
                PasswordModel::create([
                    'user_id' => $user->id,
                    'platform' => $faker->company,
                    'password' => $faker->password  
                ]);
            }
       }
       

        
    }
}
