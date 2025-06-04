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
    $this->validate($request, [
        'phone' => 'required',
        'experience' => 'required'
    ]);

    EventRegistModel::create([
        'account_id' => session('account')->id,
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
