<?php

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PermissionGroup;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PermissionGroupController extends Controller
{
    public function list(Request $request)
    {

        return view('backend/user-management/permission/permission_group/group-list');
    }

    public function listData(Request $request){
        $permission_groups = PermissionGroup::all();
        if ($request->ajax()) {
            return response()->json([
                'permission_groups' => $permission_groups,
            ]);
        }
    }

    public function create()
    {
        return view('backend/user-management/permission/permission_group/group-add');
    }

    public function store(Request $req)
    {
        $messages = [
            'group_name.required'  =>    "Group name is required.",
            'group_name.unique'   =>   "Group name already exists."
        ];
        $validator = Validator::make($req->all(), [
            'group_name' => 'required|unique:permission_groups',
        ], $messages);

        if ($validator->passes()) {
            $data = new PermissionGroup();
            $data->group_name = $req->group_name;
            $data->save();
            return redirect('/permission-group-list')->with('status', 'Group created successfully!');
        }

        return response()->json(['error' => $validator->errors()]);
    }

    public function edit($id)
    {
        $permission_group =  PermissionGroup::find($id);
        if ($permission_group) {
            return response()->json([
                'status' => 200,
                'permission_group' => $permission_group,
            ]);
        }
    }

    public function update(Request $req, $id)
    {
        $messages = [
            'group_name.required'  =>    "Group name is required.",
            'group_name.unique'   =>   "Group name already exists."
        ];
        $validator = Validator::make($req->all(), [
            'group_name' => 'required|unique:permission_groups',
        ], $messages);

        if ($validator->passes()) {
            PermissionGroup::findOrFail($id)->update([
                'group_name' => $req->group_name,
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Permission Group Updated Successfully'
            ]);
        }

        return response()->json(['error' => $validator->errors()]);
    }

    public function destroy($id)
    {
        PermissionGroup::find($id)->delete();

        return redirect('/permission-group-list')->with('status', 'Deleted successfully!');
    }
}
