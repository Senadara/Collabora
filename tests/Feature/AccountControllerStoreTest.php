<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccountControllerStoreTest extends TestCase
{
    use RefreshDatabase;

    public function test_successful_account_registration()
    {
        $response = $this->postJson('/register', [
            'name' => 'Jane',
            'email' => 'jane@example.com',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
        ]);

        $response->assertStatus(200)
                 ->assertJson(['status' => 'success']);

        $this->assertDatabaseHas('accounts', [
            'email' => 'jane@example.com',
            'role' => 'user'
        ]);
    }

    public function test_registration_fails_if_email_is_taken()
    {
        \App\Models\Account::factory()->create(['email' => 'taken@example.com']);

        $response = $this->postJson('/register', [
            'name' => 'John',
            'email' => 'taken@example.com',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
        ]);

        $response->assertStatus(422)
                 ->assertJsonFragment(['Akun sudah digunakan!']);
    }
}
