<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id',
        'avatar',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Helper methods cho role
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isStudent(): bool
    {
        return $this->role === 'student';
    }

    // Helper method để kiểm tra sinh viên đã có đợt thi chưa
    public function hasExam(): bool
    {
        if (!$this->isStudent()) {
            return false;
        }
        
        return \App\Models\ExamStudent::where('student_id', $this->id)->exists();
    }

    // Relationship với ExamStudent
    public function examStudents()
    {
        return $this->hasMany(\App\Models\ExamStudent::class, 'student_id');
    }

    // Lấy đợt thi của sinh viên (nếu có)
    public function getExam()
    {
        if (!$this->isStudent()) {
            return null;
        }
        
        $examStudent = $this->examStudents()->first();
        return $examStudent ? $examStudent->exam : null;
    }
}
