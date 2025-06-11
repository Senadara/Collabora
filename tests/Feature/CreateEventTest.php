<?php

namespace Tests\Feature;

use App\Models\Account;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CreateEventTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_event_successfully()
    {
        Storage::fake('public');
        $account = Account::factory()->create();
        Session::put('account', $account);
        $image = UploadedFile::fake()->image('event.jpg');

        $response = $this->post('/event', [
            'name_event' => 'Event Test',
            'location' => 'Jakarta',
            'date' => now()->addDay()->format('Y-m-d'),
            'description_event' => 'Deskripsi event test',
            'image' => $image,
        ]);

        $response->assertRedirect('/event');
        $response->assertSessionHas('status', 'Event berhasil dibuat!');

        $this->assertDatabaseHas('event', [
            'name_event' => 'Event Test',
            'location' => 'Jakarta',
            'account_id' => $account->id,
        ]);
    }
}
