<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Entity;
use App\Models\Product;
use App\Policies\EntityPolicy;
use App\Policies\ProductPolicy;
use Illuminate\Support\Facades\Log;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Entity::class => EntityPolicy::class,
        Product::class => ProductPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('manage-entity', function ($user, Entity $entity) {
            $allowed = $entity->user_id === $user->id;
            Log::debug('Gate.manage-entity', [
                'user_id' => $user->id,
                'entity_id' => $entity->id,
                'allowed' => $allowed,
            ]);
            return $allowed;
        });

        Gate::define('manage-product', function ($user, Product $product) {
            $userEntityId = $user->entity?->id;
            $allowed = $userEntityId !== null && (int)$product->entity_id === (int)$userEntityId;
            Log::debug('Gate.manage-product', [
                'user_id' => $user->id,
                'product_id' => $product->id,
                'product_entity_id' => $product->entity_id,
                'user_entity_id' => $userEntityId,
                'allowed' => $allowed,
            ]);
            return $allowed;
        });
    }
}
