<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Symfony\Component\Console\Command\Command as SymfonyCommand;

class InitUser extends Command
{
    /**
     * @var string
     */
    protected $signature = 'user:init {email}';

    /**
     * @var string
     */
    protected $description = 'Create initial user if no users in database found';

    public function handle(): int
    {
        if (User::count() > 0) {
            $this->info('Users already exist in the database.');
            return SymfonyCommand::SUCCESS;
        }
        $email = $this->argument('email');
        $validator = Validator::make(['email' => $email], [
            'email' => 'email:rfc,dns',
        ]);
        if ($validator->fails()) {
            $this->error("Invalid email address: $email");
            return SymfonyCommand::FAILURE;
        }
        $password = Str::random(12);
        User::create([
            'name' => 'Admin',
            'email' => $email,
            'password' => Hash::make($password),
        ]);
        $this->info("User created successfully: $email $password");
        return SymfonyCommand::SUCCESS;
    }
}
