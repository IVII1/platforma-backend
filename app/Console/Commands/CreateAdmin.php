<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates the initial admin user';

    /**
     * Execute the console command.
     */


    public function handle()
    {
        $name = $this->ask('State the name of the admin user');
        $last_name = $this->ask('State the last name of the admin user');
        $email = $this->ask('State the email of the admin user');
        $password = $this->ask('Choose the password of the admin user');

        $validator = Validator::make(
            [
                'name' => $name,
                'last_name' => $last_name,
                'email' => $email,
                'password' => $password
            ],
            [
                'name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255', // Fixed typo
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8',
            ]
        );

        if ($validator->fails()) {
            $this->error('Validation failed:');
            foreach ($validator->errors()->all() as $message) {
                $this->line(" - $message");
            }
            return 1; // Fixed error handling
        }

        $user = User::create([
            'name' => $name,
            'last_name' => $last_name,
            'email' => $email,
            'password' => Hash::make($password), // Fixed typo
            'role' => 'admin',
            'picture' => 'default.png'
        ]);

        $this->info("User {$user->name} {$user->last_name} created successfully!"); // Fixed quotes

        return 0;
    }
}
