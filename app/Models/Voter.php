<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voter extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'mobile_number',
        'voter_number',
        'email',
        'president_name',
        'secretary_name',
        'verify',
        'status',
    ];
}
