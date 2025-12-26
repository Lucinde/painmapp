<?php

namespace Database\Factories;

use App\Models\DayLog;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class DayLogFactory extends Factory
{
    protected $model = DayLog::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'date' => $this->faker->date(),
            'notes' => $this->faker->optional()->paragraph(),
        ];
    }

    // Scope for logs for a specific user
    public function forUser(User $user): static
    {
        return $this->state(fn () => [
            'user_id' => $user->id,
        ]);
    }
}
