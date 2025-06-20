<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\Event;
use App\Models\EventRegistModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventRegistControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var \App\Models\Account
     */
    protected $eventOwner;

    /**
     * @var \App\Models\Event
     */
    protected $event;

    /**
     * Menyiapkan lingkungan tes.
     * Method ini dijalankan sebelum setiap tes dalam kelas ini.
     */
    protected function setUp(): void
    {
        parent::setUp();
        // 1. Buat satu pengguna dengan role 'event_creator' yang akan digunakan di semua tes.
        $this->eventOwner = Account::factory()->create(['role' => 'event_creator']);

        // 2. Buat satu event yang dimiliki oleh pengguna di atas.
        $this->event = Event::factory()->create(['account_id' => $this->eventOwner->id]);
    }

    /**
     * Tes untuk menampilkan halaman permintaan volunteer.
     *
     * @return void
     */
    public function test_view_volunteer_attendance_requests()
    {
        // Buat data pendaftar dengan status 'request' dan 'accepted'
        $requestingVolunteer = Account::factory()->create(['name' => 'Volunteer Request']);
        $acceptedVolunteer = Account::factory()->create(['name' => 'Volunteer Accepted']);

        // Menggunakan ::create() untuk menghindari ketergantungan pada file Factory
        EventRegistModel::create([
            'account_id' => $requestingVolunteer->id,
            'event_id' => $this->event->id,
            'status' => 'request',
            'reward' => 'false',
            'phone' => '123456789',
            'experience' => 'Some experience',
        ]);

        EventRegistModel::create([
            'account_id' => $acceptedVolunteer->id,
            'event_id' => $this->event->id,
            'status' => 'accepted',
                        'reward' => 'false',
            'phone' => '987654321',
            'experience' => 'Other experience',
        ]);

        // Bertindak sebagai pemilik acara dan akses rute
        $response = $this->actingAs($this->eventOwner)->get(route('show.volunteer', ['event' => $this->event->id]));

        // Lakukan assertion
        $response->assertStatus(200);
        $response->assertViewIs('page.list-volunteer');
        $response->assertSee('Volunteer Request');
        $response->assertDontSee('Volunteer Accepted'); // Pastikan volunteer yang diterima tidak ada di daftar permintaan
    }

    /**
     * Tes untuk menampilkan halaman daftar volunteer yang sudah diterima.
     *
     * @return void
     */
    public function test_view_list_volunteer_accepted()
    {
        // Buat data pendaftar dengan status 'request' dan 'accepted'
        $requestingVolunteer = Account::factory()->create(['name' => 'Requested Volunteer']);
        $acceptedVolunteer = Account::factory()->create(['name' => 'Accepted Volunteer']);

        EventRegistModel::create([
            'account_id' => $requestingVolunteer->id,
            'event_id' => $this->event->id,
            'status' => 'request',
            'reward' => 'false',
            'phone' => '123456789',
            'experience' => 'Some experience',
        ]);

        EventRegistModel::create([
            'account_id' => $acceptedVolunteer->id,
            'event_id' => $this->event->id,
            'status' => 'accepted',
            'reward' => 'false',
            'phone' => '987654321',
            'experience' => 'Other experience',
        ]);

        // Bertindak sebagai pemilik acara dan akses rute
        $response = $this->actingAs($this->eventOwner)->get(route('show.accepted.volunteer', ['event' => $this->event->id]));

        // Lakukan assertion
        $response->assertStatus(200);
        $response->assertViewIs('page.accepted-volunteer');
        $response->assertSee('Accepted Volunteer');
        $response->assertDontSee('Requested Volunteer'); // Pastikan volunteer yang meminta tidak ada di daftar diterima
    }

    /**
     * Tes bahwa pemilik acara dapat menerima permintaan volunteer.
     *
     * @return void
     */
    public function test_event_owner_can_accept_new_volunteer()
    {
        // Buat pendaftar dengan status 'request'
        $volunteer = Account::factory()->create();
        $registration = EventRegistModel::create([
            'account_id' => $volunteer->id,
            'event_id' => $this->event->id,
            'status' => 'request',
            'reward' => 'false',
            'phone' => '555555555',
            'experience' => 'Ready to be accepted',
        ]);

        // Bertindak sebagai pemilik acara dan panggil rute untuk menerima
        $response = $this->actingAs($this->eventOwner)->get(route('accept.volunteer', ['id' => $registration->id]));

        // Lakukan assertion
        $response->assertStatus(302);
        $response->assertRedirect('/event');

        // Pastikan status di database sudah berubah menjadi 'accepted'
        $this->assertDatabaseHas('event_regist', [
            'id' => $registration->id,
            'status' => 'accepted',
        ]);
    }
}
