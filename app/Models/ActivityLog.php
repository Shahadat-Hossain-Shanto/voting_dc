<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    protected $table = 'activity_log';
    protected $fillable = [
        'user_id',
        'user_name',
        'activity',
        'imei_1',
        'imei_2',
        'created_at',
        'updated_at'
    ];
}
