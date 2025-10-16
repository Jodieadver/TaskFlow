<?php

namespace App\Http\Controllers;


use App\Models\Task;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;


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
     * 可能错误
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
        'title'       => 'required|string|max:255',
        'description' => 'nullable|string',
        'user_id'     => 'nullable|exists:users,id',
        'status'      => 'required|in:to_do,in_progress,completed',
        'due_date'    => 'nullable|date_format:Y-m-d',
    ]);

    if (!empty($validated['due_date'])) {
        $validated['due_date'] = Carbon::createFromFormat('Y-m-d', $validated['due_date'])->toDateString();
    }

    $validated['completed_at'] = $validated['status'] === 'completed'
    ? now()->toDateString()
    : null;

    $data = array_merge($validated, [
        'project_id' => $project->id,
    ]);

    $task = $project->tasks()->create($data);


    // $task = $project->tasks()->create($validated);


    return redirect()->route('projects.tasks.index', $project)->with('success', 'Task created.');
}



/**
     * Send user list to the task creation form.
 */

    public function editMember(Project $project)
    {
        
        $userId = Project::whereKey($project->id)->value('user_id');
        $users = User::whereKey($userId)->get();
          
        // $users = $project->users()
        // ->get(['users_id']);
        return Inertia::render('MemberList', [
           'project' => $project,
            'users' => $users,
        ]);

    }

 











}