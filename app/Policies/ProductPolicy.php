<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

class ProductPolicy
{
    public function view(User $user, Product $product): bool
    {
        $allowed = $this->owns($user, $product);
        Log::debug('Policy.Product.view', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'allowed' => $allowed,
        ]);
        return $allowed;
    }

    public function update(User $user, Product $product): bool
    {
        $allowed = $this->owns($user, $product);
        Log::debug('Policy.Product.update', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'allowed' => $allowed,
        ]);
        return $allowed;
    }

    public function delete(User $user, Product $product): bool
    {
        $allowed = $this->owns($user, $product);
        Log::debug('Policy.Product.delete', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'allowed' => $allowed,
        ]);
        return $allowed;
    }

    protected function owns(User $user, Product $product): bool
    {
        return $product->entity && $product->entity->user_id === $user->id;
    }
}
