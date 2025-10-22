<?php

// app/Http/Controllers/ProjectInvitationController.php
namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectInvitation;
use App\Models\User;
use App\Notifications\ProjectInvitationNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Notification;

class ProjectInvitationController extends Controller
{
    // 发送邀请
    public function store(Request $request, Project $project)
    {
        // $this->authorize('invite', $project); // 可选：写一个 Policy 控制权限

        $data = $request->validate([
            'email' => 'required|email:rfc,dns',
        ]);

        // 如果该邮箱已在团队中，直接返回
        $exists = $project->users()->where('email', $data['email'])->exists();
        if ($exists) {
            return back()->with('info', 'This user is already a member.');
        }

        // 避免重复未接受的邀请
        $pending = ProjectInvitation::where('project_id', $project->id)
            ->where('email', $data['email'])
            ->whereNull('accepted_at')
            ->first();
        if ($pending) {
            // 也可以在这里触发“重发邮件”
            Notification::route('mail', $pending->email)
    ->notify(new ProjectInvitationNotification($pending));
            return back()->with('info', 'Invitation resent.');
        }

        $invitation = ProjectInvitation::create([
            'project_id' => $project->id,
            'inviter_id' => $request->user()->id,
            'email'      => $data['email'],
            'token'      => Str::uuid()->toString(),
            'expires_at' => now()->addDays(7),
        ]);

        Notification::route('mail', $invitation->email)
    ->notify(new ProjectInvitationNotification($invitation));

        return redirect()->route('projects.tasks.index', ['project' => $project->id])->with('success', 'Invitation sent.');
    }

    // 接受邀请
    public function accept(string $token)
    {
        $invitation = ProjectInvitation::with('project')->where('token', $token)->firstOrFail();

        if ($invitation->accepted_at) {
            return redirect()->route('member.edit', $invitation->project)
                ->with('info', 'Invitation already accepted.');
        }

        if ($invitation->isExpired()) {
            return redirect()->route('login')->with('error', 'Invitation expired.');
        }

        // 必须登录后才能接受（未登录先去登录）
        if (!auth()->check()) {
            // 也可把 token 存 session，登录后再回调
            return redirect()->route('login')->with('info', 'Please sign in to accept the invitation.');
        }

        $user = auth()->user();

        // 如果你的业务允许非同邮箱接受邀请，可直接加入；
        // 如果必须匹配邮箱，可校验：if ($user->email !== $invitation->email) { ... }
        $invitation->project->users()->syncWithoutDetaching([$user->id]);

        $invitation->accepted_at = now();
        $invitation->save();

        return redirect()->route('projects.tasks.index', $invitation->project)
            ->with('success', 'You have joined the project.');
    }

    // 撤销邀请（可选）
    public function destroy(Project $project, ProjectInvitation $invitation)
    {
        $this->authorize('invite', $project);
        abort_if($invitation->project_id !== $project->id, 404);

        $invitation->delete();
        return back()->with('success', 'Invitation revoked.');
    }
}
