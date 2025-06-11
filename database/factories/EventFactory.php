<?php

// namespace Database\Factories;

// use App\Models\Event;
// use App\Models\Account;
// use Illuminate\Database\Eloquent\Factories\Factory;

// class EventFactory extends Factory
// {
//     protected $model = Event::class;

//     public function definition(): array
//     {
//         return [
//             'name_event' => $this->faker->sentence(3),
//             'location' => $this->faker->city,
//             'date' => $this->faker->date(),
//             'description_event' => $this->faker->paragraph,
//             'event_image' => 'default.jpg', // <<--- tambahkan ini // atau $this->faker->imageUrl() jika ingin dummy
//             'account_id' => Account::factory(), // pastikan kamu juga punya AccountFactory
//         ];
//     }
// }


namespace Database\Factories;

use App\Models\Event;
use App\Models\Account;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    protected $model = Event::class;

    public function definition()
    {
        return [
            'name_event' => $this->faker->sentence(3),
            'location' => $this->faker->city,
            'date' => $this->faker->date,
            'description_event' => $this->faker->paragraph,
            'event_image' => 'default.jpg',
            'account_id' => Account::factory(),
        ];
    }
}

