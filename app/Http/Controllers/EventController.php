<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Rating;
use Illuminate\Http\Request;

class EventController extends Controller
{
    //
    function index()
    {
        $event = Event::where('account_id', session('account')->id)->get();
        return view('event/index', ['eventList' => $event]);
    }

    function adminEvent()
    {
        $event = Event::all();
        return view('event/index', ['eventList' => $event]);
    }

    function search(Request $request)
    {
        $event = Event::all();
        $search = $request->search;
        $event = event::where('name_event', 'LIKE', '%' . $search . '%')->get();
        return view('page/dashboard', ['events' => $event]);
    }

    function create()
    {
        $class = event::all();
        return view('page/create-event', ['class' => $class]);
    }

    public function store(Request $request)
    {
        try {
            // Validasi input
            $validatedData = $request->validate([
                'name_event' => 'required|string|max:255',
                'location' => 'required|string|max:255',
                'date' => ['required', 'date', 'after_or_equal:today'],
                'description_event' => 'required|string',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ], [
                'date.after_or_equal' => 'Tanggal event tidak boleh di masa lalu.',
                'image.image' => 'File harus berupa gambar.',
                'image.mimes' => 'Format gambar tidak didukung. Gunakan jpeg, png, jpg, gif, atau svg.',
            ]);

            // Proses upload file jika tersedia
            $filePath = null;
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('event', $filename, 'public');
            }

            // Simpan data ke database
            $event = new Event;
            $event->name_event = $validatedData['name_event'];
            $event->location = $validatedData['location'];
            $event->date = $validatedData['date'];
            $event->description_event = $validatedData['description_event'];
            $event->event_image = $filePath;
            $event->account_id = session('account')->id;
            $event->save();

            return redirect('/event')->with('status', 'Event berhasil dibuat!');
        } catch (\Exception $e) {
            // Tangani error (misalnya error penyimpanan, error file, dll.)
            return redirect()->back()
                ->withErrors(['msg' => 'Gagal membuat event: ' . $e->getMessage()])
                ->withInput();
        }
    }



    function show($id)
    {
        $event = Event::find($id);
        $avgRating = Rating::where('event_id', $event->id)->avg('star');
        return view('page/event-show', [

            'eventList' => $event,
            'avgRating' => $avgRating,
        ]);
    }

    function edit($id)
    {
        $event = Event::find($id);
        return view('page/event-edit', [
            'eventList' => $event
        ]);
    }

    function update(Request $request, $id)
    {
        $event = Event::find($id);
        $validateData = $request->validate([
            'name_event' => 'required',
            'location' => 'required',
            'date' => 'required',
            'description_event' => 'required'
        ]);
        $event->name_event = $validateData['name_event'];
        $event->location = $validateData['location'];
        $event->date = $validateData['date'];
        $event->description_event = $validateData['description_event'];
        $event->save();
        return redirect()->route('index');
    }

    function destroy($id)
    {
        $event = event::where('id', $id);
        $event->delete();
        return redirect('/event');
    }
}
