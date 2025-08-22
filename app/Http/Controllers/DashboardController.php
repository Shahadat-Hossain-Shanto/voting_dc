<?php

namespace App\Http\Controllers;

use Log;
use Carbon\Carbon;
use App\Models\Device;
use App\Models\Company;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function logedIn ()
    {
        return view ( 'logedIn' );
    }
    public function index()
    {
        $today = Carbon::today();
        $startOfMonth = Carbon::now()->startOfMonth();
        $company_id = Auth::user()->company_id;
    
        // Total purchased subscriptions
        $totalSubscriptions = Subscription::when($company_id != 0, function ($query) use ($company_id) {
                return $query->where('company_id', $company_id);
            })
            ->where('approve_status', 1)
            ->sum('purchased_subscription');
    
        // This month's purchased subscriptions
        $monthlySubscriptions = Subscription::when($company_id != 0, function ($query) use ($company_id) {
                return $query->where('company_id', $company_id);
            })
            ->whereDate('created_at', '>=', $startOfMonth)
            ->where('approve_status', 1)
            ->sum('purchased_subscription');
    
        // Today's purchased subscriptions
        $todaySubscriptions = Subscription::when($company_id != 0, function ($query) use ($company_id) {
                return $query->where('company_id', $company_id);
            })
            ->whereDate('created_at', $today)
            ->where('approve_status', 1)
            ->sum('purchased_subscription');
    
        // Total consumed devices
        $totalConsumes = Device::when($company_id != 0, function ($query) use ($company_id) {
                return $query->where('company_id', $company_id);
            })
            ->count();
    
        // This month's consumed devices
        $monthlyConsumes = Device::when($company_id != 0, function ($query) use ($company_id) {
                return $query->where('company_id', $company_id);
            })
            ->whereDate('created_at', '>=', $startOfMonth)
            ->count();
    
        // Today's consumed devices
        $todayConsumes = Device::when($company_id != 0, function ($query) use ($company_id) {
                return $query->where('company_id', $company_id);
            })
            ->whereDate('created_at', $today)
            ->count();
    
        // Get company balance if company_id != 0
        $balance = $company_id != 0
            ? Company::find($company_id)
            : null;
    
        return view('dashboard', compact(
            'totalSubscriptions',
            'monthlySubscriptions',
            'todaySubscriptions',
            'todayConsumes',
            'monthlyConsumes',
            'totalConsumes',
            'balance'
        ));
    }
    

    public function consumesGraph ( Request $request )
    {
       $currentYear = now()->year;
            $companyId = Auth::user()->company_id;

            // Fetch monthly device count for current year
            $monthlyDeviceData = Device::select(
                DB::raw("MONTH(created_at) as month_number"),
                DB::raw("COUNT(id) as total")
            )
            ->when($companyId != 0, function ($query) use ($companyId) {
                return $query->where('company_id', $companyId);
            })
            ->whereYear('created_at', $currentYear)
            ->groupBy('month_number')
            ->orderBy('month_number')
            ->get()
            ->keyBy('month_number');


            // Prepare labels and data for all 12 months
            $labels = [];
            $data = [];

            for ($m = 1; $m <= 12; $m++) {
                $labels[] = Carbon::createFromDate(null, $m, 1)->format('F'); // Full month name (e.g., January)
                $data[] = $monthlyDeviceData->has($m) ? $monthlyDeviceData[$m]->total : 0;
            }
            log::info($data);
            if ($request->ajax()) {
                return response()->json([
                    'status' => 200,
                    'months' => $labels,  // <-- ADD THIS
                    'consumes' => $data   // <-- RENAME this key to match your JS
                ]);
            }

    }

    public function subscriptionsGraph(Request $request)
    {
        $currentYear = now()->year;
        $companyId = Auth::user()->company_id;

        // Fetch monthly subscription sums for current year
        $monthlySubscriptions = Subscription::select(
            DB::raw("MONTH(created_at) as month_number"),
            DB::raw("SUM(purchased_subscription) as total")
        )
        ->when($companyId != 0, function ($query) use ($companyId) {
            return $query->where('company_id', $companyId);
        })
        ->whereYear('created_at', $currentYear)
        ->groupBy('month_number')
        ->orderBy('month_number')
        ->get()
        ->keyBy('month_number');

        // Prepare full labels and data (for all 12 months)
        $labels = [];
        $data = [];

        for ($m = 1; $m <= 12; $m++) {
            $labels[] = Carbon::createFromDate(null, $m, 1)->format('F');
            $data[] = $monthlySubscriptions->has($m) ? (float) $monthlySubscriptions[$m]->total : 0;
        }


        if ($request->ajax()) {
            return response()->json([
                'status' => 200,
                'months' => $labels,
                'subscriptions' => $data
            ]);
        }
    }






   
    
    public function DashboardDeviceData(Request $request)
    {
        $authCompanyId = Auth::user()->company_id;
    
        // Get start and end date from request or fallback to today
        $startDate = $request->startDate ?? Carbon::today()->toDateString();
        $endDate = $request->endDate ?? Carbon::today()->toDateString();
    
        $query = Device::with('customer')
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate);
    
        // If you want to limit by company ID when not 0
        if ($authCompanyId != 0) {
            $query->where('company_id', $authCompanyId);
        }
    
        $results = $query->orderBy('devices.created_at', 'DESC')->get();
    
        if ($request->ajax()) {
            return response()->json([
                "status" => 200,
                "mobile" => $results,
            ]);
        }
    }
    
}
