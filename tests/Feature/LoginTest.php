<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\User;
use App\Models\Event;
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
            'email' => 'email@gmail.com',
            'password' => Hash::make('cobacoba'),
            'role' => 'user',
        ]);

        $response = $this->post('/masuk', [
            'email' => 'email@gmail.com',
            'password' => 'cobacoba',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertEquals(session('account')->email, 'email@gmail.com');
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
        $response->assertfail(); // ada error apapun
        $this->assertNull(session('account'));
    }

    // /** @test */
    public function test_masuk_gagal_dengan_email_tidak_terdaftar()
    {
        $response = $this->from('/account')->post('/masuk', [
            'email' => 'tidakada@example.com',
            'password' => 'any',
        ]);

        $response->assertRedirect('/account');
        $response->assertfail(['error' => 'Email tidak ditemukan']);
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

    /** @test */
    public function it_should_store_rating_successfully()
    {
        $account = Account::factory()->create();
        $event = Event::factory()->create();

        $this->withSession([
            'account' => ['id' => $account->id]
        ]);

        $response = $this->post('/rating', [
            'event_id' => $event->id,
            'feedback' => 'Acara luar biasa!',
            'star' => 5,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Rating berhasil ditambahkan!');

        $this->assertDatabaseHas('ratings', [
            'account_id' => $account->id,
            'event_id' => $event->id,
            'feedback' => 'Acara luar biasa!',
            'star' => 5,
        ]);
    }
}
