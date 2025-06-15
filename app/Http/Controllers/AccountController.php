<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AccountController extends Controller
{

    function index() {}

    function manage()
    {
        $account = Account::all();
        return view('/admin/manage-account', ['accountList' => $account]);
    }

    public function create()
    {
        return view('page/register');
    }

    // LANGKAH 1: Simpan akun ke tabel 'accounts'
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:accounts,email',
            'password' => 'required|confirmed|min:6',
        ], [
            'email.unique' => 'Email sudah digunakan!',
            'email.email' => 'Format email tidak valid.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'name.required' => 'Nama wajib diisi.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'messages' => $validator->errors()->all()
            ], 422);
        }

        try {
            DB::table('accounts')->insert([
                'name' => $request->name,
                'email' => $request->email,
                'role' => 'user',
                'password' => Hash::make($request->password),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Akun berhasil dibuat!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal membuat akun. Silakan coba lagi.',
                'debug' => $e->getMessage() // opsional: hapus ini di produksi
            ], 500);
        }
    }


    // public function store(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'name' => 'required',
    //         'email' => 'required|email|unique:accounts,email',
    //         'password' => 'required|confirmed|min:6',
    //     ], [
    //         'email.unique' => 'Akun sudah digunakan!',
    //         'email.email' => 'Format email tidak valid.',
    //         'password.confirmed' => 'Konfirmasi password tidak cocok.',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'status' => 'error',
    //             'messages' => $validator->errors()->all()
    //         ], 422);
    //     }

    //     DB::table('accounts')->insert([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'role' => 'user',
    //         'password' => bcrypt($request->password),
    //     ]);

    //     return response()->json([
    //         'status' => 'success',
    //         'message' => 'You Have Created Your Account!'
    //     ]);
    // }


    public function edit(Account $account)
    {
        return view('page.account-edit', compact('account'));
    }

    public function update(Request $request, Account $account)
    {

        $validateData = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);
        // dd($validateData);
        $account->name = $validateData['name'];
        $account->email = $validateData['email'];
        $account->password = bcrypt($validateData['password']);


        $account->save();
        return redirect()->route('manage');
    }

    public function destroy(Account $account)
    {
        $account->delete();
        return redirect()->route('manage')->with('success', 'Account has been deleted successfully');
    }

    // Menampilkan form forgot password
    public function forgot()
    {
        return view('page.forgot-pass');
    }

    public function createBiodata(Request $request)
    {
        $validated = $request->validate([
            'account_id' => 'required|exists:accounts,id',
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

        $existing = User::where('account_id', $validated['account_id'])->first();
        if ($existing) {
            return response()->json(['error' => 'Biodata already exists for this account.'], 409);
        }

        User::create($validated);
        return response()->json(['message' => 'Biodata created successfully.']);
    }

    public function createBiodataForm(Request $request)
    {

        $accountId = $request->query('account_id') ?? auth()->id();

        // Ambil data biodata jika sudah pernah diisi
        $biodata = User::where('account_id', $accountId)->first();

        // Kirim ke view
        return view('page.create_biodata', compact('accountId', 'biodata'));
    }

    public function updateBiodata(Request $request)
{
    \Log::info('Update Biodata Called:', $request->all());

    $validated = $request->validate([
        'account_id' => 'required|exists:accounts,id',
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

    $user = User::where('account_id', $validated['account_id'])->first();
    \Log::info('User ditemukan:', [$user]);

    if ($user) {
        $user->update($validated);
        return response()->json(['message' => 'Biodata berhasil diperbarui.']);
    }

    User::create($validated);
    return response()->json(['message' => 'Biodata baru berhasil dibuat.']);
}



    // public function updateBiodata(Request $request, $account_id)
    // {
    //     $user = User::where('account_id', $account_id)->first();

    //     if (!$user) {
    //         return response()->json(['error' => 'Biodata not found.'], 404);
    //     }

    //     $validated = $request->validate([
    //         'full_name' => 'required|string',
    //         'gender' => 'nullable|string',
    //         'birth_date' => 'nullable|date',
    //         'phone_number' => 'nullable|string',
    //         'address' => 'nullable|string',
    //         'university' => 'nullable|string',
    //         'major' => 'nullable|string',
    //         'semester' => 'nullable|string',
    //         'instagram_handle' => 'nullable|string',
    //     ]);

    //     $user->update($validated);
    //     return response()->json(['message' => 'Biodata updated successfully.']);
    // }
}

// public function store(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'name' => 'required',
    //         'email' => 'required|email|unique:accounts,email',
    //         'password' => 'required|confirmed|min:6'
    //     ], [
    //         'email.unique' => 'Akun sudah digunakan!',
    //         'email.email' => 'Format email tidak valid.',
    //         'password.confirmed' => 'Konfirmasi password tidak cocok.',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'status' => 'error',
    //             'messages' => $validator->errors()->all()
    //         ], 422);
    //     }

    //     DB::table('accounts')->insert([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'role' => 'user',
    //         'password' => bcrypt($request->password)
    //     ]);

    //     return response()->json([
    //         'status' => 'success',
    //         'message' => 'You Have Created Your Account!'
    //     ]);
    // }
