<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'tasks';

    protected $fillable = [
        'title',
        'description',
        'status',
        'project_id',
        'due_date',
        'completed_at',
    ];

    public function projects()
    {
        return $this->belongsTo(Project::class);
    }


    public function users()
        {
            return $this->belongsToMany(User::class)
                ->withTimestamps();
        }
}
