<?php

namespace App\Services;

use Illuminate\Support\Str;

class SlugGeneratorService
{
    /**
     * Gera um slug único para um determinado modelo.
     * @param  string  $source
     * @param  string  $modelClass  (ex: Entity::class, Product::class)
     * @param  array   $extraWhere  (ex: ['entity_id' => 5] para unicidade por entidade)
     */
    public function generate(string $source, string $modelClass, array $extraWhere = []): string
    {
        $base = Str::slug($source);
        $slug = $base;
        $counter = 2;

        $query = $modelClass::query()->where($extraWhere)->where('slug', $slug);
        while ($query->exists()) {
            $slugCandidate = $base . '-' . $counter++;
            $query = $modelClass::query()->where($extraWhere)->where('slug', $slugCandidate);
            if (! $query->exists()) {
                $slug = $slugCandidate;
                break;
            }
        }

        return $slug;
    }
}
