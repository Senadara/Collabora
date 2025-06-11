<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CreateAccountTest extends TestCase
{
    use RefreshDatabase;

    // positive create account
    /** @test */
    public function test_user_can_register_successfully()
    {
        $response = $this->postJson('/register', [
            'name' => 'Budi',
            'email' => 'budi@example.com',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'success',
            'message' => 'You Have Created Your Account!',
        ]);

        $this->assertDatabaseHas('accounts', [
            'email' => 'budi@example.com',
        ]);
    }

    // negative create account
    /** @test */
    public function test_register_fails_with_existing_email()
    {
        Account::factory()->create([
            'email' => 'budi@example.com'
        ]);

        $response = $this->postJson('/register', [
            'name' => 'Budi',
            'email' => 'budi@example.com',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
        ]);

        $response->assertStatus(422);
        $response->assertJsonStructure(['status', 'messages']);
    }
}
