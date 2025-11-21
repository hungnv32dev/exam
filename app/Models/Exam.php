<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'duration_minutes',
        'start_time',
        'end_time',
        'description',
        'status',
        'created_by',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'duration_minutes' => 'integer',
    ];

    // Relationship with User (creator)
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Relationship with Questions (with order)
    public function questions(): BelongsToMany
    {
        return $this->belongsToMany(Question::class, 'exam_questions')
            ->withPivot('order_number')
            ->orderByPivot('order_number');
    }

    // Relationship with Students
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'exam_students', 'exam_id', 'student_id')
            ->where('users.role', 'student')
            ->withPivot(['registered_at', 'started_at', 'submitted_at', 'status'])
            ->withTimestamps();
    }

    // Exam Students pivot records
    public function examStudents(): HasMany
    {
        return $this->hasMany(ExamStudent::class);
    }

    // Exam Questions pivot records
    public function examQuestions(): HasMany
    {
        return $this->hasMany(ExamQuestion::class)->orderBy('order_number');
    }

    // Relationship with Exam Answers
    public function examAnswers(): HasMany
    {
        return $this->hasMany(ExamAnswer::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('start_time', '>', now());
    }

    public function scopeOngoing($query)
    {
        return $query->where('start_time', '<=', now())
            ->where('end_time', '>=', now());
    }

    public function scopeCompleted($query)
    {
        return $query->where('end_time', '<', now());
    }

    // Accessors
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'draft' => 'secondary',
            'active' => 'primary',
            'completed' => 'success',
            'cancelled' => 'danger'
        ];

        return $badges[$this->status] ?? 'secondary';
    }

    public function getStatusTextAttribute()
    {
        $texts = [
            'draft' => 'Bản nháp',
            'active' => 'Đang hoạt động',
            'completed' => 'Đã hoàn thành',
            'cancelled' => 'Đã hủy'
        ];

        return $texts[$this->status] ?? 'Không xác định';
    }

    public function getDurationFormattedAttribute()
    {
        $hours = floor($this->duration_minutes / 60);
        $minutes = $this->duration_minutes % 60;

        if ($hours > 0) {
            return $hours . 'h' . ($minutes > 0 ? ' ' . $minutes . 'm' : '');
        }

        return $minutes . ' phút';
    }

    // Helper methods
    public function isActive()
    {
        return $this->status === 'active';
    }

    public function isUpcoming()
    {
        return $this->start_time > now();
    }

    public function isOngoing()
    {
        return $this->start_time <= now() && $this->end_time >= now();
    }

    public function isCompleted()
    {
        return $this->end_time < now() || $this->status === 'completed';
    }

    public function canBeEdited()
    {
        return in_array($this->status, ['draft']) && $this->isUpcoming();
    }

    public function canBeDeleted()
    {
        return $this->status === 'draft' || ($this->isUpcoming() && $this->examStudents()->count() === 0);
    }

    public function getTotalStudentsAttribute()
    {
        return $this->examStudents()->count();
    }

    public function getTotalQuestionsAttribute()
    {
        return $this->examQuestions()->count();
    }

    // Generate unique exam code
    public static function generateUniqueCode()
    {
        do {
            $code = 'EX' . date('Ymd') . rand(1000, 9999);
        } while (self::where('code', $code)->exists());

        return $code;
    }
}
