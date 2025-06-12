<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\Event;
use App\Models\EventRegistModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class EventRegistControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Create an admin account for testing purposes, as per the routes defined in web.php
        $adminAccount = Account::factory()->create([
            'email' => 'admin@example.com',
            'role' => 'admin',
        ]);
        Session::put('account', $adminAccount);
    }

    /**
     * Test displaying volunteer attendance (requests).
     * This tests the `show` method of `EventRegistController` which retrieves all registrations for an event,
     * and indirectly verifies the `list-volunteer.blade.php` view filters for 'request' status.
     *
     * @return void
     */
    public function test_view_volunteer_attendance_requests()
    {
        $eventOwner = Account::factory()->create();
        $event = Event::factory()->create(['account_id' => $eventOwner->id]);

        $volunteer1 = Account::factory()->create(['name' => 'Volunteer One']);
        $volunteer2 = Account::factory()->create(['name' => 'Volunteer Two']);
        $volunteer3 = Account::factory()->create(['name' => 'Volunteer Three']);

        // Volunteer 1 and 2 are in 'request' status
        EventRegistModel::create([
            'account_id' => $volunteer1->id,
            'event_id' => $event->id,
            'phone' => '111111111',
            'experience' => 'Some experience',
            'status' => 'request',
            'reward' => 'false',
        ]);
        EventRegistModel::create([
            'account_id' => $volunteer2->id,
            'event_id' => $event->id,
            'phone' => '222222222',
            'experience' => 'More experience',
            'status' => 'request',
            'reward' => 'false',
        ]);
        // Volunteer 3 is 'accepted'
        EventRegistModel::create([
            'account_id' => $volunteer3->id,
            'event_id' => $event->id,
            'phone' => '333333333',
            'experience' => 'Accepted experience',
            'status' => 'accepted',
            'reward' => 'false',
        ]);

        $response = $this->get(route('show.volunteer', ['event' => $event->id]));

        $response->assertStatus(200);
        $response->assertViewIs('page.list-volunteer'); // Corrected from 'page/list-volunteer'
        $response->assertViewHas('volunteerList');

        // Assert that the 'request' volunteers are present in the response (filtered by the view)
        $response->assertSee('Volunteer One');
        $response->assertSee('Volunteer Two');
        $response->assertDontSee('Volunteer Three'); // Volunteer Three should not be shown in the 'request' list
    }

    /**
     * Test displaying the list of accepted volunteers.
     * This tests the `showAccepted` method of `EventRegistController`.
     *
     * @return void
     */
    public function test_view_list_volunteer_sorting_accepted()
    {
        $eventOwner = Account::factory()->create();
        $event = Event::factory()->create(['account_id' => $eventOwner->id]);

        $volunteer1 = Account::factory()->create(['name' => 'Accepted Volunteer One']);
        $volunteer2 = Account::factory()->create(['name' => 'Requested Volunteer Two']);
        $volunteer3 = Account::factory()->create(['name' => 'Accepted Volunteer Three']);

        EventRegistModel::create([
            'account_id' => $volunteer1->id,
            'event_id' => $event->id,
            'phone' => '111111111',
            'experience' => 'Experience one',
            'status' => 'accepted',
            'reward' => 'false',
        ]);
        EventRegistModel::create([
            'account_id' => $volunteer2->id,
            'event_id' => $event->id,
            'phone' => '222222222',
            'experience' => 'Experience two',
            'status' => 'request',
            'reward' => 'false',
        ]);
        EventRegistModel::create([
            'account_id' => $volunteer3->id,
            'event_id' => $event->id,
            'phone' => '333333333',
            'experience' => 'Experience three',
            'status' => 'accepted',
            'reward' => 'false',
        ]);

        $response = $this->get(route('show.accepted.volunteer', ['event' => $event->id]));

        $response->assertStatus(200);
        $response->assertViewIs('page.accepted-volunteer'); // Corrected from 'page/accepted-volunteer'
        $response->assertViewHas('volunteerList');

        // Assert that only 'accepted' volunteers are present in the response
        $response->assertSee('Accepted Volunteer One');
        $response->assertDontSee('Requested Volunteer Two'); // Requested volunteer should not be seen
        $response->assertSee('Accepted Volunteer Three');
    }

    /**
     * Test that an admin can accept a new volunteer for an event they created.
     *
     * @return void
     */
    public function test_admin_can_accept_new_volunteer_for_their_event()
    {
        // The admin account is already created in setUp() and stored in the session.
        $adminAccount = Session::get('account');

        // Create an event owned by this admin
        $event = Event::factory()->create(['account_id' => $adminAccount->id]);

        // Create a volunteer account
        $volunteer = Account::factory()->create(['name' => 'New Volunteer']);

        // Create an EventRegistModel entry for this volunteer with 'request' status
        $registration = EventRegistModel::create([
            'account_id' => $volunteer->id,
            'event_id' => $event->id,
            'phone' => '444444444',
            'experience' => 'Some new experience',
            'status' => 'request',
            'reward' => 'false',
        ]);

        // Act as the admin and call the accept route
        $response = $this->actingAs($adminAccount)->get(route('accept.volunteer', ['id' => $registration->id]));

        // Assert that the response redirects (status 302)
        $response->assertStatus(302);
        $response->assertRedirect('/event'); // Assuming it redirects back to the event list or a relevant page

        // Assert that the volunteer's status has been updated to 'accepted' in the database
        $this->assertDatabaseHas('event_regist', [
            'id' => $registration->id,
            'status' => 'accepted',
        ]);
    }
}
