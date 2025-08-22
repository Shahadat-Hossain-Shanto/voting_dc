<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use App\Http\Requests\Auth\LoginRequest;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = User::where('id',Auth::user()->id)->first();
        $user->status = "Active";
        // $user= Auth::user();

        $activityLog= new ActivityLog;
        $activityLog->user_name= $user->name;
        $activityLog->user_id= $user->id;
        $activityLog->activity= "Login";
        $activityLog->imei_1 = "Login";
        $activityLog->imei_2 = "Login";

        $activityLog->save();
        $user->save();

        if($user->department=='R&I-QC')
        {
            return redirect()->intended(RouteServiceProvider::TEST);
        }
        else{
            return redirect()->intended(RouteServiceProvider::HOME);
        }
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        $user = User::where('id',Auth::user()->id)->first();
        $user->status = "Inactive";

        $activityLog= new ActivityLog;
        $activityLog->user_name= $user->name;
        $activityLog->user_id= $user->id;
        $activityLog->activity= "Logout";
        $activityLog->imei_1 = "Logout";
        $activityLog->imei_2 = "Logout";

        $activityLog->save();
        $user->save();

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
