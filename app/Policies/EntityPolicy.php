<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Entity;

class EntityPolicy
{
    public function view(User $user, Entity $entity): bool
    {
        return $this->owns($user, $entity);
    }

    public function update(User $user, Entity $entity): bool
    {
        return $this->owns($user, $entity);
    }

    protected function owns(User $user, Entity $entity): bool
    {
        return $entity->user_id === $user->id;
    }
}
