<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $fillable = [
        'subject_id',
        'position',
        'title',
        'description',
        'is_visible'
    ];
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
