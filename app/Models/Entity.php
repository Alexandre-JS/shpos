<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Entity extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'description',
        'logo_path',
        'location_city',
        'location_district',
        'phone',
        'whatsapp',
        'email',
        'facebook_url',
        'instagram_url',
        'website_url',
        'is_active',
        'is_featured',
        'plan_type',
        'status',
    ];

    const STATUS_PENDING  = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';

    protected $casts = [
        'is_active'  => 'boolean',
        'is_featured' => 'boolean',
        'last_item_at' => 'datetime',
    ];

    public function isPending(): bool  { return $this->status === self::STATUS_PENDING; }
    public function isApproved(): bool { return $this->status === self::STATUS_APPROVED; }
    public function isRejected(): bool { return $this->status === self::STATUS_REJECTED; }

    // Normaliza número de WhatsApp ao definir (remove não dígitos, garante prefixo 258 se faltar e tamanho padrão)
    public function setWhatsappAttribute($value): void
    {
        if ($value === null) {
            $this->attributes['whatsapp'] = null;
            return;
        }
        $digits = preg_replace('/\D+/', '', $value);
        if ($digits === '') {
            $this->attributes['whatsapp'] = null;
            return;
        }
        // Se já começa com 258 e tem 12 dígitos totais (258 + 9) mantemos
        if (str_starts_with($digits, '258') && strlen($digits) === 12) {
            $this->attributes['whatsapp'] = $digits;
            return;
        }
        // Se tem exatamente 9 dígitos e não começa com 258, prefixar
        if (strlen($digits) === 9) {
            $this->attributes['whatsapp'] = '258' . $digits;
            return;
        }
        // Outros formatos: guardar bruto (deixa validação rejeitar via form request)
        $this->attributes['whatsapp'] = $digits;
    }

    public function getWhatsappInternationalAttribute(): ?string
    {
        return $this->whatsapp ?: null; // já armazenado internacional
    }

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->where('status', self::STATUS_APPROVED);
    }

    public function scopeApproved($query)
    {
        return $query->where('status', self::STATUS_APPROVED);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
}
