<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EnrollmentDatabase extends Model
{
    protected $fillable = [
        'test_id',
        'closes_at'
    ];
    public function test()
    {
        return $this->belongsTo(Test::class);
    }
}
