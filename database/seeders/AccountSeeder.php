<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Account;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('accounts')->insert([
            'name' => 'Admin',
            'email' => 'koh@gmail.com',
            'password' => Hash::make('321'),
            'role' => 'admin'
        ]);
        Account::factory()->count(5)->hasUser()->create();
    }
}
