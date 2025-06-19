<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class AccountController extends Controller
{

    function index()
    {
        $account = Account::all();
        return view('/admin/manage-account', ['accountList' => $account]);
    }

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

    public function edit(Account $account)
    {
        return view('page.account-edit', compact('account'));
    }

    public function update(Request $request, Account $account)
    {
        $validateData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:accounts,email,' . $account->id,
            'password' => 'nullable|min:6'
        ]);

        $account->name = $validateData['name'];
        $account->email = $validateData['email'];

        if (!empty($validateData['password'])) {
            $account->password = bcrypt($validateData['password']);
        }

        $account->save();

        return redirect()
            ->back()
            ->with('success', 'Account berhasil diperbarui!');
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

    public function createOrUpdateBiodata(Request $request)
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

        $user = User::where('account_id', $validated['account_id'])->first();

        if ($user) {
            $user->update($validated);
            return redirect()->back()->with('success', 'Biodata berhasil diperbarui.');
        } else {
            User::create($validated);
            return redirect()->back()->with('success', 'Biodata berhasil dibuat.');
        }
    }

    public function createBiodataForm(Request $request)
    {
        $accountId = $request->query('account_id') ?? auth()->id();
        $biodata = User::where('account_id', $accountId)->first();

        return view('page.create_biodata', compact('accountId', 'biodata'));
    }
}
