<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    //
    public function index()
    {
        $userId = Auth::id();

        $projects = Project::where('user_id', $userId)->with('users', 'tasks')->get();

        // $projects = Project::with('users', 'tasks')->get();
        return Inertia::render('Dashboard', [
            'projects' => $projects
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $validated = $request->validate([
        'title'       => 'required|string|max:255',
        'description' => 'nullable|string',
        'due_date'    => 'nullable|date_format:Y-m-d',          
        'picture'     => 'nullable|image|max:2048',
    ]);

    if ($request->hasFile('picture')) {
        $path = $request->file('picture')->store('projects', 'public');
        $validated['picture'] = $path;
    }

    if (!empty($validated['due_date'])) {
        $validated['due_date'] = Carbon::createFromFormat('Y-m-d', $validated['due_date'])->toDateString();
    }

    $data = array_merge($validated, [
        // 'user_id' => $request->user()->id ?? null,   
        'status'  => 'active',
        'user_id'   => Auth::id(),
        'slug'    => Str::slug($validated['title']),
    ]);

    $project = Project::create($data);


    return redirect()->route('dashboard')->with('success', 'Project created successfully.');
}


// Edit a project details, show the edit form

 public function edit(Request $request, Project $project)
    {
        
        $userId = Auth::id();

        $project = Project::with('users', 'tasks')
            ->where('user_id', $userId)
            ->where('id', $project->id)  
            ->get();

        return Inertia::render('EditProjectForm', [
            'project' => $project
        ]);

    }


// Uopdate a project details

    public function update(Request $request, Project $project)
    {
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'due_date'    => 'nullable|date_format:Y-m-d',
            'picture' => 'nullable|image|max:2048',
        ]);

        if (!empty($validated['due_date'])) {
        $validated['due_date'] = Carbon::createFromFormat('Y-m-d', $validated['due_date'])->toDateString();

    }
        // $project -> update($validated);
        $project->update($validated);

        return redirect()->route('projects.tasks.index', ['project' => $project->id])->with('success', 'Project updated successfully!');
    }



    public function destroy(Project $project)
{
    $project->delete(); 
    return redirect()->route('dashboard')->with('success', 'Project deleted successfully!');
}












}
