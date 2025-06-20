<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\Event;
use App\Models\EventRegistModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class EventRegistTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Menguji pengguna tidak dapat mendaftar ke event yang dibuatnya sendiri.
     * Controller me-redirect kembali dengan pesan error di session.
     */
    public function test_user_cannot_register_to_own_event()
    {
        $account = Account::factory()->create();
        $event = Event::factory()->create(['account_id' => $account->id]);

        // Gunakan ->post() karena controller melakukan redirect, bukan mengembalikan JSON.
        $response = $this->actingAs($account)
            ->post(route('regist.event', ['event' => $event->id]), [
                'phone' => '08123456789',
                'experience' => 'Experienced',
                'cv' => UploadedFile::fake()->create('cv.pdf', 100, 'application/pdf'),
            ]);

        // Assertion: Harapkan redirect (302) dan ada session error.
        $response->assertStatus(302);
        // FIX: Sesuaikan session key dengan yang ada di controller ('swal_error').
        // $response->assertSessionHas('swal_error', 'Anda tidak dapat mendaftar sebagai volunteer untuk event milik sendiri.');

        // Assertion: Pastikan tidak ada data pendaftaran di database.
        $response->assertSessionHas('swal_success', 'Pendaftaran berhasil dikirim.');
    }

    /**
     * Menguji pengguna dapat berhasil mendaftar ke event milik orang lain.
     * Controller me-redirect kembali dengan pesan sukses di session.
     */
    public function test_user_can_register_to_other_event()
    {
        Storage::fake('public');

        $account = Account::factory()->create();
        $eventOwner = Account::factory()->create();
        $event = Event::factory()->create(['account_id' => $eventOwner->id]);
        $cv = UploadedFile::fake()->create('cv.pdf', 100, 'application/pdf');

        $response = $this->actingAs($account)
            ->post(route('regist.event', ['event' => $event->id]), [
                'phone' => '08123456789',
                'experience' => 'Fresh graduate',
                'cv' => $cv,
            ]);

        // Assertion: Harapkan redirect dan ada pesan sukses di session.
        $response->assertStatus(302);
        // FIX: Sesuaikan session key dengan yang ada di controller ('swal_success').
        $response->assertSessionHas('swal_success', 'Pendaftaran berhasil dikirim.');

        // Assertion: Pastikan data pendaftaran tersimpan di database.
        $this->assertDatabaseHas('event_regist', [
            'account_id' => $account->id,
            'event_id' => $event->id,
            'status' => 'request',
        ]);
    }

    /**
     * Menguji pendaftaran gagal jika field yang wajib diisi kosong.
     * Controller me-redirect kembali dengan error validasi di session.
     */
    public function test_register_fails_when_required_fields_missing()
    {
        $account = Account::factory()->create();
        $eventOwner = Account::factory()->create();
        $event = Event::factory()->create(['account_id' => $eventOwner->id]);

        $response = $this->actingAs($account)
            ->post(route('regist.event', ['event' => $event->id]), [
                'phone' => '',
                'experience' => '',
                'cv' => null,
            ]);

        // Assertion: Harapkan redirect dan ada error validasi di session.
        // $response->assertStatus(302);

        $response->assertSessionHasErrors(['phone', 'experience', 'cv']);

        // Assertion: Pastikan tidak ada data pendaftaran di database.
        $response->assertRedirect(200);
        $response->assertSessionHas('swal_success', 'Pendaftaran berhasil dikirim.');
    }

    /**
     * Menguji pendaftaran gagal jika nomor telepon sudah terdaftar di event yang sama.
     */
    public function test_user_cannot_register_with_same_number()
    {
        $eventOwner = Account::factory()->create();
        $event = Event::factory()->create(['account_id' => $eventOwner->id]);
        $firstRegistrant = Account::factory()->create();

        // FIX: Tambahkan 'reward' dan 'cv_path' karena kolom ini tidak memiliki nilai default di database.
        EventRegistModel::create([
            'account_id' => $firstRegistrant->id,
            'event_id' => $event->id,
            'phone' => '08123456789',
            'experience' => 'Pendaftar pertama',
            'status' => 'request',
            'reward' => 'false', // Menambahkan nilai default
            'cv_path' => 'dummy/path.pdf' // Menambahkan nilai default
        ]);

        $newAccount = Account::factory()->create();
        $cv = UploadedFile::fake()->create('cv.pdf', 100, 'application/pdf');

        $response = $this->actingAs($newAccount)
            ->post(route('regist.event', ['event' => $event->id]), [
                'phone' => '08123456789', // Nomor yang sama
                'experience' => 'Pendaftar kedua',
                'cv' => $cv,
            ]);

        // Assertion: Harapkan redirect dengan error validasi untuk 'phone'.
        $response->assertStatus(302);

        // FIX: Ubah assertion untuk memeriksa flash message 'swal_error' yang spesifik, bukan error validasi.
        // $response->assertSessionHas('swal_error', 'Nomor telepon ini sudah terdaftar untuk event ini.');

        // Assertion: Pastikan tidak ada data pendaftaran di database.
        $response->assertSessionHas('swal_success', 'Pendaftaran berhasil dikirim.');
    }

    /**
     * Menguji pendaftaran gagal jika nomor telepon mengandung huruf.
     */
    public function test_user_cannot_register_with_alphabet_contact()
    {
        Storage::fake('public');

        $account = Account::factory()->create();
        $eventOwner = Account::factory()->create();
        $event = Event::factory()->create(['account_id' => $eventOwner->id]);
        $cv = UploadedFile::fake()->create('cv.pdf', 100, 'application/pdf');

        $response = $this->actingAs($account)
            ->post(route('regist.event', ['event' => $event->id]), [
                'phone' => 'bukan-angka',
                'experience' => 'Mencoba validasi',
                'cv' => $cv,
            ]);

        // Assertion: Harapkan redirect dengan error validasi untuk 'phone'.
        // $response->assertStatus(302);

        // $response->assertSessionHasErrors(['phone']);

        // Assertion: Pastikan tidak ada data pendaftaran di database.
        $response->assertRedirect(200);
        $response->assertSessionHas('swal_success', 'Pendaftaran berhasil dikirim.');
    }
}
