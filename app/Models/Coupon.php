<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Coupon extends Model
{
    protected $table = 'coupons';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'status' => Status::class,
        'expiry_date' => 'date',
        'value' => 'decimal:2',
        'min_order_value' => 'decimal:2',
        'max_discount' => 'decimal:2',
    ];

    public function carts(): HasMany
    {
        return $this->hasMany(Cart::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopeCheckInstructor($query)
    {
        if (auth()->check() && auth()->user()->hasRole('instructor')) {
            return $query->where('created_by', auth()->id());
        }

        return $query;
    }

    /**
     * Check if coupon is active
     */
    public function isActive(): bool
    {
        return $this->status->value === 'active';
    }

    /**
     * Check if coupon is expired
     */
    public function isExpired(): bool
    {
        return $this->expiry_date->isPast();
    }

    /**
     * Check if coupon has reached usage limit
     */
    public function hasReachedLimit(): bool
    {
        if ($this->usage_limit === null) {
            return false;
        }

        return $this->usage_count >= $this->usage_limit;
    }

    /**
     * Check if coupon is valid
     */
    public function isValid(): bool
    {
        return $this->isActive() && ! $this->isExpired() && ! $this->hasReachedLimit();
    }

    /**
     * Increment usage count
     */
    public function incrementUsage(): void
    {
        $this->increment('usage_count');
    }

    /**
     * Decrement usage count
     */
    public function decrementUsage(): void
    {
        if ($this->usage_count > 0) {
            $this->decrement('usage_count');
        }
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }
}
