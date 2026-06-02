<?php

namespace App\Models;

use App\Enums\EnrollmentStatus;
use App\Enums\PaymentStatus;
use App\Observers\UserObserver;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Traits\HasRoles;

#[ObservedBy(UserObserver::class)]
class User extends Authenticatable implements HasMedia, MustVerifyEmail
{
    use HasApiTokens, HasFactory, HasRoles, \Illuminate\Auth\MustVerifyEmail, InteractsWithMedia, Notifiable;

    protected $table = 'users';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'immutable_datetime',
            'password' => 'hashed',
            'created_at' => 'immutable_datetime',
            'updated_at' => 'immutable_datetime',
        ];
    }

    public function getFullPhoneAttribute(): string
    {
        return $this->phone_key.$this->phone;
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->map(fn (string $name) => Str::of($name)->substr(0, 1))
            ->implode('');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('image')
            ->useDisk('public')
            ->singleFile();
    }

    public function wallet(): HasOne
    {
        return $this->hasOne(Wallet::class, 'instructor_id');
    }

    public function assignmentAnswers(): HasMany
    {
        return $this->hasMany(AssignmentAnswer::class);
    }

    public function courseReviews(): HasMany
    {
        return $this->hasMany(CourseReview::class);
    }

    public function enrolledCourses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'enrollments', 'user_id', 'course_id')
            ->whereNull('enrollments.deleted_at')
            ->withPivot('id', 'status', 'progress', 'created_at')
            ->withTimestamps();
    }

    // active enrolledCourses
    public function activeEnrolledCourses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'enrollments', 'user_id', 'course_id')
            ->approval()
            ->visibility()
            ->where('enrollments.status', EnrollmentStatus::Confirmed)
            ->where('enrollments.payment_status', PaymentStatus::Paid)
            ->whereNull('enrollments.deleted_at')
            ->withPivot('id', 'status', 'created_at')
            ->withTimestamps();
    }

    public function instructorCourses(): HasMany
    {
        return $this->hasMany(Course::class, 'instructor_id');
    }

    public function instructorCourseEnrollments(): HasManyThrough
    {
        return $this->hasManyThrough(Enrollment::class, Course::class, 'instructor_id', 'course_id', 'id', 'id');
    }

    public function favorites(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'favorites', 'user_id', 'course_id')
            ->withTimestamps();
    }

    public function lectureCompletions(): BelongsToMany
    {
        return $this->belongsToMany(Lecture::class, 'lecture_completions')
            ->withTimestamps();
    }

    public function studentInstructor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_instructor_code', 'instructor_code');
    }

    // ========================
    // Assistant Relationships
    // ========================

    public function assistants(): HasMany
    {
        return $this->hasMany(User::class, 'instructor_id');
    }

    public function instructorOwner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    // ========================
    // Helpers
    // ========================

    public function isAssistant(): bool
    {
        return $this->hasRole('assistant') && $this->instructor_id !== null;
    }

    public function getEffectiveInstructorId(): ?int
    {
        return $this->isAssistant() ? $this->instructor_id : $this->id;
    }
}
