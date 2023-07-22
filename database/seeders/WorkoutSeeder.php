<?php

namespace Database\Seeders;

use App\Models\Workout;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class WorkoutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Workout::factory()
            ->count(4)
            ->sequence(fn (Sequence $sequence) => ['scheduled_at' => now()->addDays($sequence->index)])
            ->create();
        Workout::factory()->create([
            'scheduled_at' => now()->subDay(),
        ]);
    }
}
