<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\User;
use App\Models\Project;
use App\Models\Task;

class TaskFlowexampleSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // ---------- Create Users ----------
        $users = [];
        for ($i = 0; $i < 10; $i++) {
            $users[] = User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => bcrypt('password'),
            ]);
        }

        $users = collect($users);

        // ---------- Create Projects ----------
        for ($i = 0; $i < 10; $i++) {
            $project = Project::create([
                'title' => $faker->sentence(3),
                'description' => $faker->paragraph,
                'status' => $faker->randomElement(['pending', 'in_progress', 'completed']),
                'due_date' => $faker->dateTimeBetween('now', '+2 months'),
                'completed_at' => $faker->optional()->dateTimeBetween('-1 month', 'now'),
            ]);

            // Attach 1-3 random users with pivot data
            $projectUsers = $users->random(rand(1, 3));
            foreach ($projectUsers as $user) {
                $project->users()->attach($user->id, [
                    'role' => $faker->randomElement(['admin', 'member']),
                    'completed_at' => $faker->optional()->dateTimeBetween('-1 month', 'now'),
                ]);
            }

            // Create 2-5 tasks per project
            foreach (range(1, rand(2, 5)) as $j) {
                $task = Task::create([
                    'title' => $faker->sentence(4),
                    'description' => $faker->paragraph,
                    'status' => $faker->randomElement(['pending', 'in_progress', 'completed']),
                    'due_date' => $faker->dateTimeBetween('now', '+1 month'),
                    'completed_at' => $faker->optional()->dateTimeBetween('-1 month', 'now'),
                    'project_id' => $project->id,
                ]);

                // Attach 1-3 random users to task
                $taskUsers = $users->random(rand(1, 3));
                $task->users()->attach($taskUsers->pluck('id')->toArray());
            }

            // Create 0-3 project invitations
            foreach (range(1, rand(0, 3)) as $k) {
                $project->invitations()->create([
                    'inviter_id' => $project->users->random()->id,
                    'email' => $faker->unique()->safeEmail,
                    'token' => bin2hex(random_bytes(32)),
                    'expires_at' => $faker->dateTimeBetween('now', '+1 month'),
                    'accepted_at' => $faker->optional()->dateTimeBetween('now', '+1 month'),
                ]);
            }
        }
    }
}
