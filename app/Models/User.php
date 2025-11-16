<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'last_name',
        'role',
        'picture',
        'password',
        'grade_book'
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
    public function announcements()
    {
        return $this->hasMany(Announcement::class);
    }
    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function enrollments()
    {
        return $this->hasMany(EnrollmentRecord::class);
    }
    public function testResults()
    {
        return $this->hasMany(TestResult::class);
    }
    public function grades()
    {
        return $this->hasMany(Grade::class);
    }
}
