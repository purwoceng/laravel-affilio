<?php

namespace Database\Factories;

use App\Models\Member;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

class MemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */

    protected $model = Member::class;

    public function definition()
    {
        return [
            'name' =>  $this->faker->name(1,2),
            'username' => $this->faker->userName,
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber,
            'hash' => Hash::make('password'),
            'is_verified' => $this->faker->boolean,
            'is_blocked' => $this->faker->boolean,
            'publish' => '1',
        ];
    }
}
