<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    protected $model = \App\Models\User::class;

    public function definition()
    {
        return [
            'account_id' => 1, // Sesuaikan saat dipakai
            'full_name' => $this->faker->name,
            'gender' => $this->faker->randomElement(['Laki-laki', 'Perempuan']),
            'birth_date' => $this->faker->date(),
            'phone_number' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'university' => $this->faker->company,
            'major' => $this->faker->jobTitle,
            'semester' => $this->faker->numberBetween(1, 8),
            'instagram_handle' => '@'.$this->faker->userName,
            'ktp_photo' => $this->faker->imageUrl(640, 480, 'people', true, 'KTP'),
            'selfie_photo' => $this->faker->imageUrl(640, 480, 'selfie', true, 'Selfie-KTP'),
        ];
    }

    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
