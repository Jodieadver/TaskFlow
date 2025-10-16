<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');


// Route::get('dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->get('/dashboard', [ProjectController::class, 'index'
])->name('dashboard');    

// Route to a project creation form
Route::middleware('auth')->get('/dashboard/create', function () {
    return Inertia::render('ProjectForm');
})->name('projects');    

// save a new project and back to user's dashboard with all projects
Route::middleware('auth')->post('/dashboard/create', [ProjectController::class, 'store'
])->name('projects.store');

// show the edit form
Route::middleware('auth')->get('/dashboard/{project}/edit', [ProjectController::class, 'edit'
])->name('projects.edit');

// edit a project details
Route::middleware('auth')->put('/dashboard/{project}/edit', [ProjectController::class, 'update'
])->name('projects.update');

// delete a project details
Route::middleware('auth')->delete('/dashboard/{project}/edit', [ProjectController::class, 'destroy'
])->name('projects.destroy');

// view projects by tasks, project details and associated tasks
Route::middleware('auth')->get('/dashboard/{project}', [TaskController::class, 'indexByProject'])
    ->name('projects.tasks.index')
    ->whereNumber('project');


Route::get('/dashboard/{project}/tasks/create', [TaskController::class, 'sendUserList'])
    ->name('task');   

Route::post('/dashboard/{project}/tasks/create', [TaskController::class, 'store'
])->name('task.store');



require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
