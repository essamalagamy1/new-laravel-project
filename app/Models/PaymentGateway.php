<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class PaymentGateway extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $table = 'payment_gateways';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected function casts(): array
    {
        return [
            'credentials' => 'array',
            'is_active' => 'boolean',
            'is_default' => 'boolean',
        ];
    }

    /**
     * Scope for active gateways.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for default gateway.
     */
    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }

    /**
     * Get credential value by key.
     */
    public function getCredential(string $key, $default = null)
    {
        return $this->credentials[$key] ?? $default;
    }

    /**
     * Get all active gateways ordered by sort_order.
     */
    public static function getActiveGateways()
    {
        return static::active()->orderBy('sort_order')->get();
    }

    /**
     * Get the default gateway.
     */
    public static function getDefaultGateway(): ?self
    {
        return static::active()->default()->first() ?? static::active()->first();
    }

    /**
     * Find gateway by slug.
     */
    public static function findBySlug(string $slug): ?self
    {
        return static::where('slug', $slug)->first();
    }

    /**
     * Check if gateway is Cash on Delivery.
     */
    public function isCod(): bool
    {
        return $this->slug === 'cod';
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('logo')
            ->useDisk('public')
            ->singleFile();
    }
}
