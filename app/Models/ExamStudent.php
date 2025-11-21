<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExamStudent extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_id',
        'student_id',
        'registered_at',
        'started_at',
        'submitted_at',
        'status',
    ];

    protected $casts = [
        'registered_at' => 'datetime',
        'started_at' => 'datetime',
        'submitted_at' => 'datetime',
    ];

    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    // Accessors
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'registered' => 'secondary',
            'in_progress' => 'warning',
            'submitted' => 'success',
            'absent' => 'danger'
        ];

        return $badges[$this->status] ?? 'secondary';
    }

    public function getStatusTextAttribute()
    {
        $texts = [
            'registered' => 'Đã đăng ký',
            'in_progress' => 'Đang làm bài',
            'submitted' => 'Đã nộp bài',
            'absent' => 'Vắng mặt'
        ];

        return $texts[$this->status] ?? 'Không xác định';
    }
}
