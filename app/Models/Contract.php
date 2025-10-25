<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $fillable = [
        'title',
        'description',
        'rules',
        'is_active'
    ];

    protected $casts = [
        'rules' => 'array',
        'is_active' => 'boolean'
    ];
}
