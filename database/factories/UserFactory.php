<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\App\Models\User>
     */
    protected $model = User::class;

    /**
     * The current password being used by the factory.
     *
     * @var string|null
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // fallback naar een handmatig aangemaakte Faker instantie als $this->faker null is
        $faker = $this->faker ?: \Faker\Factory::create();

        return [
            'name'             => $faker->name(),
            'email'            => $faker->unique()->safeEmail(),
            'email_verified_at'=> now(),
            'password'         => static::$password ??= Hash::make('password'),
            'remember_token'   => Str::random(10),
            'therapist_id'     => null,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Create an admin user (via Spatie/Shield)
     *
     * @return static
     */
    public function admin(): static
    {
        return $this->afterCreating(function (User $user) {
            $user->assignRole('admin');
        });
    }

    /**
     * Create a fysio user (via Spatie/Shield)
     *
     * @return static
     */
    public function fysio(): static
    {
        return $this->afterCreating(function (User $user) {
            $user->assignRole('fysio');
        });
    }

    /**
     * Create a client user assigned to a therapist
     *
     * @param \App\Models\User $therapist
     * @return static
     */
    public function clientWithTherapist(User $therapist): static
    {
        return $this->afterCreating(function (User $user) use ($therapist) {
            $user->assignRole('client');
            $user->therapist_id = $therapist->id;
            $user->save();
        });
    }
}
