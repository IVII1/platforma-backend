<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EnrollmentRecord extends Model
{
    protected $fillable = [
        'enrollment_database_id',
        'student_id',
        'grade_book',
        'status'
    ];
    public function student()
    {
        return $this->belongsTo(User::class);
    }
    public function enrollmentDb()
    {
        return $this->belongsTo(EnrollmentDatabase::class);
    }
}
