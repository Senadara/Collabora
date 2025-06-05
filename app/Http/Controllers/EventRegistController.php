<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\event;
use App\Models\EventRegistModel;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class EventRegistController extends Controller
{
    public function addeventregist(Request $request , $event)
{
     // Ambil ID user dari session
    $userId = session('account')->id;

    // Cari event berdasarkan ID
    $eventData = Event::findOrFail($event);

    // Validasi: Cegah user mendaftarkan diri ke event yang dia buat sendiri
    if ($eventData->account_id == $userId) {
        return response()->json([
            'status' => 'error',
            'message' => 'Anda tidak dapat mendaftar sebagai volunteer untuk event yang Anda buat sendiri.'
        ], 403);
    }

    // Validasi input lainnya
    $this->validate($request, [
        'phone' => 'required',
        'experience' => 'required'
    ]);

    // Simpan pendaftaran volunteer
    EventRegistModel::create([
        'account_id' => $userId,
        'phone' => $request->phone,
        'status' => 'request',
        'reward' => 'false',
        'experience' => $request->experience,
        'event_id' => $event
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
        $volunteer = EventRegistModel::with('event','account')->where('event_id', $event)->get();
        return view('page/list-volunteer', ['volunteerList' => $volunteer]);
    }
    public function showAccepted($event)
    {
        // dd($event);

        $data = event::where('id',$event)->first();
        $volunteer = EventRegistModel::where('event_id', $event)->get();
        // dd($volunteer);
        return view('page/accepted-volunteer', ['volunteerList' => $volunteer,'event'=>$data]);
    }
    public function deny($id){
        $volunteer = EventRegistModel::findOrFail($id);
        // dd($volunteer);
        $volunteer->delete();
        return redirect('/event');
    }
    public function accept($id){
        $volunteer = EventRegistModel::findOrFail($id);
        $volunteer->status='accepted';
        $volunteer->save();
        return redirect('/event');
    }
}
