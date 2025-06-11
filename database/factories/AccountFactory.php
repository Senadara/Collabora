<?php

// namespace Database\Factories;

// use Illuminate\Database\Eloquent\Factories\Factory;

// class AccountFactory extends Factory
// {
//     public function definition(): array
//     {
//         return [
//             'name' => $this->faker->name,
//             'email' => $this->faker->unique()->safeEmail,
//             'password' => bcrypt('password'),
//             'role' => 'user'
//         ];
//     }
// }

namespace Database\Factories;

use App\Models\Account;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccountFactory extends Factory
{
    protected $model = Account::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => bcrypt('password'),
            'role' => 'user'
        ];
    }
}
