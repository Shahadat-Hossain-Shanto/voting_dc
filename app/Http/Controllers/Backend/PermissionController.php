<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use App\Models\PermissionGroup;

class PermissionController extends Controller
{
    public function index(Request $request)
    {
        $permissions = Permission::all();
        $permission_groups = PermissionGroup::all();

        return view('backend/user-management/permission/permission-list', compact('permissions', 'permission_groups'));
    }

    public function listData(Request $request)
    {
        $permissions = Permission::all();
        $permission_groups = PermissionGroup::all();

        if ($request->ajax()) {
            return response()->json([
                'permissions' => $permissions,
            ]);
        }
    }

    public function create()
    {
        $permission_groups = PermissionGroup::all();
        return view('backend/user-management/permission/permission-add', compact('permission_groups'));
    }

    public function store(Request $req)
    {
        foreach ($req->permissionList as $permission) {
            $data = new Permission;
            $data->name = $permission['route_name'];
            $data->permissions_name = $permission['permission_name'];
            $data->permission_type = $permission['permission_type'];
            $data->group_name = $permission['permission_group'];
            $data->save();
        }
        return response()->json([
            'status' => 200,
            'message' => 'Permission created Successfully!'
        ]);
    }

    public function edit($id)
    {
        $permission = Permission::find($id);
        $permission_groups = PermissionGroup::all();

        if ($permission) {
            return response()->json([
                'status' => 200,
                'permission' => $permission,
                'permission_groups' => $permission_groups,
            ]);
        }
    }

    public function update(Request $req, $id)
    {
        Permission::findOrFail($id)->update([
            'name' => $req->route_name,
            'group_name' => $req->permission_group,
            'permissions_name' => $req->permission_name,
            'permission_type' => $req->permission_group_type,
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Permission Updated Successfully'
        ]);
    }


    public function destroy($id)
    {
        Permission::findOrFail($id)->delete();
        return redirect('/permission-list')->with('status', 'Deleted successfully!');
    }

    public function getPermissionList()
    {
        $permissions = DB::table("permissions")
            ->select("permissions_name", "permission_type")
            ->addSelect(DB::raw("max(if(`permission_type` = 'create', name, null)) `p_create`"))
            ->addSelect(DB::raw("max(if(`permission_type` = 'create', id, null)) `p_create_id`"))
            ->addSelect(DB::raw("max(if(`permission_type` = 'edit', name, null)) `p_edit`"))
            ->addSelect(DB::raw("max(if(`permission_type` = 'edit', id, null)) `p_edit_id`"))
            ->addSelect(DB::raw("max(if(`permission_type` = 'view', name, null)) `p_view`"))
            ->addSelect(DB::raw("max(if(`permission_type` = 'view', id, null)) `p_view_id`"))
            ->addSelect(DB::raw("max(if(`permission_type` = 'destroy', name, null)) `p_destroy`"))
            ->addSelect(DB::raw("max(if(`permission_type` = 'destroy', id, null)) `p_destroy_id`"))
            ->where("group_name", "=", "medicine")
            ->groupBy("permissions_name", "permission_type")
            ->get();

        return ($permissions);
    }
}
