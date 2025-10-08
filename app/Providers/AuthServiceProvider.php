<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Entity;
use App\Models\Product;
use App\Policies\EntityPolicy;
use App\Policies\ProductPolicy;

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
            return $entity->user_id === $user->id;
        });

        Gate::define('manage-product', function ($user, Product $product) {
            return $product->entity && $product->entity->user_id === $user->id;
        });
    }
}
