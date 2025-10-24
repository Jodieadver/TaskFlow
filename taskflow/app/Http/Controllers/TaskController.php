<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class TaskController extends Controller
{
    //
    public function indexByProject(Project $project)
    {
        $tasks = Task::with('projects', 'users')
            ->where('project_id', $project->id)
            ->get();

        return Inertia::render('ProjectDetails', [
            'tasks' => $tasks,
            'project' => $project->only(['id', 'title', 'description']),
            'users' => $project->users()->get(['id', 'name', 'email']),

        ]);
    }

    /**
     * Send user list to the task creation form.
     */
    public function sendUserList(Project $project)
    {
        $users = $project->users()->get(['id', 'name', 'email']);

        return Inertia::render('TaskForm', [
            'project' => $project->only(['id', 'title']),
            'users' => $users,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Project $project, Request $request)
    {

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'user_id' => 'nullable|exists:users,id',
            'status' => 'required|in:to_do,in_progress,completed',
            'due_date' => 'nullable|date_format:Y-m-d',
        ]);

        if (! empty($validated['due_date'])) {
            $validated['due_date'] = Carbon::createFromFormat('Y-m-d', $validated['due_date'])->toDateString();
        }

        $validated['completed_at'] = $validated['status'] === 'completed'
        ? now()->toDateString()
        : null;

        $data = array_merge($validated, [
            'project_id' => $project->id,
        ]);

        $task = $project->tasks()->create($data);
        $task->users()->attach($validated['user_id']);

        return redirect()->route('projects.tasks.index', $project)->with('success', 'Task created.');
    }

    public function edit(Project $project, Task $task)
    {

        $userId = Auth::id();

        if ($task->project_id !== $project->id) {
            abort(403, 'This task does not belong to this project.');
        }

        $isMember = $project->users()->where('users.id', $userId)->exists();
        if (! $isMember) {
            abort(403, 'You do not have permission to edit this task.');
        }

        $users = $project->users()->get(['id', 'name', 'email']);

        return Inertia::render('EditTaskForm', [
            'task' => $task,
            'users' => $users,
            'project' => $project,
        ]);
    }

    public function update(Project $project, Task $task, Request $request)
    {
        // dump($project);
        // dump($task);

        Log::debug($project);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'status' => 'nullable|in:to_do,in_progress,completed',
            'user_id' => 'nullable|exists:users,id',
            'due_date' => 'nullable|date_format:Y-m-d',
        ]);

        if ($validator->fails()) {
            // Get all errors
            $errors = $validator->errors();
            dd($errors->all()); // or Log::info($errors->all());
        }

        $validated = $validator->validated();
        $task->update($validated);

        if (! empty($validated['user_id'])) {
            $task->users()->sync([$validated['user_id']]);
        } else {
            $task->users()->detach();
        }

        return redirect()->route('projects.tasks.index', $project)->with('success', 'Project updated successfully!');
    }

    /**
     * Delete task.
     */
    public function destroy(Project $project, Task $task)
    {
        $projectId = $project->id;

        try {
            $task->delete();

            return redirect()
                ->route('projects.tasks.index', $projectId)
                ->with('success', 'Task deleted successfully!');
        } catch (\Exception $e) {
            return redirect()
                ->route('projects.tasks.index', $projectId)
                ->with('error', 'Failed to delete task: '.$e->getMessage());
        }

    }

    /**
     * Send user list to the task creation form.
     */
    public function editMember(Project $project)
    {
        $users = $project->users()->get(['id', 'name', 'email']);
        $project = Project::find($project->id);
        // $users = Project::find($project->id)->users()->get();
        // $users = User::find($userId)->users()->get();

        // $users = $project->users()
        // ->get(['users_id']);
        return Inertia::render('MemberList', [
            'users' => $users,
            'project' => $project,
        ]);

    }
}
