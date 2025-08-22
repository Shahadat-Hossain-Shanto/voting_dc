<?php

namespace App\Models;

use App\Models\Device;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'mobile',
        'email',
        'address',
        'country',
        'company_id',
        'dc_id',
        'customer_id',
    ];
    public function devices()
    {
        return $this->hasMany(Device::class, 'customer_id', 'customer_id'); // custom local key
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }



}
