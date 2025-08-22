<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class President extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'mobile_number',
        'email',
        'candidate_number',
        'counting',
    ];
}
