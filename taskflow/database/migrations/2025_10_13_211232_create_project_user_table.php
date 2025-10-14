<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('project_user', function (Blueprint $table) {
            $table->foreignId('project_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->enum('role', ['admin', 'member'])->default('member');
            $table->date('completed_at')->nullable();
            $table->timestamps();
            $table->primary(['project_id', 'user_id']);
        });
    }

        // App\Models\Project
    public function users()
    {
        return $this->belongsToMany(User::class)
            ->withPivot(['role', 'completed_at'])
            ->withTimestamps();
    }

    // App\Models\User
    public function projects()
    {
        return $this->belongsToMany(Project::class)
            ->withPivot(['role', 'completed_at'])
            ->withTimestamps();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_user');
    }
};
