<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Event;
use App\Models\EventRegistModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class EventRegistController extends Controller
{
    public function addeventregist(Request $request, $event)
    {
        $userId = auth()->id();

        if (EventRegistModel::where('account_id', $userId)
            ->where('event_id', $event)
            ->exists()
        ) {
            return back()
                ->withInput()
                ->with('swal_error', 'Anda sudah mendaftar sebagai volunteer pada event ini.')
                ->with('event_id', $event);
        }

        $validator = Validator::make($request->all(), [
            'phone' => ['required', 'regex:/^(\+62|62|0)8[1-9][0-9]{6,10}$/'],
            'experience' => ['required', 'string'],
            'cv' => ['required', 'file', 'mimes:pdf,doc,docx', 'max:2048'],
        ], [
            'phone.required' => 'Nomor telepon wajib diisi.',
            'phone.regex' => 'Format nomor telepon tidak valid.',
            'experience.required' => 'Pengalaman wajib diisi.',
            'cv.required' => 'CV wajib diunggah.',
            'cv.mimes' => 'CV harus berupa file PDF, DOC, atau DOCX.',
            'cv.max' => 'Ukuran file maksimal 2MB.',
        ]);

        // 3. Cek duplikasi nomor telepon pada event yang sama
        $phone = $request->phone;
        if (EventRegistModel::where('phone', $phone)
            ->where('event_id', $event)
            ->exists()
        ) {
            return back()
                ->withInput()
                ->with('swal_error', 'Nomor telepon ini sudah terdaftar untuk event ini.')
                ->with('event_id', $event);
        }

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('swal_error', 'Terdapat kesalahan pada input. Mohon periksa kembali.')
                ->with('event_id', $event);
        }

        $filePath = null;
        // Simpan file CV
        if ($request->hasFile('cv')) {
            $folder = 'cv';
            $file = $request->file('cv');
            $filename = time() . '_' . $file->getClientOriginalName();

            $storagePath = config("imagepath.folders.$folder.storage_path");
            //$urlPath = config("imagepath.folders.$folder.url_path");

            if (!file_exists($storagePath)) {
                mkdir($storagePath, 0777, true);
            }

            $file->move($storagePath, $filename);
            $filePath = config("imagepath.folders.$folder.db_path") . '/' . $filename;
        }

        // Simpan ke DB
        EventRegistModel::create([
            'account_id' => auth()->id(),
            'phone' => $request->phone,
            'status' => 'request',
            'reward' => 'false',
            'experience' => $request->experience,
            'event_id' => $event,
            'cv_path' => $filePath,
        ]);

        return back()->with('swal_success', 'Pendaftaran berhasil dikirim.');
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
