<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sponsorship;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class SponsorshipController extends Controller
{

    public function addsponsorship(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'account_id' => 'required',
            'event_id' => 'required',
            'nama_sponsor' => 'required',
            'contact' => ['required', 'regex:/^\d{10,13}$/'],
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'contact.regex' => 'Nomor kontak harus berupa angka 10 sampai 13 digit.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar tidak didukung. Gunakan jpeg, png, jpg, gif, atau svg.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator, 'sponsorship')
                ->withInput();
        }

        $validatedData = $validator->validated();

        $filePath = null;

        if ($request->hasFile('image')) {
            $folder = 'sponsor';
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();

            // Ambil path penyimpanan fisik dan URL path dari config
            $storagePath = config("imagepath.folders.$folder.storage_path");
            $urlPath = config("imagepath.folders.$folder.url_path");

            // Buat direktori jika belum ada
            if (!file_exists($storagePath)) {
                mkdir($storagePath, 0777, true);
            }

            // Simpan file secara manual
            $file->move($storagePath, $filename);

            // Simpan path yang dapat diakses URL
            $filePath = config("imagepath.folders.$folder.db_path") . '/' . $filename;
        }

        // Simpan ke database
        $sponsorship = new Sponsorship();
        $sponsorship->account_id = $validatedData['account_id'];
        $sponsorship->event_id = $validatedData['event_id'];
        $sponsorship->nama_sponsor = $validatedData['nama_sponsor'];
        $sponsorship->contact = $validatedData['contact'];
        $sponsorship->status = 'request';
        $sponsorship->img = $filePath;
        $sponsorship->save();

        return redirect('/event/show/' . $validatedData['event_id'])->with('status', 'Sponsorship berhasil ditambahkan!');
    }




    public function index($id)
    {
        $sponsor = Sponsorship::where('event_id', $id)->get();
        return view('page/sponsorshipList', ['sponsorshipList' => $sponsor]);
    }

    public function show($id_event)
    {
        $sponsor = Sponsorship::where('event_id', $id_event)->get();
        // dd($sponsor);
        return view('page/sponsorshipList', ['sponsorList' => $sponsor]);
    }

    public function deny($id)
    {
        $sponsor = Sponsorship::where('event_id', $id)->first();
        // dd($volunteer);
        $sponsor->delete();
        return redirect('/partner');
    }
    public function accept($id)
    {
        $sponsor = Sponsorship::where('id', $id)->first();
        $sponsor->status = 'partner';
        $sponsor->save();
        return redirect('/partner');
    }
    public function partner()
    {
        $sponsor = Sponsorship::all();
        return view('page/partner', ['listSponsor' => $sponsor]);
    }
}
