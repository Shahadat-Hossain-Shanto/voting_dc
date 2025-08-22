<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemRestriction extends Model
{
    use HasFactory; 
    
    protected $table = 'system_restrictions';

    protected $fillable = [
        'imei',
        'system_apps'
        
    ];
}
