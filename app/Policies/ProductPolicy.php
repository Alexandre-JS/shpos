<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Product;

class ProductPolicy
{
    public function view(User $user, Product $product): bool
    {
        return $this->owns($user, $product);
    }

    public function update(User $user, Product $product): bool
    {
        return $this->owns($user, $product);
    }

    public function delete(User $user, Product $product): bool
    {
        return $this->owns($user, $product);
    }

    protected function owns(User $user, Product $product): bool
    {
        return $product->entity && $product->entity->user_id === $user->id;
    }
}
