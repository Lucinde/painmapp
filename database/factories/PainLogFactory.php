<?php

namespace Database\Factories;

use App\Enums\PainLocation;
use App\Models\DayLog;
use App\Models\PainLog;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class PainLogFactory extends Factory
{
    protected $model = PainLog::class;

    public function definition(): array
    {
        $startTime = Carbon::createFromTime(
            $this->faker->numberBetween(0, 22),
            [0, 15, 30, 45][array_rand([0, 15, 30, 45])]
        );

        $endTime = (clone $startTime)->addMinutes(
            $this->faker->numberBetween(5, 180)
        );

        return [
            'day_log_id' => DayLog::factory(),
            'start_time' => $startTime->format('H:i:s'),
            'end_time'   => $endTime->format('H:i:s'),
            'location' => collect(PainLocation::cases())
                ->random($this->faker->numberBetween(1, 3))
                ->map(fn (PainLocation $location) => $location->value)
                ->values()
                ->toArray(),
            'intensity' => $this->faker->numberBetween(1, 10),
            'notes'     => $this->faker->optional()->sentence(),
        ];
    }
}
