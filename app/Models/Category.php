<?php

namespace App\Models;

use App\Enums\Status;
use App\Traits\ClearsCacheOnChange;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class Category extends Model implements HasMedia
{
    use ClearsCacheOnChange, HasFactory, HasTranslations, InteractsWithMedia;

    protected $table = 'categories';

    public $translatable = ['name'];

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function scopeActive($query)
    {
        return $query->where('status', Status::Active);
    }

    public function scopeVisibility($query)
    {
        if (auth('sanctum')->check()) {
            $user = auth('sanctum')->user();
            if ($user->student_instructor_code) {
                return $query->whereIn('visibility', ['all', 'other_platforms_only']);
            }
        }

        return $query->whereIn('visibility', ['all', 'easyta3lim_only']);
    }

    public function scopeSubCategory($query)
    {
        return $query->whereNotNull('parent_id');
    }

    protected function casts(): array
    {
        return [
            'status' => Status::class,
        ];
    }

    protected function getCacheKeys(): string|array
    {
        return 'categories';
    }

    // Parent category relationship
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    // Subcategories relationship
    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('image')->useDisk('public')->singleFile();
    }

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }
}
