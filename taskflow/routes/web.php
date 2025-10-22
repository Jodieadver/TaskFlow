<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\NavbarController;
use App\Http\Controllers\ProjectInvitationController;

Route::get('/', function () {
    
    return Inertia::render('Welcome');
})->name('home');


// Route::get('dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->get('/dashboard', [ProjectController::class, 'index'
])->name('dashboard');   

// log out and back to main page
Route::middleware('auth')->post('/dashboard/logout', [NavbarController::class, 'userLogout'],
)
        ->name('userLogout');




/*
==============================
    Project Routes
==============================
*/
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

/*
==============================
    Task Routes
==============================
*/
Route::get('/dashboard/{project}/tasks/create', [TaskController::class, 'sendUserList'])
    ->name('task');   

Route::post('/dashboard/{project}/tasks/create', [TaskController::class, 'store'
])->name('task.store');



/*
==============================
    Member Routes
==============================
*/
Route::get('/dashboard/{project}/memberInProject', [TaskController::class, 'editMember'])
    ->name('member.edit');   

/*
==============================
    Invite Member Routes
==============================
*/
Route::middleware(['auth'])->group(function () {
    Route::post('/dashboard/{project}/memberInProject', [ProjectInvitationController::class, 'store'])
        ->name('projects.invitations.store');

    Route::delete('/dashboard/{project}/memberInProject', [ProjectInvitationController::class, 'destroy'])
        ->name('projects.invitations.destroy');
});

Route::get('/invites/accept/{token}', [ProjectInvitationController::class, 'accept'])
    ->name('invites.accept');








require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
