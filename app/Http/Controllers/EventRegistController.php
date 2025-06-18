<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Event;
use App\Models\EventRegistModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class EventRegistController extends Controller
{

    public function addeventregist(Request $request, $eventId)
    {
        $user = session('account');

        $event = Event::findOrFail($eventId);

        // Cegah daftar ke event sendiri
        if ($event->account_id == $user->id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tidak bisa mendaftar ke event milik sendiri.'
            ], 403);
        }

        // Cegah daftar ulang
        if (EventRegistModel::where('account_id', $user->id)->where('event_id', $eventId)->exists()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Anda sudah mendaftar sebagai volunteer.'
            ], 409);
        }

        // Validasi
        $validator = Validator::make($request->all(), [
            'phone' => 'required|regex:/^(\+62|62|0)[0-9]{9,13}$/',
            'experience' => 'required|string',
            'cv' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Upload file
        $cvPath = null;
        if ($request->hasFile('cv')) {
            $filename = time() . '_' . $request->file('cv')->getClientOriginalName();
            $cvPath = 'uploads/cv/' . $filename;
            $request->file('cv')->move(public_path('uploads/cv'), $filename);
        }

        // Simpan pendaftaran
        EventRegistModel::create([
            'event_id' => $eventId,
            'account_id' => $user->id,
            'phone' => $request->phone,
            'experience' => $request->experience,
            'cv' => $cvPath,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Pendaftaran volunteer berhasil.'
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
