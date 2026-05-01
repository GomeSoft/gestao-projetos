<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;

class ProjectPolicy
{
    /**
     * Determina se o utilizador pode ver o projeto.
     * Proteção direta contra IDOR.
     */
    public function view(User $user, Project $project): bool
    {
        // Só o dono do projeto ou um admin pode ver
        return $user->id === $project->user_id;
    }

    public function update(User $user, Project $project): bool
    {
        return $user->id === $project->user_id;
    }
}