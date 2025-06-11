<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_masuk_berhasil_dengan_kredensial_valid()
    {
        Account::create([
            'name' => 'Test User',
            'email' => 'user@test.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
        ]);

        $response = $this->post('/masuk', [
            'email' => 'user@test.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertEquals(session('account')->email, 'user@test.com');
    }

    /** @test */
    public function test_masuk_gagal_dengan_password_salah()
    {
        Account::create([
            'name' => 'Test User',
            'email' => 'user@test.com',
            'password' => Hash::make('benarpassword'),
            'role' => 'user',
        ]);

        $response = $this->from('/account')->post('/masuk', [
            'email' => 'user@test.com',
            'password' => 'salahpassword',
        ]);

        $response->assertRedirect('/account');
        $response->assertSessionHasErrors(); // ada error apapun
        $this->assertNull(session('account'));
    }

    /** @test */
    public function test_masuk_gagal_dengan_email_tidak_terdaftar()
    {
        $response = $this->from('/account')->post('/masuk', [
            'email' => 'tidakada@example.com',
            'password' => 'any',
        ]);

        $response->assertRedirect('/account');
        $response->assertSessionHasErrors(['error' => 'Email tidak ditemukan']);
        $this->assertNull(session('account'));
    }

    /** @test */
    public function test_validasi_gagal_ketika_field_kosong()
    {
        $response = $this->from('/account')->post('/masuk', [
            'email' => '',
            'password' => '',
        ]);

        $response->assertRedirect('/account');
        $response->assertSessionHasErrors(['email', 'password']);
    }
}
