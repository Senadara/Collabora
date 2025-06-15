<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class BiodataController extends Controller
{
    public function create()
    {
        $accountId = auth()->id(); // ambil ID dari akun login
        $biodata = User::where('account_id', $accountId)->first(); // cari di tabel 'biodata'

        return view('page.create_biodata', compact('accountId', 'biodata'));
    }

    // LANGKAH 2: Simpan biodata user ke tabel 'users'
    public function store(Request $request)
    {
        $validated = $request->validate([
            // 'account_id' => 'required|exists:accounts,id',
             'account_id' => 'required',
            'full_name' => 'required|string',
            'gender' => 'nullable|string',
            'birth_date' => 'nullable|date',
            'phone_number' => 'nullable|string',
            'address' => 'nullable|string',
            'university' => 'nullable|string',
            'major' => 'nullable|string',
            'semester' => 'nullable|string',
            'instagram_handle' => 'nullable|string',
        ]);

        // Cek apakah biodata sudah ada
        $existing = User::where('account_id', $validated['account_id'])->first();
        if ($existing) {
            return response()->json([
                'status' => 'error',
                'message' => 'Biodata untuk akun ini sudah ada.'
            ], 409);
        }

        // Simpan biodata
        User::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Biodata berhasil disimpan.'
        ]);
    }

    public function update(Request $request)
{
    $accountId = $request->input('account_id'); // Ambil dari form
    $user = User::where('account_id', $accountId)->first();

    if (!$user) {
        return response()->json(['error' => 'Biodata tidak ditemukan.'], 404);
    }

    $validated = $request->validate([
        'full_name' => 'required|string',
        'gender' => 'nullable|string',
        'birth_date' => 'nullable|date',
        'phone_number' => 'nullable|string',
        'address' => 'nullable|string',
        'university' => 'nullable|string',
        'major' => 'nullable|string',
        'semester' => 'nullable|string',
        'instagram_handle' => 'nullable|string',
    ]);

    $user->update($validated);

    return response()->json(['message' => 'Biodata berhasil diperbarui.']);
}

}
