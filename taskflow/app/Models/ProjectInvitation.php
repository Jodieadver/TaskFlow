<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectInvitation extends Model
{
    protected $fillable = [
        'project_id','inviter_id','email','token','expires_at','accepted_at'
    ];
    protected $casts = [
        'expires_at' => 'datetime',
        'accepted_at'=> 'datetime',
    ];

    public function project(): BelongsTo { return $this->belongsTo(Project::class); }
    public function inviter(): BelongsTo { return $this->belongsTo(User::class,'inviter_id'); }

    public function isExpired(): bool
    {
        return $this->expires_at && now()->greaterThan($this->expires_at);
    }
}
