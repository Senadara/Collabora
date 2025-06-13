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
        $user = Auth::user()->user;
        if ($user->creator_status === 'pending') {
            return back()->with('info', 'Pengajuan Anda sedang diproses.');
        }

        return view('page.event-creator-regis');
    }

    public function register(Request $request)
    {
        $request->validate([
            'ktp_photo' => 'required|image|max:2048',
            'selfie_photo' => 'required|image|max:2048',
        ]);

        $account = Auth::user();
        $user = $account->user;

        // Simpan file
        $ktpPath = $request->file('ktp_photo')->store('ktp_photos', 'public');
        $selfiePath = $request->file('selfie_photo')->store('selfie_photos', 'public');

        // Update data
        $user->update([
            'ktp_photo' => $ktpPath,
            'selfie_photo' => $selfiePath,
            'creator_status' => 'pending',
        ]);

        return redirect('/dashboard')->with('success', 'Pengajuan berhasil dikirim.');
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
