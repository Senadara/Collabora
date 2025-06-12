<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Account;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_non_admin_cannot_access_admin_page()
    {
        $user = Account::create([
            'name' => 'User Biasa',
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        $response = $this
            ->withSession(['account' => [
                'id' => $user->id,
                'role' => $user->role,
            ]])
            ->get('/admin/manage-account');

        $response->assertStatus(403);
    }

    public function test_admin_can_access_admin_page()
    {
        $admin = Account::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $response = $this
            ->withSession(['account' => [
                'id' => $admin->id,
                'role' => null,
            ]])
            ->get('/admin/manage-account');

        $response->assertStatus(200);
    }
}
