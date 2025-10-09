<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Entity;
use Illuminate\Support\Facades\Log;

class EntityPolicy
{
    public function view(User $user, Entity $entity): bool
    {
        $allowed = $this->owns($user, $entity);
        Log::debug('Policy.Entity.view', [
            'user_id' => $user->id,
            'entity_id' => $entity->id,
            'allowed' => $allowed,
        ]);
        return $allowed;
    }

    public function update(User $user, Entity $entity): bool
    {
        $allowed = $this->owns($user, $entity);
        Log::debug('Policy.Entity.update', [
            'user_id' => $user->id,
            'entity_id' => $entity->id,
            'allowed' => $allowed,
        ]);
        return $allowed;
    }

    protected function owns(User $user, Entity $entity): bool
    {
        return $entity->user_id === $user->id;
    }
}
