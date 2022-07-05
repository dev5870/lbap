<?php

namespace App\Console\Commands;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateUserAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:create_user_admin {email} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creating user with admin role';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if (User::where('email', '=', $this->argument('email'))->exists()) {
            $this->error('User already exists!');
            return false;
        }

        $user = User::create([
            'email' => $this->argument('email'),
            'password' => Hash::make($this->argument('password'))
        ]);

        if ($user && $user->assignRole(UserRole::ADMIN)) {
            $this->info('Success admin registration!');

            return true;
        }

        $this->error('Error user registration!');

        return false;
    }
}
