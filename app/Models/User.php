<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','mobile', 'email', 'password','company_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public static function getpermissionsByPermissionName($group_name)
    {
        // $permissions = DB::table('permissions')
        //     ->select('permissions_name', 'name', 'name', 'permission_type', 'id')
        //     ->where('group_name', $group_name)
        //     ->get();
        // // dd($permissions);
        // return $permissions;
        $permissions = DB::table("permissions")
            ->select("permissions_name")
            ->addSelect(DB::raw("max(if(`permission_type` = 'create', name, null)) `p_create`"))
            ->addSelect(DB::raw("max(if(`permission_type` = 'create', id, null)) `p_create_id`"))
            ->addSelect(DB::raw("max(if(`permission_type` = 'edit', name, null)) `p_edit`"))
            ->addSelect(DB::raw("max(if(`permission_type` = 'edit', id, null)) `p_edit_id`"))
            ->addSelect(DB::raw("max(if(`permission_type` = 'view', name, null)) `p_view`"))
            ->addSelect(DB::raw("max(if(`permission_type` = 'view', id, null)) `p_view_id`"))
            ->addSelect(DB::raw("max(if(`permission_type` = 'destroy', name, null)) `p_destroy`"))
            ->addSelect(DB::raw("max(if(`permission_type` = 'destroy', id, null)) `p_destroy_id`"))
            // ->addSelect(DB::raw("max(if(`permission_type` = 'destroy', name, null))`p_destroy`, max(if(`permission_type` = 'destroy', id, null)) `p_destroy_id`"))
            ->where("group_name", "=", $group_name)
            ->groupBy("permissions_name")
            ->get();
        // print_r($permissions);
        return $permissions;
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }
}
