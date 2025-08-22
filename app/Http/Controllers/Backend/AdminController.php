<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Spatie\Permission\Models\Role;
// use App\Models\Store;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{

    public function regUser()
    {

        $roles  = Role::all();
        return view('backend/user-management/user/create-user', ['roles' => $roles]);
    }

    public function storeUser(Request $request)
    {
        $messages = [
            'name.required'         =>    "Name is required.",
            'name.max'              =>    "Max 255 characters.",
            'email.required'        =>    "Email is required.",
            'mobile.required'       =>    "Mobile is required.",
            'department.required'   =>    "Department is required.",
            'email.email'           =>    "Email is not valid.",
            'email.max'             =>    "Max 255 characters.",
            'email.unique'          =>    "Email already exists.",
            'roles.required'        =>    "Role is required.",
            'password.required'     =>    "Password is required.",
            'password.confirmed'    =>    "Confirm your password or password does not match.",
        ];



        $validator = Validator::make($request->all(), [
            'name'                  => ['required', 'max:255'],
            'email'                 => ['required', 'email', 'max:255', 'unique:users'],
            'mobile'                => ['required','digits:11','regex:/^([01]){2}([3-9]){1}([0-9]){8}/i'],
            'department'            => ['required', 'max:255'],
            'roles'                 => ['required'],
            'password'              => ['required', 'confirmed', Rules\Password::defaults()],
            'password_confirmation' => ['required','same:password'],
        ], $messages);

        if ($validator->passes()) {
            $user = new User();

            $user->name                           = $request->name;
            $user->email                          = $request->email;
            $user->mobile                         = $request->mobile;
            $user->department                     = $request->department;
            $user->password                       =  Hash::make($request->password);

            if ($request->roles) {
                $user->assignRole($request->roles);
            }
            $user->save();
            // event(new Registered($user));
            return redirect()->route('user.list.view');
        }
        return response()->json(['error' => $validator->errors()]);
    }
    public function userList()
    {
        $roles  = Role::all();
        $users = User::all();

        return view('backend/user-management/user/user-index', compact('users', 'roles'));
    }

    public function userStatus()
    {
        $roles  = Role::all();
        $users = User::all();

        return view('backend/user-management/user/user-status', compact('users', 'roles'));
    }

    public function userEdit(Request $request, $id)
    {
        $user = User::find($id);
        $roles  = Role::all();
        if ($request->ajax()) {
            return response()->json([
                'status' => 200,
                'user' => $user,

            ]);
        }
        return view('backend/user-management/user/user-edit', compact('user', 'roles'));
    }


    public function userUpdate(Request $request, $id)
    {
        $user = User::find($id);
        $messages = [
            'name.required'         =>    "Name is required.",
            'name.max'              =>    "Max 255 characters.",
            'mobile.required'       =>    "Mobile is required.",
            'department.required'   =>    "Department is required.",
            'email.email'           =>    "Email is not valid.",
            'email.max'             =>    "Max 255 characters.",
            'email.unique'          =>    "Email already exists.",
            'roles.required'        =>    "Role is required.",
            'password.confirmed'    =>    "Confirm your password or password does not match.",
        ];

        $validator = Validator::make($request->all(), [
            'name'                  => ['required', 'max:255'],
            'mobile'                => ['required','digits:11','regex:/^([01]){2}([3-9]){1}([0-9]){8}/i'],
            'department'            => ['required', 'max:255'],
            'roles'                 => ['required'],
            'password'              => ['confirmed'],
            'password_confirmation' => ['same:password'],
        ], $messages);

        if ($validator->passes()) {

            $user->name             = $request->name;
            $user->mobile           = $request->mobile;
            $user->department       = $request->department;
            if ($request->password) {
                $user->password = Hash::make($request->password);
            }
            $user->save();

            $user->roles()->detach();
            if ($request->roles) {
                $user->assignRole($request->roles);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Product updated successfully!'
            ]);
            return redirect()->route('admin.roles');
        }

        return response()->json(['error' => $validator->errors()]);
    }


    public function userDestroy($id)
    {
        $user = User::find($id);
        if (!is_null($user)) {
            $user->delete();
        }

        session()->flash('success', 'User has been deleted !!');
        return back();
    }

    public function resetPassword(Request $request)
    {
        $user = User::find(Auth::user()->id);
        return view('auth.reset-password',['user'=>$user]);
    }

    public function updatePassword(Request $request, $id)
    {
        $messages = [
            'old_password.required'             =>    "Old Password is required.",
            'password.required'                 =>    "New Password is required.",
            'password_confirmation.required'    =>    "Confirm Password is required.",
            'password.confirmed'                =>    "Confirm your password or password does not match.",
        ];

        $validator = Validator::make($request->all(), [
            'old_password' => ['required'],
            'password' => ['required','confirmed'],
            'password_confirmation' => ['required','same:password'],
        ], $messages);

        if ($validator->passes()) {

            $user = User::find($id);
            if (Hash::check($request->old_password,$user->password)) {
                $user->password = Hash::make($request->password);
                $user->save();
                return response()->json([
                    'status' => 200,
                    'message' => 'User password updated successfully!'
                ]);
            }
            $old_password['old_password']=["Old Password dosen't match !"];
            return response()->json([
                'status' => 400,
                'error' => $old_password
            ]);
        }

        return response()->json(['error' => $validator->errors()]);
    }

}

