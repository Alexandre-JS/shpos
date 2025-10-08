<?php

namespace App\Services;

use App\Models\Product;
use App\Models\View;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ViewTrackingService
{
    /**
     * Registra uma view única (por IP a cada 24h) e incrementa contador.
     */
    public function track(Product $product, string $ip, ?string $userAgent, ?int $ownerUserId = null): void
    {
        // Ignorar se o dono está a ver o próprio produto
        if ($ownerUserId && $product->entity && $product->entity->user_id === $ownerUserId) {
            return;
        }

        // Ignorar user agents suspeitos (bots simples)
        if ($userAgent && $this->isBot($userAgent)) {
            return;
        }

        $since = Carbon::now()->subDay();
        $already = View::where('product_id', $product->id)
            ->where('ip_address', $ip)
            ->where('created_at', '>=', $since)
            ->exists();

        if ($already) {
            return; // já contou nas últimas 24h
        }

        View::create([
            'product_id' => $product->id,
            'ip_address' => $ip,
            'user_agent' => $userAgent ? Str::limit($userAgent, 500) : null,
            'created_at' => now(),
        ]);

        $product->increment('views_count');
    }

    protected function isBot(string $ua): bool
    {
        $bots = ['bot', 'crawl', 'spider', 'slurp', 'mediapartners'];
        $uaLower = strtolower($ua);
        foreach ($bots as $fragment) {
            if (str_contains($uaLower, $fragment)) {
                return true;
            }
        }
        return false;
    }
}
