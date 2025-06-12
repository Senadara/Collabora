<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class EventRegistTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_cannot_register_to_own_event()
    {
        $account = Account::factory()->create();
        $event = Event::factory()->create(['account_id' => $account->id]);

        $this->withSession(['account' => $account])
            ->postJson(route('regist.event', ['event' => $event->id]), [
                'phone' => '08123456789',
                'experience' => 'Experienced',
            ])
            ->assertStatus(403)
            ->assertJson([
                'status' => 'error',
                'message' => 'Anda tidak dapat mendaftar sebagai volunteer untuk event yang Anda buat sendiri.',
            ]);
    }

    public function test_user_can_register_to_other_event()
    {
        Storage::fake('public');

        $account = Account::factory()->create();
        $eventOwner = Account::factory()->create();
        $event = Event::factory()->create(['account_id' => $eventOwner->id]);

        $cv = UploadedFile::fake()->create('cv.pdf', 100, 'application/pdf');

        $this->withSession(['account' => $account])
            ->postJson(route('regist.event', ['event' => $event->id]), [
                'phone' => '08123456789',
                'experience' => 'Fresh graduate',
                'cv' => $cv,
            ])
            ->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'You have successfully registered for the event.',
            ]);

        $this->assertDatabaseHas('event_regist', [
            'account_id' => $account->id,
            'event_id' => $event->id,
            'status' => 'request',
            'reward' => 'false',
        ]);
    }

    public function test_register_fails_when_required_fields_missing()
    {
        $account = Account::factory()->create();
        $eventOwner = Account::factory()->create();
        $event = Event::factory()->create(['account_id' => $eventOwner->id]);

        $this->withSession(['account' => $account])
            ->postJson(route('regist.event', ['event' => $event->id]), [
                'phone' => '',
                'experience' => '',
                'cv' => "",
            ])
            ->assertFalse(422) // validasi gagal dengan JSON response
            ->assertJsonValidationErrors(['phone', 'experience']);
    }

    public function test_user_can_register_with_same_number()
    {
        Storage::fake('public');

        $account = Account::factory()->create();
        $eventOwner = Account::factory()->create();
        $event = Event::factory()->create(['account_id' => $eventOwner->id]);

        $cv = UploadedFile::fake()->create('cv.pdf', 100, 'application/pdf');

        $this->withSession(['account' => $account])
            ->postJson(route('regist.event', ['event' => $event->id]), [
                'phone' => '08123456789',
                'experience' => 'Fresh graduate',
                'cv' => $cv,
            ])
            ->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'You have successfully registered for the event.',
            ]);

        $this->assertDatabaseHas('event_regist', [
            'account_id' => $account->id,
            'event_id' => $event->id,
            'status' => 'request',
            'reward' => 'false',
        ]);
    }
}
