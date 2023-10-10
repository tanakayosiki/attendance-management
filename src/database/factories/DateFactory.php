<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Date;

class DateFactory extends Factory
{
    protected $model=Date::class;
    /**
     * Define the model's default state.
     *
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'=>$this->faker->name,
            'email'=>$this->faker->safeEmail,
            'password'=>$this->faker->password,
        ];
    }
}
