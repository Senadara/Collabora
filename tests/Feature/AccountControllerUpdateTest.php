<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Account;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AccountControllerUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_successful_account_update()
    {
        $account = Account::create([
            'name' => 'Original Name',
            'email' => 'original@example.com',
            'password' => bcrypt('originalpassword'),
            'role' => 'user',
        ]);

        $response = $this->put("/account/{$account->id}", [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
            'password' => 'newpassword123',
            'role' => 'admin',
        ]);

        $response->assertRedirect(route('manage'));

        $this->assertDatabaseHas('accounts', [
            'id' => $account->id,
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
        ]);
    }
}
