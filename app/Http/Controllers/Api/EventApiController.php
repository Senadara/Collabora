<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Rating;
use Illuminate\Http\Request;

class EventApiController extends Controller
{
    // GET: /api/events
    public function index()
    {
        $events = Event::all();
        return response()->json([
            'success' => true,
            'data' => $events
        ]);
    }

    // GET: /api/events/{id}
    public function show($id)
    {
        $event = Event::find($id);

        if (!$event) {
            return response()->json([
                'success' => false,
                'message' => 'Event not found.'
            ], 404);
        }

        $avgRating = Rating::where('event_id', $event->id)->avg('star');

        return response()->json([
            'success' => true,
            'data' => $event,
            'average_rating' => $avgRating
        ]);
    }

    // PUT: /api/events/{id}
    public function update(Request $request, $id)
    {
        $event = Event::find($id);

        if (!$event) {
            return response()->json([
                'success' => false,
                'message' => 'Event not found.'
            ], 404);
        }

        $validatedData = $request->validate([
            'name_event' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'date' => 'required|date|after_or_equal:today',
            'description_event' => 'required|string',
        ], [
            'date.after_or_equal' => 'Tanggal event tidak boleh di masa lalu.',
        ]);

        $event->update($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Event berhasil diperbarui.',
            'data' => $event
        ]);
    }
}
