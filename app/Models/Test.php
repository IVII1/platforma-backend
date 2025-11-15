<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $fillable = [
        'subject_id',
        'test_type',
        'max_points'
    ];
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
    public function results()
    {
        return $this->hasMany(TestResult::class);
    }
}
