<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Event;
use App\Models\EventRegistModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class EventRegistController extends Controller
{

public function addeventregist(Request $request, $event)
{
    $userId = session('account')->id;

    // Cari event
    $eventData = Event::findOrFail($event);

    // Cegah user daftar ke event miliknya sendiri
    if ($eventData->account_id == $userId) {
        return response()->json([
            'status' => 'error',
            'message' => 'Anda tidak dapat mendaftar sebagai volunteer untuk event yang Anda buat sendiri.'
        ], 403);
    }

    // Validasi manual untuk bisa return semua error sebagai JSON
    $validator = Validator::make($request->all(), [
        'phone' => 'required',
        'experience' => 'required',
        'cv' => 'required|mimes:pdf,doc,docx|max:2048',
    ]);

    // Jika validasi gagal, kirim JSON error field
    if ($validator->fails()) {
        return response()->json([
            'status' => 'error',
            'message' => 'Validasi gagal',
            'errors' => $validator->errors()  // akan berisi error per kolom
        ], 422);
    }

    // Upload CV jika ada
    $cvPath = null;
    if ($request->hasFile('cv')) {
        $cvPath = $request->file('cv')->store('CV', 'public');
    }

    // Simpan pendaftaran
    EventRegistModel::create([
        'account_id' => $userId,
        'phone' => $request->phone,
        'status' => 'request',
        'reward' => 'false',
        'experience' => $request->experience,
        'event_id' => $event,
        'cv_path' => $cvPath,
    ]);

    return response()->json([
        'status' => 'success',
        'message' => 'You have successfully registered for the event.'
    ]);
}


    public function index()
    {
        $volunteer = EventRegistModel::with('event')->where('account_id', session('account')->id)->get();
        return view('page/list-volunteer', ['volunteerList' => $volunteer]);
    }

    public function show($event)
    {
        $volunteer = EventRegistModel::with('event', 'account')->where('event_id', $event)->get();
        return view('page/list-volunteer', ['volunteerList' => $volunteer]);
    }

    public function showAccepted($event)
    {
        $data = Event::where('id', $event)->first();
        $volunteer = EventRegistModel::where('event_id', $event)->get();
        return view('page/accepted-volunteer', ['volunteerList' => $volunteer, 'event' => $data]);
    }

    public function deny($id)
    {
        $volunteer = EventRegistModel::findOrFail($id);
        $volunteer->delete();
        return redirect('/event');
    }

    public function accept($id)
    {
        $volunteer = EventRegistModel::findOrFail($id);
        $volunteer->status = 'accepted';
        $volunteer->save();
        return redirect('/event');
    }
}
