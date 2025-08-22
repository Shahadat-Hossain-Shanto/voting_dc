<?php

namespace App\Http\Controllers;

use Log;
use App\Models\BasicInfo;
use App\Models\EmiDetail;
use App\Models\ActivityLog;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ActivityLogController extends Controller
{
    public function activitylog_data(Request $request)
    {
        if($request->imei!=null)
        {
            $activityLog= ActivityLog::select('*','created_at as date')->where('imei_1', $request->imei)->orWhere('imei_2', $request->imei)->get();
            return response()->json([
                'status'=>200,
                'data'=> $activityLog
            ]);
        }
        else
        {
            return response()->json([
                'status'=>400,
                'message'=>"Bad Request"
            ]);
        }

    }


    public function activityLog_view()
    {
        return view('backend/user-management/user/activity_log');
    }

    public function model_delete($model)
    {
        $basicInfos = BasicInfo::join('emi_details', 'emi_details.imei_1', 'basic_infos.imei_1')
            ->where([
                ['model',$model],
                ['acknowledgment',0]
                ])
            ->get(['basic_infos.imei_1','basic_infos.customer_id']);
        foreach($basicInfos AS $basicInfo){
            $deviceCount = EmiDetail::where('customer_id',$basicInfo->customer_id)->count();
            if($deviceCount == 1){
                DB::delete("DELETE FROM emi_schedules WHERE  customer_id = :cid", ['cid' => $basicInfo->customer_id]);
                DB::delete("DELETE FROM payment_details WHERE  customer_id = :cid", ['cid' => $basicInfo->customer_id]);
            }
            DB::delete("DELETE FROM basic_infos WHERE  imei_1 = ?", [$basicInfo->imei_1]);
            DB::delete("DELETE FROM emi_details WHERE  imei_1 = ?", [$basicInfo->imei_1]);
        }
        return response()->json([
            'status'    => 200,
            'message'   => "Model ". $model ."'s All Inactive Devices Deleted"
        ]);
    }


}
