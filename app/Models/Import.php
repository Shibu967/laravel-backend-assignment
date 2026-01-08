<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Import extends Model
{
    protected $fillable = [
        'type',
        'total_rows',
        'processed_rows',
        'status',
        'duration_seconds',
        'started_at',
        'ended_at'
    ];
}
