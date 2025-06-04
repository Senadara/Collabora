<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $accountId = 1; // ganti sesuai ID yang ingin dibuat biodata-nya

        User::factory()->create([
            'account_id' => $accountId,
            'full_name' => 'Septian Nanda Saputra',
            'gender' => 'Laki-laki',
            'birth_date' => '2001-03-15',
            'phone_number' => '081234567890',
            'address' => 'Bandung',
            'university' => 'Telkom University',
            'major' => 'Software Engineering',
            'semester' => 6,
            'instagram_handle' => '@septian_nanda',
        ]);
    }
}
