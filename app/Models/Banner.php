<?php

namespace App\Models;

use App\Enums\Status;
use App\Traits\ClearsCacheOnChange;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class Banner extends Model implements HasMedia
{
    use ClearsCacheOnChange, HasFactory, HasTranslations, InteractsWithMedia;

    protected $table = 'banners';

    public $translatable = ['name', 'description'];

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected function getCacheKeys(): string|array
    {
        return 'banners';
    }

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

    public function scopeIsSingle($query, $value = true)
    {
        return $query->where('is_single', $value);
    }

    protected function casts(): array
    {
        return [
            'status' => Status::class,
            'is_single' => 'boolean',
        ];
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('image')
            ->useDisk('public')
            ->singleFile();
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
