<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = [
        'name',
        'semester',
        'year',
        'studies_type',
        'teacher_id',
        'teaching_assistant_id',
        'ects_credits',
        'prerequisite_subject_id',
        'description_file_path',
        'grading_guide_file_path',
        'curriculum_overview_file_path'
    ];

    protected $casts = [
        'has_prerequisites' => 'boolean',
        'prerequisites' => 'array'
    ];

    public function students()
    {
        return $this->belongsToMany(User::class);
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
    public function assistant()
    {
        return $this->beloo(User::class, 'teaching_assistant_id');
    }
    public function prerequisite()
    {
        return $this->hasOne(Subject::class, 'prerequisite_subject_id');
    }
}
