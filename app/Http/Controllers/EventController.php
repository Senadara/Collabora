<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Config;

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
        $event = Event::where('name_event', 'LIKE', '%' . $search . '%')->get();
        return view('page/dashboard', ['events' => $event]);
    }

    function create()
    {
        $class = Event::all();
        return view('page/create-event', ['class' => $class]);
    }

    public function store(Request $request)
    {
        try {
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

            $filePath = null;

            if ($request->hasFile('image')) {
                $folder = 'event';
                $file = $request->file('image');
                $filename = time() . '_' . $file->getClientOriginalName();

                $storagePath = config("imagepath.folders.$folder.storage_path");
                $urlPath = config("imagepath.folders.$folder.url_path");

                if (!file_exists($storagePath)) {
                    mkdir($storagePath, 0777, true);
                }

                $file->move($storagePath, $filename);

                $filePath = config("imagepath.folders.$folder.db_path") . '/' . $filename;
            }

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

    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        $validatedData = $request->validate([
            'name_event' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'date' => 'required|date|after_or_equal:today',
            'description_event' => 'required|string',
        ], [
            'date.after_or_equal' => 'Tanggal event tidak boleh di masa lalu.',
        ]);
        $event->update($validatedData);
        return redirect()->back()->with('status', 'Event berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);

        if ($event->event_image) {
            $dbPath = $event->event_image;

            $segments = explode('/', trim($dbPath, '/'));
            $folder = $segments[1] ?? null; // index 0 = 'storage', index 1 = 'event'

            if ($folder && isset($segments[2])) {
                $filename = $segments[2];
                $storagePath = config("imagepath.folders.$folder.storage_path");

                $fullPath = $storagePath . '/' . $filename;

                if (File::exists($fullPath)) {
                    File::delete($fullPath);
                }
            }
        }

        $event->delete();

        return redirect('/event')->with('status', 'Event berhasil dihapus.');
    }
}
