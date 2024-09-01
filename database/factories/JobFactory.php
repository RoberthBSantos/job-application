<?php

namespace Database\Factories;

use App\Models\Job;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Job>
 */
class JobFactory extends Factory
{
    protected $model = Job::class;

    public function definition()
    {
        return [
            'title' => $this->faker->jobTitle(),
            'type' => $this->faker->randomElement(['CLT', 'PJ', 'Freelancer']),
            'paused' =>$this->faker->boolean(false)
        ];
    }
}
