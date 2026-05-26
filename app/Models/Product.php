<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'entity_id',
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'image_path',
        'type',
        'is_active',
        'views_count',
        'discount_type',
        'discount_value',
        'discount_starts_at',
        'discount_ends_at',
        'has_delivery',
    ];

    protected $casts = [
        'is_active'    => 'boolean',
        'has_delivery' => 'boolean',
        'price' => 'decimal:2',
        'discount_value' => 'decimal:2',
        'discount_starts_at' => 'datetime',
        'discount_ends_at' => 'datetime',
    ];

    public function entity(): BelongsTo
    {
        return $this->belongsTo(Entity::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function views(): HasMany
    {
        return $this->hasMany(View::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('position');
    }

    public function primaryImage(): ?ProductImage
    {
        return $this->images->firstWhere('is_primary', true) ?? $this->images->first();
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeProducts($query)
    {
        return $query->where('type', 'product');
    }

    public function scopeServices($query)
    {
        return $query->where('type', 'service');
    }

    /**
     * Determine if the discount is currently active.
     */
    public function isDiscountActive(): bool
    {
        if (!$this->discount_type || $this->discount_value === null || $this->discount_value <= 0) {
            return false;
        }
        if ($this->price === null || $this->price <= 0) {
            return false;
        }
        $now = now();
        if ($this->discount_starts_at && $now->lt($this->discount_starts_at)) {
            return false;
        }
        if ($this->discount_ends_at && $now->gt($this->discount_ends_at)) {
            return false;
        }
        return true;
    }

    /**
     * Monetary amount discounted.
     */
    public function discountAmount(): float
    {
        if (!$this->isDiscountActive()) {
            return 0.0;
        }
        $price = (float) $this->price;
        $value = (float) $this->discount_value;
        if ($this->discount_type === 'percent') {
            $percent = min($value, 100);
            $amount = $price * ($percent / 100);
        } else { // amount
            $amount = min($value, $price);
        }
        return round($amount, 2);
    }

    /**
     * Final price after discount (or original price if none).
     */
    public function discountedPrice(): float
    {
        $price = (float) ($this->price ?? 0);
        $final = $price - $this->discountAmount();
        return round(max($final, 0), 2);
    }

    /**
     * Percent representation of discount (0-100).
     */
    public function discountPercent(): float
    {
        if (!$this->isDiscountActive()) {
            return 0.0;
        }
        $price = (float) $this->price;
        if ($price <= 0) {
            return 0.0;
        }
        if ($this->discount_type === 'percent') {
            return min((float) $this->discount_value, 100);
        }
        // amount type
        $percent = ($this->discountAmount() / $price) * 100;
        return round(min($percent, 100), 2);
    }

    /**
     * Accessor for final_price attribute.
     */
    public function getFinalPriceAttribute(): float
    {
        return $this->discountedPrice();
    }

    /**
     * Scope to filter products with an active discount.
     */
    public function scopeWithActiveDiscount($query)
    {
        $now = now();
        return $query->whereNotNull('discount_type')
            ->whereNotNull('discount_value')
            ->where('discount_value', '>', 0)
            ->where(function ($q) use ($now) {
                $q->whereNull('discount_starts_at')->orWhere('discount_starts_at', '<=', $now);
            })
            ->where(function ($q) use ($now) {
                $q->whereNull('discount_ends_at')->orWhere('discount_ends_at', '>=', $now);
            });
    }
}
