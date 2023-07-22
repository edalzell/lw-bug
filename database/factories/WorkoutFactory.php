<?php

namespace Database\Factories;

use App\Enums\WorkoutType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Ramsey\Uuid\Uuid;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Workout>
 */
class WorkoutFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'description' => $this->faker->paragraph(1),
            'notes' => $this->faker->paragraph(1),
            'scheduled_at' => now(),
            'stations' => $this->faker->randomElements($this->makeStations(10), $this->faker->numberBetween(2, 4)),
            'time_cap' => $this->faker->numberBetween(5, 20),
            'title' => $this->faker->sentence(5),
            'trainer_id' => User::inRandomOrder()->first()->id,
            'type' => $this->faker->randomElement(WorkoutType::cases()),
        ];
    }

    private function makeStations(int $count): array
    {
        $stations = [];

        for ($i = 0; $i < $count; $i++) {
            $stations[] = $this->makeStation();
        }

        return $stations;
    }

    private function makeStation(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'exercises' => $this->faker->randomElements($this->makeExercises(6), $this->faker->numberBetween(1, 3)),
            'sets' => $this->faker->numberBetween(1, 4),
        ];
    }

    private function makeExercises(int $count): array
    {
        $exercises = [];

        for ($i = 0; $i < $count; $i++) {
            $exercises[] = $this->makeExercise();
        }

        return $exercises;
    }

    private function makeExercise(): array
    {
        return [
            'id' => Uuid::uuid4()->toString(),
            'activity' => $this->faker->numberBetween(5, 10).'x '.$this->faker->sentence(4, true),
        ];
    }
}
