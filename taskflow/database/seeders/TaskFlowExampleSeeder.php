<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Support\Facades\Hash;

class TaskFlowExampleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $admin = User::firstOrCreate(
            ['email' => 'alice@example.com'],
            ['name' => 'Alice', 'password' => Hash::make('password')]
        );

        $member = User::firstOrCreate(
            ['email' => 'bob@example.com'],
            ['name' => 'Bob', 'password' => Hash::make('password')]
        );

       
        $project = Project::firstOrCreate(
            ['title' => 'TaskFlow MVP'],
            ['description' => 'Build the first version of TaskFlow app']
        );

      
        $project->users()->syncWithoutDetaching([
            $admin->id => ['role' => 'admin'],
            $member->id => ['role' => 'member'],
        ]);

        
        $tasks = [
            [
                'title' => 'Set up Laravel backend',
                'description' => 'Initialize Laravel with Breeze and migrations',
                'status' => 'to_do',
                'user_id' => $admin->id,
            ],
            [
                'title' => 'Implement Vue frontend',
                'description' => 'Build dashboard with Inertia and Tailwind',
                'status' => 'in_progress',
                'user_id' => $member->id,
            ],
            [
                'title' => 'Deploy to production',
                'description' => 'Set up hosting and CI/CD pipeline',
                'status' => 'to_do',
                'user_id' => $admin->id,
            ],
        ];

        foreach ($tasks as $taskData) {
            $project->tasks()->create($taskData);
        }

        $this->command->info('✅ TaskFlow Example Data Seeded Successfully!');
    }
}
