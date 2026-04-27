<?php

namespace Tests\Feature\Commands;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InitUserTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_creates_initial_user_if_no_users_exist(): void
    {
        $email = 'test@example.com';

        $this->artisan('user:init', ['email' => $email])
            ->expectsOutput('User created successfully.')
            ->expectsOutput("Email: {$email}")
            ->assertExitCode(0);

        $this->assertDatabaseHas('users', [
            'email' => $email,
            'name' => 'Admin',
        ]);

        $this->assertEquals(1, User::count());
    }

    public function test_it_does_not_create_user_if_users_already_exist(): void
    {
        \App\Models\User::create([
            'name' => 'Existing User',
            'email' => 'existing@example.com',
            'password' => 'password',
        ]);

        $this->assertEquals(1, User::count());

        $email = 'another@example.com';

        $this->artisan('user:init', ['email' => $email])
            ->expectsOutput('Users already exist in the database.')
            ->assertExitCode(0);

        $this->assertEquals(1, User::count());
        $this->assertDatabaseMissing('users', [
            'email' => $email,
        ]);
    }
}
