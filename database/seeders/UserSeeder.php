<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $trainer = User::factory()->create([
            'name' => 'The Trainer',
            'email' => 'trainer@fitco.com',
        ])->assignRole(Role::Trainer);
        User::factory()->create([
            'name' => 'A Member',
            'email' => 'member@fitco.com',
            'stripe_id' => 'cus_NK5xQdImOowgA5',
            'trainer_id' => $trainer->id,
        ])->assignRole(Role::Member);
    }
}
