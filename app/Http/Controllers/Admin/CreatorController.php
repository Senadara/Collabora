<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Storage;

class CreatorController extends Controller
{
    public function form()
    {
        $account = Auth::user();
        $user = $account->user;

        return view('page.event-creator-regis', [
            'status' => $user->creator_request_status,
            'user' => $user
        ]);
    }

    public function register(Request $request)
    {
        $account = Auth::user();
        $user = $account->user;

        if ($user->creator_request_status === 'approved') {
            return redirect()->back()->with('error', 'Akun Anda sudah disetujui sebagai Event Creator.');
        }

        $request->validate([
            'ktp_photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'selfie_photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            // Simpan file
            $ktpPath = $request->file('ktp_photo')->store('ktp_photos', 'public');
            $selfiePath = $request->file('selfie_photo')->store('selfie_photos', 'public');

            // Update user
            $user->ktp_photo = $ktpPath;
            $user->selfie_photo = $selfiePath;
            $user->creator_request_status = 'pending'; // reset status jika sebelumnya rejected
            $user->save();

            return redirect()->route('creator.form')->with('success', 'Pengajuan berhasil dikirim.');
        } catch (\Exception $e) {
            return redirect()->route('creator.form')->with('error', 'Terjadi kesalahan saat mengunggah. Silakan coba lagi.');
        }
    }


    public function index()
    {
        $users = User::with('account')->where('creator_request_status', 'pending')->get();
        return view('admin/event-creator-requests', compact('users'));
    }

    public function approve($id)
    {
        $user = User::findOrFail($id);
        $user->creator_request_status = 'approved';
        $user->save();

        $user->account->role = 'event_creator';
        $user->account->save();

        return redirect()->back()->with('success', 'Event Creator diterima');
    }

    public function reject($id)
    {
        $user = User::findOrFail($id);
        $user->creator_request_status = 'rejected';
        $user->save();

        return redirect()->back()->with('success', 'Pengajuan ditolak');
    }
}
