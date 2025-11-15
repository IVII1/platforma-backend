<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $fillable = [
        'module_id',
        'position',
        'attachemnt_type',
        'attachment_name',
        'attachment_path',
        'article_content',
    ];
    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}
