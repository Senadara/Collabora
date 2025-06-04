<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        Role::truncate();
        Schema::enableForeignKeyConstraints();

        $data = [
            ['name' => admin],
            ['name' => user]

        ];

        foreach ($data as $value){
            Role::insert([
                'name' => $value['name'],
                'created_at' => Carbon::now(),
                'upload_at' => Carbon::now()
            ]);
        }   
    }
}
