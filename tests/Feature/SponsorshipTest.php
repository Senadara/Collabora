<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SponsorshipTest extends TestCase
{
    use RefreshDatabase;

    public function test_daftar_sponsorship_mengisi_semua_inputan_berhasil()
    {
        Storage::fake('public');

        // Buat akun dan event
        $account = Account::factory()->create();
        $event = Event::factory()->create();

        // Dummy file konfigurasi path
        $tempPath = storage_path('app/public/sponsor-test');
        File::ensureDirectoryExists($tempPath);

        Config::set("imagepath.folders.sponsor.storage_path", $tempPath);
        Config::set("imagepath.folders.sponsor.db_path", '/storage/sponsor-test');

        $image = UploadedFile::fake()->image('logo.jpg');

        $response = $this->post('/sponsorship/addsponsorship', [
            'account_id' => $account->id,
            'event_id' => $event->id,
            'nama_sponsor' => 'Sponsor Hebat',
            'contact' => '081234567890',
            'image' => $image,
        ]);

        $response->assertRedirect('/event/show/' . $event->id);
        $this->assertDatabaseHas('sponsorship', [
            'account_id' => $account->id,
            'event_id' => $event->id,
            'nama_sponsor' => 'Sponsor Hebat',
            'contact' => '081234567890',
            'status' => 'request',
        ]);
    }

    public function test_daftar_sponsorship_inputan_nama_sponsor_kosong()
    {
        Storage::fake('public');

        // Buat akun dan event
        $account = Account::factory()->create();
        $event = Event::factory()->create();

        // Dummy path untuk menyimpan file
        $tempPath = storage_path('app/public/sponsor-test');
        File::ensureDirectoryExists($tempPath);

        Config::set("imagepath.folders.sponsor.storage_path", $tempPath);
        Config::set("imagepath.folders.sponsor.db_path", '/storage/sponsor-test');

        $image = UploadedFile::fake()->image('logo.jpg');

        $response = $this->post('/sponsorship/addsponsorship', [
            'account_id' => $account->id,
            'event_id' => $event->id,
            'nama_sponsor' => '', // Kosong
            'contact' => '081234567890',
            'image' => $image,
        ]);

        // Pastikan terjadi redirect kembali (misalnya ke halaman form)
        $response->assertSessionHasErrorsIn('sponsorship', ['nama_sponsor']);

        // Pastikan tidak ada data yang masuk ke database
        $this->assertDatabaseMissing('sponsorship', [
            'account_id' => $account->id,
            'event_id' => $event->id,
            'contact' => '081234567890',
        ]);
    }

}
