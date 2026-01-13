<?php

namespace Database\Factories;

use App\Enums\ActivityCategory;
use App\Models\ActivityLog;
use App\Models\DayLog;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class ActivityLogFactory extends Factory
{
    protected $model = ActivityLog::class;

    public function definition(): array
    {
        // start between 06:00 en 20:00
        $startTime = Carbon::createFromTime(
            $this->faker->numberBetween(6, 20),
            $this->faker->randomElement([0, 15, 30, 45])
        );

        // duur between 15 en 120 minutes
        $duration = $this->faker->numberBetween(15, 120);
        $endTime = (clone $startTime)->addMinutes($duration);

        return [
            'day_log_id' => DayLog::factory(),
            'activity_category' => $this->faker->randomElement(ActivityCategory::cases()),
            'start_time' => $startTime->format('H:i'),
            'end_time' => $endTime->format('H:i'),
            'duration_minutes' => Carbon::parse($startTime)->diffInMinutes(Carbon::parse($endTime)),
            'intensity' => $this->faker->numberBetween(1, 10),
            'perceived_load' => $this->faker->numberBetween(1, 10),
            'notes' => $this->faker->optional()->sentence(),
        ];
    }
}
