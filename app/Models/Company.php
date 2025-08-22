<?php

namespace App\Models;

use App\Models\Device;
use Illuminate\Database\Eloquent\Model;
use Google\Service\Monitoring\Custom;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'mobile',
        'email',
        'owner_name',
        'country',
        'trade_license',
        'address',
        'purchased_subscriptions',
        'consumed_subscriptions',
        'balance',
        'unit_price',
        'vat',
        'tax',
        'duty',
        'currency',
        'terms_and_conditions',
        'password',
    ];

    public function devices()
    {
        return $this->hasMany(Device::class, 'company_id', 'id');
    }

    public function customer()
    {
        return $this->hasMany(Customer::class, 'company_id', 'id');
    }
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'company_id', 'id');
    }
    public function users()
    {
        return $this->hasMany(User::class, 'company_id', 'id');
    }
    public function payments()
    {
        return $this->hasMany(Payment::class, 'company_id', 'id');
    }
}
