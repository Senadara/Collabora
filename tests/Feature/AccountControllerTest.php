<?php

// namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
// use Tests\TestCase;
// use App\Models\User;
// use Illuminate\Support\Facades\DB;

// class AccountControllerTest extends TestCase
// {
//     use RefreshDatabase;

    // protected function setUp(): void
    // {
        // parent::setUp();

        // // Seed akun dengan ID 1 jika tidak menggunakan RefreshDatabase
        // DB::table('accounts')->insert([
        //     'id' => 1,
        //     'nama' => 'nanda',
        //     'email' => 'dummy@email.com',
        //     'password' => bcrypt('secret'),
        // ]);
    // }

    /** @test */
    // public function it_can_create_biodata_for_account_id_1()
    // {
    //     $response = $this->postJson('/api/account/biodata', [
    //         'account_id' => 1,
    //         'full_name' => 'Septian Nanda',
    //         'gender' => 'Laki-laki',
    //         'birth_date' => '2000-01-01',
    //         'phone_number' => '08123456789',
    //         'address' => 'Bandung',
    //         'university' => 'Telkom University',
    //         'major' => 'Software Engineering',
    //         'semester' => '6',
    //         'instagram_handle' => '@septian',
    //     ]);

    //     $response->assertStatus(201);
    //     $this->assertDatabaseHas('users', [
    //         'account_id' => 1,
    //         'full_name' => 'Septian Nanda',
    //     ]);
    // }

    // /** @test */
    // public function it_can_update_biodata_for_account_id_1()
    // {
    //     // Tambahkan biodata terlebih dahulu
    //     User::create([
    //         'account_id' => 1,
    //         'full_name' => 'Nama Lama',
    //         'gender' => 'Laki-laki',
    //         'birth_date' => '2000-01-01',
    //         'phone_number' => '0811111111',
    //         'address' => 'Bandung',
    //         'university' => 'Telkom University',
    //         'major' => 'Informatika',
    //         'semester' => '5',
    //         'instagram_handle' => '@lama',
    //     ]);

    //     $response = $this->putJson('/api/account/biodata/1', [
    //         'full_name' => 'Septian Baru',
    //         'gender' => 'Laki-laki',
    //         'birth_date' => '2000-02-02',
    //         'phone_number' => '0822222222',
    //         'address' => 'Jakarta',
    //         'university' => 'Telkom University',
    //         'major' => 'Software Engineering',
    //         'semester' => '6',
    //         'instagram_handle' => '@septianbaru',
    //     ]);

    //     $response->assertStatus(200);
    //     $this->assertDatabaseHas('users', [
    //         'account_id' => 1,
    //         'full_name' => 'Septian Baru',
    //         'major' => 'Software Engineering',
    //     ]);
    // }
// }
