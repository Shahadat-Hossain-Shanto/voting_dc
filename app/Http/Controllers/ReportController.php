<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Plaza;
use App\Models\BasicInfo;
use App\Models\DeviceModel;
use App\Models\EmiConfig;
use App\Models\EmiDetail;
use App\Models\EmiSchedule;
use Illuminate\Http\Request;
use App\Models\PaymentDetail;
use App\Models\HireSaleReplace;
use PhpParser\Node\Stmt\Foreach_;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use App\Models\LocationHistory;
use Illuminate\Support\Facades\Log;
use App\Models\Retail;

class ReportController extends Controller
{

    public function defaulter_list ()
    {
        return view ( 'report/defaulter' );
    }

    public function defaulter_list_data ( Request $request )
    {
        // Log::info($request);
        $draw        = $request->input ( 'draw' );
        $start       = $request->input ( 'start' );
        $length      = $request->input ( 'length' );
        $search      = $request->input ( 'search' );
        $searchValue = $search[ 'value' ];
        $order       = $request->input ( 'order' );

        if ( $request->type == 'Model' )
        {
            $query = EmiDetail::leftJoin ( 'basic_infos', 'emi_details.customer_id', '=', 'basic_infos.customer_id' )
                ->select (
                    'basic_infos.customer_name',
                    'basic_infos.customer_id',
                    'basic_infos.customer_mobile',
                    'basic_infos.plaza_id',
                    'basic_infos.plaza_name',
                    'emi_details.defaulted_amount',
                    'emi_details.defaulted_date',
                )
                ->whereIn ( 'basic_infos.model', $request->data )
                ->where ( 'emi_details.defaulted_amount', '>', 0 )
                ->where('emi_details.emi_status', 1)
                ->groupBy ( 'emi_details.customer_id' );

            $data = DB::select ( "
                SELECT COUNT(DISTINCT emi_details.customer_id) AS total_defaulters
                FROM emi_details
                LEFT JOIN basic_infos ON emi_details.customer_id = basic_infos.customer_id
                WHERE basic_infos.model IN (" . implode ( ',', array_fill ( 0, count ( $request->data ), '?' ) ) . ")
                AND emi_details.defaulted_amount > 0
                AND emi_details.emi_status = 1
                GROUP BY emi_details.customer_id
            ", $request->data );

            $total_defaulters = count ( $data );
        }
        else if ( $request->type == 'Plaza' )
        {
            $query = EmiDetail::leftJoin('basic_infos', 'emi_details.customer_id', '=', 'basic_infos.customer_id')
                ->select(
                    'basic_infos.customer_name',
                    'basic_infos.customer_id',
                    'basic_infos.customer_mobile',
                    'basic_infos.plaza_id',
                    'basic_infos.plaza_name',
                    'emi_details.defaulted_amount',
                    'emi_details.defaulted_date',
                )
                ->whereIn('basic_infos.plaza_id', $request->data)
                ->where('emi_details.defaulted_amount', '>', 0)
                ->where('emi_details.emi_status', 1)
                ->groupBy('emi_details.customer_id');

            $data = DB::select("
                SELECT COUNT(DISTINCT emi_details.customer_id) AS total_defaulters
                FROM emi_details
                LEFT JOIN basic_infos ON emi_details.customer_id = basic_infos.customer_id
                WHERE basic_infos.plaza_id IN (" . implode(',', array_fill(0, count($request->data), '?')) . ")
                AND emi_details.defaulted_amount > 0
                AND emi_details.emi_status = 1
                GROUP BY emi_details.customer_id
            ", $request->data);

            $total_defaulters = count($data);
        }

        $query = $query->skip ( $start )->take ( $length );

        $orderByColumnIndex = $order[ 0 ][ 'column' ];
        if ( $request->input ( "columns[$orderByColumnIndex][data]" ) !== null )
        {
            $orderByColumnName = $request->input ( "columns[$orderByColumnIndex][data]" );
        }
        else
        {
            $orderByColumnName = 'basic_infos.customer_id';
        }
        $orderByDirection = $order[ 0 ][ 'dir' ];
        $query->orderBy ( $orderByColumnName, $orderByDirection );

        if ( ! empty ( $searchValue ) )
        {
            $query->where ( function ($query) use ($searchValue)
            {
                $query->Where ( 'basic_infos.customer_id', 'LIKE', "%$searchValue%" )
                    ->orWhere ( 'basic_infos.customer_name', 'LIKE', "%$searchValue%" )
                    ->orWhere ( 'basic_infos.customer_mobile', 'LIKE', "%$searchValue%" )
                    ->orWhere ( 'basic_infos.plaza_id', 'LIKE', "%$searchValue%" )
                    ->orWhere ( 'basic_infos.plaza_name', 'LIKE', "%$searchValue%" );
            } );
            $datas = $query->get ();


            $data = DB::select ( "
                SELECT COUNT(DISTINCT emi_details.customer_id) AS total_defaulters
                FROM emi_details
                LEFT JOIN basic_infos ON emi_details.customer_id = basic_infos.customer_id
                WHERE basic_infos.plaza_id IN (" . implode ( ',', array_fill ( 0, count ( $request->data ), '?' ) ) . ")
                AND emi_details.defaulted_amount > 0
                AND emi_details.emi_status = 1
                AND basic_infos.customer_id LIKE ? or basic_infos.customer_name LIKE ? or basic_infos.customer_mobile LIKE ? or basic_infos.plaza_id LIKE ? or basic_infos.plaza_name LIKE ?
                GROUP BY emi_details.customer_id
            ", array_merge ( $request->data, [ $searchValue ], [ $searchValue ], [ $searchValue ], [ $searchValue ], [ $searchValue ] ) );

            $total_defaulters = count ( $datas );
        }
        else
        {
            $datas = $query->get ();
        }

        if ( $request->ajax () )
        {
            return response ()->json ( [
                "draw"            => $draw,
                "recordsTotal"    => $total_defaulters,
                "recordsFiltered" => $total_defaulters,
                'unpaid'          => $datas,
            ] );
        }
    }

    public function defaulter_total ( Request $request )
    {
        if ( $request->type == 'Model' )
        {
            $data = DB::select ( "
                SELECT COUNT(DISTINCT emi_details.customer_id) AS total_defaulters
                FROM emi_details
                LEFT JOIN basic_infos ON emi_details.customer_id = basic_infos.customer_id
                WHERE basic_infos.model IN (" . implode ( ',', array_fill ( 0, count ( $request->data ), '?' ) ) . ")
                AND emi_details.defaulted_amount > 0
                AND emi_details.emi_status = 1
                GROUP BY emi_details.customer_id
            ", $request->data );

            $count = count ( $data );
        }
        else if ( $request->type == 'Plaza' )
        {
            $data = DB::select ( "
                SELECT COUNT(DISTINCT emi_details.customer_id) AS total_defaulters
                FROM emi_details
                LEFT JOIN basic_infos ON emi_details.customer_id = basic_infos.customer_id
                WHERE basic_infos.plaza_id IN (" . implode ( ',', array_fill ( 0, count ( $request->data ), '?' ) ) . ")
                AND emi_details.defaulted_amount > 0
                AND emi_details.emi_status = 1
                GROUP BY emi_details.customer_id
            ", $request->data );

            $count = count ( $data );
        }

        if ( $request->ajax () )
        {
            return response ()->json ( [
                'totalRecords' => $count,
            ] );
        }
    }

    public function defaulter_imei ( Request $request, $customer_id )
    {
        $info = BasicInfo::where ( 'customer_id', $customer_id )->get ( [ 'model', 'imei_1', 'imei_2', 'serial_number' ] );
        if ( $request->ajax () )
        {
            return response ()->json ( [
                'info' => $info,
            ] );
        }
    }

    public function plaza_info ( Request $request )
    {
        $plazas = Plaza::get ();
        if ( $request->ajax () )
        {
            return response ()->json ( [
                'plazas' => $plazas,
            ] );
        }
    }
    public function retail_info ( Request $request )
    {
        $retails = Retail::select('id', 'name')->get();
         return response()->json($retails);
    }

    public function model_info ( Request $request )
    {
        $models = DeviceModel::select('id', 'model')->get();
         return response()->json($models);
    }

    //monthly emi sale
    public function monthly_emi ()
    {
        return view ( 'report/monthly_emi_sale' );
    }

    public function locked_emi ()
    {
        return view ( 'report/locked_devices' );
    }

    public function inactive_emi ()
    {
        return view ( 'report/inactive_devices' );
    }

    public function monthly_emi_data ( Request $request )
    {
        // Log::info($request);
        $draw   = $request->input ( 'draw' );
        $start  = $request->input ( 'start' );
        $length = $request->input ( 'length' );
        $order  = $request->input ( 'order' );
        $search = $request->input ( 'search' );

        if ( $request->type == 'Model' )
        {
            if ( $request->startdate != null && $request->enddate != null )
            {
                $query       = BasicInfo::join ( 'emi_details', 'basic_infos.imei_1', 'emi_details.imei_1' )->Select ( 'basic_infos.*', 'emi_details.*', 'basic_infos.created_at as date' )
                    ->Where ( 'basic_infos.model', $request->data )->whereRaw ( 'DATE(emi_details.down_payment_date) BETWEEN ? AND ?', [ $request->startdate, $request->enddate ] )
                    ->skip ( $start )->take ( $length );
                $total_sales = BasicInfo::join ( 'emi_details', 'basic_infos.imei_1', 'emi_details.imei_1' )->Where ( 'basic_infos.model', $request->data )->whereRaw ( 'DATE(emi_details.down_payment_date) BETWEEN ? AND ?', [ $request->startdate, $request->enddate ] )->count ();
            }
            else
            {
                $query       = BasicInfo::join ( 'emi_details', 'basic_infos.imei_1', 'emi_details.imei_1' )->Select ( 'basic_infos.*', 'emi_details.*', 'basic_infos.created_at as date' )
                    ->Where ( 'basic_infos.model', $request->data )->skip ( $start )->take ( $length );
                $total_sales = BasicInfo::Where ( 'basic_infos.model', $request->data )->count ();
            }
        }
        else if ( $request->type == 'Date' )
        {
            if ( $request->startdate != null && $request->enddate != null )
            {
                $query       = BasicInfo::join ( 'emi_details', 'basic_infos.imei_1', 'emi_details.imei_1' )->Select ( 'basic_infos.*', 'emi_details.*', 'basic_infos.created_at as date' )
                    ->whereRaw ( 'DATE(emi_details.down_payment_date) BETWEEN ? AND ?', [ $request->startdate, $request->enddate ] )->skip ( $start )->take ( $length );
                $total_sales = BasicInfo::join ( 'emi_details', 'basic_infos.imei_1', 'emi_details.imei_1' )
                    ->whereRaw ( 'DATE(emi_details.down_payment_date) BETWEEN ? AND ?', [ $request->startdate, $request->enddate ] )->count ();
            }
        }
        else if ( $request->type == 'Retail' )
        {
            if ( $request->startdate != null && $request->enddate != null )
            {
            $query = BasicInfo::join ( 'emi_details', 'basic_infos.imei_1', 'emi_details.imei_1' )
                ->Select ( 'basic_infos.*', 'emi_details.*', 'basic_infos.created_at as date' )
                ->Where ( 'basic_infos.plaza_id', $request->data )
                ->whereRaw ( 'DATE(emi_details.down_payment_date) BETWEEN ? AND ?', [ $request->startdate, $request->enddate ] )
                ->skip ( $start )->take ( $length );
            $total_sales = BasicInfo::join ( 'emi_details', 'basic_infos.imei_1', 'emi_details.imei_1' )
                ->Where ( 'basic_infos.plaza_id', $request->data )
                ->whereRaw ( 'DATE(emi_details.down_payment_date) BETWEEN ? AND ?', [ $request->startdate, $request->enddate ] )
                ->count ();
            }
            else
            {
            $query = BasicInfo::join ( 'emi_details', 'basic_infos.imei_1', 'emi_details.imei_1' )
                ->Select ( 'basic_infos.*', 'emi_details.*', 'basic_infos.created_at as date' )
                ->Where ( 'basic_infos.plaza_id', $request->data )
                ->skip ( $start )->take ( $length );
            $total_sales = BasicInfo::join ( 'emi_details', 'basic_infos.imei_1', 'emi_details.imei_1' )
                ->Where ( 'basic_infos.plaza_id', $request->data )
                ->count ();
            }
        }

        $orderByColumnIndex = $order[ 0 ][ 'column' ];
        if ( $request->input ( "columns[$orderByColumnIndex][data]" ) !== null )
        {
            $orderByColumnName = $request->input ( "columns[$orderByColumnIndex][data]" );
        }
        else
        {
            // Handle the case when the column name is not found
            // You may want to set a default column name here
            $orderByColumnName = 'basic_infos.customer_id';
        }

        $orderByDirection = $order[ 0 ][ 'dir' ];
        $query->orderBy ( $orderByColumnName, $orderByDirection );
        $searchValue = $search[ 'value' ];

        $query->where ( function ($query) use ($searchValue)
        {
            $query->where ( 'basic_infos.customer_id', 'LIKE', "%$searchValue%" )
                ->orWhere ( 'basic_infos.customer_name', 'LIKE', "%$searchValue%" )
                ->orWhere ( 'basic_infos.customer_nid', 'LIKE', "%$searchValue%" )
                ->orWhere ( 'basic_infos.imei_1', 'LIKE', "%$searchValue%" )
                ->orWhere ( 'basic_infos.imei_2', 'LIKE', "%$searchValue%" )
                ->orWhere ( 'basic_infos.model', 'LIKE', "%$searchValue%" )
                ->orWhere ( 'basic_infos.plaza_id', 'LIKE', "%$searchValue%" )
                ->orWhere ( 'basic_infos.plaza_name', 'LIKE', "%$searchValue%" );
        } );

        if ( $search[ 'value' ] != NULL )
        {
            $total_sales = BasicInfo::where ( 'basic_infos.customer_id', 'LIKE', "%$searchValue%" )
                ->orWhere ( 'basic_infos.customer_name', 'LIKE', "%$searchValue%" )
                ->orWhere ( 'basic_infos.customer_nid', 'LIKE', "%$searchValue%" )
                ->orWhere ( 'basic_infos.imei_1', 'LIKE', "%$searchValue%" )
                ->orWhere ( 'basic_infos.imei_2', 'LIKE', "%$searchValue%" )
                ->orWhere ( 'basic_infos.model', 'LIKE', "%$searchValue%" )
                ->orWhere ( 'basic_infos.plaza_id', 'LIKE', "%$searchValue%" )
                ->orWhere ( 'basic_infos.plaza_name', 'LIKE', "%$searchValue%" )
                ->count ();
        }

        // Get the results
        $sales = $query->get ();

        if ( $request->ajax () )
        {
            return response ()->json ( [
                'sales'           => $sales,
                'total_sales'     => $total_sales,
                "draw"            => $draw,
                "recordsTotal"    => $total_sales,
                "recordsFiltered" => $total_sales,
            ] );
        }
    }

    public function locked_emi_data ( Request $request )
    {
        $draw   = $request->input ( 'draw' );
        $start  = $request->input ( 'start' );
        $length = $request->input ( 'length' );
        $order  = $request->input ( 'order' );
        $search = $request->input ( 'search' );

        if ( $request->type == 'Model' )
        {
            if ( $request->startdate != null && $request->enddate != null )
            {
                $query        = BasicInfo::join ( 'emi_details', 'emi_details.imei_1', 'basic_infos.imei_1' )->Where ( 'model', $request->data )
                    ->whereRaw ( 'DATE(emi_details.down_payment_date) BETWEEN ? AND ?', [ $request->startdate, $request->enddate ] )
                    ->where ( 'lock_status', '!=', 'Unlock' )->skip ( $start )->take ( $length );
                $total_locked = BasicInfo::join ( 'emi_details', 'emi_details.imei_1', 'basic_infos.imei_1' )->Where ( 'model', $request->data )
                    ->whereRaw ( 'DATE(emi_details.down_payment_date) BETWEEN ? AND ?', [ $request->startdate, $request->enddate ] )
                    ->where ( 'lock_status', '!=', 'Unlock' )->count ();
            }
            else
            {
                $query        = BasicInfo::join ( 'emi_details', 'emi_details.imei_1', 'basic_infos.imei_1' )
                    ->Where ( 'model', $request->data )->where ( 'lock_status', '!=', 'Unlock' )->skip ( $start )->take ( $length );
                $total_locked = BasicInfo::join ( 'emi_details', 'emi_details.imei_1', 'basic_infos.imei_1' )
                    ->Where ( 'model', $request->data )->where ( 'lock_status', '!=', 'Unlock' )->count ();
            }
        }
        else if ( $request->type == 'Date' )
        {
            if ( $request->startdate != null && $request->enddate != null )
            {
                $query = BasicInfo::join ( 'emi_details', 'emi_details.imei_1', '=', 'basic_infos.imei_1' )
                    ->where ( 'lock_status', '!=', 'Unlock' ) // Ensure the correct table is referenced
                    ->whereRaw ( 'DATE(emi_details.down_payment_date) BETWEEN ? AND ?', [ $request->startdate, $request->enddate ] )
                    ->skip ( $start )
                    ->take ( $length );

                $total_locked = BasicInfo::join ( 'emi_details', 'emi_details.imei_1', 'basic_infos.imei_1' )
                    ->whereRaw ( 'DATE(emi_details.down_payment_date) BETWEEN ? AND ?', [ $request->startdate, $request->enddate ] )
                    ->where ( 'lock_status', '!=', 'Unlock' )->count ();
            }
        }
        else if ( $request->type == 'Retail' )
        {
            if ( $request->startdate != null && $request->enddate != null )
            {
                $query = BasicInfo::join ( 'emi_details', 'basic_infos.imei_1', 'emi_details.imei_1' )
                    ->Select ( 'basic_infos.*', 'emi_details.*', 'basic_infos.created_at as date' )
                    ->Where ( 'basic_infos.plaza_id', $request->data )
                    ->whereRaw ( 'DATE(emi_details.down_payment_date) BETWEEN ? AND ?', [ $request->startdate, $request->enddate ] )
                    ->where ( 'lock_status', '!=', 'Unlock' )
                    ->skip ( $start )->take ( $length );

                $total_locked = BasicInfo::join ( 'emi_details', 'basic_infos.imei_1', 'emi_details.imei_1' )
                    ->Where ( 'basic_infos.plaza_id', $request->data )
                    ->whereRaw ( 'DATE(emi_details.down_payment_date) BETWEEN ? AND ?', [ $request->startdate, $request->enddate ] )
                    ->where ( 'lock_status', '!=', 'Unlock' )
                    ->count ();
            }
            else
            {
                $query = BasicInfo::join ( 'emi_details', 'basic_infos.imei_1', 'emi_details.imei_1' )
                    ->Select ( 'basic_infos.*', 'emi_details.*', 'basic_infos.created_at as date' )
                    ->Where ( 'basic_infos.plaza_id', $request->data )
                    ->where ( 'lock_status', '!=', 'Unlock' )
                    ->skip ( $start )->take ( $length );

                $total_locked = BasicInfo::join ( 'emi_details', 'basic_infos.imei_1', 'emi_details.imei_1' )
                    ->Where ( 'basic_infos.plaza_id', $request->data )
                    ->where ( 'lock_status', '!=', 'Unlock' )
                    ->count ();
            }
        }

        $orderByColumnIndex = $order[ 0 ][ 'column' ];
        if ( $request->input ( "columns[$orderByColumnIndex][data]" ) !== null )
        {
            $orderByColumnName = $request->input ( "columns[$orderByColumnIndex][data]" );
        }
        else
        {
            // Handle the case when the column name is not found
            // You may want to set a default column name here
            $orderByColumnName = 'basic_infos.customer_id';
        }

        $orderByDirection = $order[ 0 ][ 'dir' ];
        $query->orderBy ( $orderByColumnName, $orderByDirection );
        $searchValue = $search[ 'value' ];

        $query->where ( function ($query) use ($searchValue)
        {
            $query->where ( 'basic_infos.customer_id', 'LIKE', "%$searchValue%" )
                ->orWhere ( 'customer_name', 'LIKE', "%$searchValue%" )
                ->orWhere ( 'customer_nid', 'LIKE', "%$searchValue%" )
                ->orWhere ( 'basic_infos.imei_1', 'LIKE', "%$searchValue%" )
                ->orWhere ( 'basic_infos.imei_2', 'LIKE', "%$searchValue%" )
                ->orWhere ( 'basic_infos.model', 'LIKE', "%$searchValue%" )
                ->orWhere ( 'basic_infos.plaza_id', 'LIKE', "%$searchValue%" )
                ->orWhere ( 'basic_infos.plaza_name', 'LIKE', "%$searchValue%" );
        } );

        if ( $search[ 'value' ] != NULL )
        {
            $total_locked = BasicInfo::join ( 'emi_details', 'emi_details.imei_1', 'basic_infos.imei_1' )
                ->where ( [] )
                ->where ( [ [ 'lock_status', '!=', 'Unlock' ], [ 'basic_infos.customer_id', 'LIKE', "%$searchValue%" ] ] )
                ->orWhere ( [ [ 'lock_status', '!=', 'Unlock' ], [ 'customer_name', 'LIKE', "%$searchValue%" ] ] )
                ->orWhere ( [ [ 'lock_status', '!=', 'Unlock' ], [ 'customer_nid', 'LIKE', "%$searchValue%" ] ] )
                ->orWhere ( [ [ 'lock_status', '!=', 'Unlock' ], [ 'basic_infos.imei_1', 'LIKE', "%$searchValue%" ] ] )
                ->orWhere ( [ [ 'lock_status', '!=', 'Unlock' ], [ 'basic_infos.imei_2', 'LIKE', "%$searchValue%" ] ] )
                ->orWhere ( [ [ 'lock_status', '!=', 'Unlock' ], [ 'model', 'LIKE', "%$searchValue%" ] ] )
                ->orWhere ( [ [ 'lock_status', '!=', 'Unlock' ], [ 'plaza_id', 'LIKE', "%$searchValue%" ] ] )
                ->orWhere ( [ [ 'lock_status', '!=', 'Unlock' ], [ 'plaza_name', 'LIKE', "%$searchValue%" ] ] )
                ->count ();
        }
        // Get the results
        $locks = $query->get ();

        if ( $request->ajax () )
        {
            return response ()->json ( [
                'locks'           => $locks,
                'total_locked'    => $total_locked,
                "draw"            => $draw,
                "recordsTotal"    => $total_locked,
                "recordsFiltered" => $total_locked,
            ] );
        }
    }

    public function inactive_emi_data ( Request $request )
    {
        $draw   = $request->input ( 'draw' );
        $start  = $request->input ( 'start' );
        $length = $request->input ( 'length' );
        $order  = $request->input ( 'order' );
        $search = $request->input ( 'search' );

        if ( $request->type == 'Model' )
        {
            if ( $request->startdate != null && $request->enddate != null )
            {
            $query = BasicInfo::join ( 'emi_details', 'emi_details.imei_1', 'basic_infos.imei_1' )
                ->Select ( 'emi_details.*', 'basic_infos.*', 'basic_infos.created_at as date' )
                ->Where ( 'model', $request->data )->whereRaw ( 'DATE(emi_details.down_payment_date) BETWEEN ? AND ?', [ $request->startdate, $request->enddate ] )
                ->where ( [ [ 'acknowledgment', 0 ], [ 'emi_status', 1 ] ] )
                ->skip ( $start )->take ( $length );

            $total_inactive = BasicInfo::join ( 'emi_details', 'emi_details.imei_1', 'basic_infos.imei_1' )
                ->Where ( 'model', $request->data )
                ->whereRaw ( 'DATE(emi_details.down_payment_date) BETWEEN ? AND ?', [ $request->startdate, $request->enddate ] )
                ->where ( [ [ 'acknowledgment', 0 ], [ 'emi_status', 1 ] ] )
                ->count ();
            }
            else
            {
            $query = BasicInfo::join ( 'emi_details', 'emi_details.imei_1', 'basic_infos.imei_1' )
                ->Select ( 'emi_details.*', 'basic_infos.*', 'basic_infos.created_at as date' )
                ->Where ( 'model', $request->data )
                ->where ( [ [ 'acknowledgment', 0 ], [ 'emi_status', 1 ] ] )
                ->skip ( $start )->take ( $length );

            $total_inactive = BasicInfo::join ( 'emi_details', 'emi_details.imei_1', 'basic_infos.imei_1' )
                ->Where ( 'model', $request->data )
                ->where ( [ [ 'acknowledgment', 0 ], [ 'emi_status', 1 ] ] )
                ->count ();
            }
        }
        else if ( $request->type == 'Date' )
        {
            if ( $request->startdate != null && $request->enddate != null )
            {
            $query = BasicInfo::join ( 'emi_details', 'emi_details.imei_1', '=', 'basic_infos.imei_1' )
                ->select ( 'emi_details.*', 'basic_infos.*', 'basic_infos.created_at as date' )
                ->where ( [ [ 'acknowledgment', 0 ], [ 'emi_status', 1 ] ] )
                ->whereRaw ( 'DATE(emi_details.down_payment_date) BETWEEN ? AND ?', [ $request->startdate, $request->enddate ] )
                ->skip ( $start )
                ->take ( $length );

            $total_inactive = BasicInfo::join ( 'emi_details', 'emi_details.imei_1', 'basic_infos.imei_1' )
                ->whereRaw ( 'DATE(emi_details.down_payment_date) BETWEEN ? AND ?', [ $request->startdate, $request->enddate ] )
                ->where ( [ [ 'acknowledgment', 0 ], [ 'emi_status', 1 ] ] )
                ->count ();
            }
        }
        else if ( $request->type == 'Retail' )
        {
            if ( $request->startdate != null && $request->enddate != null )
            {
            $query = BasicInfo::join ( 'emi_details', 'basic_infos.imei_1', 'emi_details.imei_1' )
                ->Select ( 'basic_infos.*', 'emi_details.*', 'basic_infos.created_at as date' )
                ->Where ( 'basic_infos.plaza_id', $request->data )
                ->whereRaw ( 'DATE(emi_details.down_payment_date) BETWEEN ? AND ?', [ $request->startdate, $request->enddate ] )
                ->where ( [ [ 'acknowledgment', 0 ], [ 'emi_status', 1 ] ] )
                ->skip ( $start )->take ( $length );

            $total_inactive = BasicInfo::join ( 'emi_details', 'basic_infos.imei_1', 'emi_details.imei_1' )
                ->Where ( 'basic_infos.plaza_id', $request->data )
                ->whereRaw ( 'DATE(emi_details.down_payment_date) BETWEEN ? AND ?', [ $request->startdate, $request->enddate ] )
                ->where ( [ [ 'acknowledgment', 0 ], [ 'emi_status', 1 ] ] )
                ->count ();
            }
            else
            {
            $query = BasicInfo::join ( 'emi_details', 'basic_infos.imei_1', 'emi_details.imei_1' )
                ->Select ( 'basic_infos.*', 'emi_details.*', 'basic_infos.created_at as date' )
                ->Where ( 'basic_infos.plaza_id', $request->data )
                ->where ( [ [ 'acknowledgment', 0 ], [ 'emi_status', 1 ] ] )
                ->skip ( $start )->take ( $length );

            $total_inactive = BasicInfo::join ( 'emi_details', 'basic_infos.imei_1', 'emi_details.imei_1' )
                ->Where ( 'basic_infos.plaza_id', $request->data )
                ->where ( [ [ 'acknowledgment', 0 ], [ 'emi_status', 1 ] ] )
                ->count ();
            }
        }

        $orderByColumnIndex = $order[ 0 ][ 'column' ];
        if ( $request->input ( "columns[$orderByColumnIndex][data]" ) !== null )
        {
            $orderByColumnName = $request->input ( "columns[$orderByColumnIndex][data]" );
        }
        else
        {
            // Handle the case when the column name is not found
            // You may want to set a default column name here
            $orderByColumnName = 'basic_infos.customer_id';
        }

        $orderByDirection = $order[ 0 ][ 'dir' ];
        $query->orderBy ( $orderByColumnName, $orderByDirection );
        $searchValue = $search[ 'value' ];

        $query->where ( function ($query) use ($searchValue)
        {
            $query->where ( 'basic_infos.customer_id', 'LIKE', "%$searchValue%" )
                ->orWhere ( 'customer_name', 'LIKE', "%$searchValue%" )
                ->orWhere ( 'customer_nid', 'LIKE', "%$searchValue%" )
                ->orWhere ( 'basic_infos.imei_1', 'LIKE', "%$searchValue%" )
                ->orWhere ( 'basic_infos.imei_2', 'LIKE', "%$searchValue%" )
                ->orWhere ( 'basic_infos.model', 'LIKE', "%$searchValue%" )
                ->orWhere ( 'basic_infos.plaza_id', 'LIKE', "%$searchValue%" )
                ->orWhere ( 'basic_infos.plaza_name', 'LIKE', "%$searchValue%" );
        } );

        if ( $search[ 'value' ] != NULL )
        {
            $total_inactive = BasicInfo::join ( 'emi_details', 'emi_details.imei_1', 'basic_infos.imei_1' )
                ->where ( [ [ 'acknowledgment', 0 ], [ 'emi_status', 1 ], [ 'basic_infos.customer_id', 'LIKE', "%$searchValue%" ] ] )
                ->orWhere ( [ [ 'acknowledgment', 0 ], [ 'emi_status', 1 ], [ 'customer_name', 'LIKE', "%$searchValue%" ] ] )
                ->orWhere ( [ [ 'acknowledgment', 0 ], [ 'emi_status', 1 ], [ 'customer_nid', 'LIKE', "%$searchValue%" ] ] )
                ->orWhere ( [ [ 'acknowledgment', 0 ], [ 'emi_status', 1 ], [ 'basic_infos.imei_1', 'LIKE', "%$searchValue%" ] ] )
                ->orWhere ( [ [ 'acknowledgment', 0 ], [ 'emi_status', 1 ], [ 'basic_infos.imei_2', 'LIKE', "%$searchValue%" ] ] )
                ->orWhere ( [ [ 'acknowledgment', 0 ], [ 'emi_status', 1 ], [ 'model', 'LIKE', "%$searchValue%" ] ] )
                ->orWhere ( [ [ 'acknowledgment', 0 ], [ 'emi_status', 1 ], [ 'plaza_id', 'LIKE', "%$searchValue%" ] ] )
                ->orWhere ( [ [ 'acknowledgment', 0 ], [ 'emi_status', 1 ], [ 'plaza_name', 'LIKE', "%$searchValue%" ] ] )
                ->count ();
        }
        // Get the results
        $locks = $query->get ();

        if ( $request->ajax () )
        {
            return response ()->json ( [
                'locks'           => $locks,
                'total_inactive'  => $total_inactive,
                "draw"            => $draw,
                "recordsTotal"    => $total_inactive,
                "recordsFiltered" => $total_inactive,
            ] );
        }
    }

    public function monthly_emi_total_sale ( Request $request )
    {
        if ( $request->type == 'Model' )
        {
            if ( $request->startdate != null && $request->enddate != null )
            {
                $total_sales = BasicInfo::join ( 'emi_details', 'basic_infos.imei_1', 'emi_details.imei_1' )->Where ( 'basic_infos.model', $request->data )->whereRaw ( 'DATE(emi_details.down_payment_date) BETWEEN ? AND ?', [ $request->startdate, $request->enddate ] )->count ();
            }
            else
            {
                $total_sales = BasicInfo::Where ( 'basic_infos.model', $request->data )->count ();
            }
        }
        else if ( $request->type == 'Date' )
        {
            if ( $request->startdate != null && $request->enddate != null )
            {
                $total_sales = BasicInfo::join ( 'emi_details', 'basic_infos.imei_1', 'emi_details.imei_1' )
                    ->whereRaw ( 'DATE(emi_details.down_payment_date) BETWEEN ? AND ?', [ $request->startdate, $request->enddate ] )->count ();
            }
        }
        else if ( $request->type == 'Retail' )
        {
            if ( $request->startdate != null && $request->enddate != null )
            {
                $total_sales = BasicInfo::join ( 'emi_details', 'basic_infos.imei_1', 'emi_details.imei_1' )
                    ->Where ( 'basic_infos.plaza_id', $request->data )
                    ->whereRaw ( 'DATE(emi_details.down_payment_date) BETWEEN ? AND ?', [ $request->startdate, $request->enddate ] )->count ();
            }
            else
            {
                $total_sales = BasicInfo::Where ( 'basic_infos.plaza_id', $request->data )->count ();
            }
        }

        if ( $request->ajax () )
        {
            return response ()->json ( [
                'total_sales' => $total_sales,
            ] );
        }
    }

    public function locked_total ( Request $request )
    {
        if ( $request->type == 'Model' )
        {
            if ( $request->startdate != null && $request->enddate != null )
            {
                $total_locked = BasicInfo::join ( 'emi_details', 'emi_details.imei_1', 'basic_infos.imei_1' )
                    ->Where ( 'model', $request->data )
                    ->whereRaw ( 'DATE(emi_details.down_payment_date) BETWEEN ? AND ?', [ $request->startdate, $request->enddate ] )
                    ->where ( 'lock_status', '!=', 'Unlock' )->count ();
            }
            else
            {
                $total_locked = BasicInfo::join ( 'emi_details', 'emi_details.imei_1', 'basic_infos.imei_1' )
                    ->Where ( 'model', $request->data )->where ( 'lock_status', '!=', 'Unlock' )->count ();
            }
        }
        else if ( $request->type == 'Date' )
        {
            if ( $request->startdate != null && $request->enddate != null )
            {
                $total_locked = BasicInfo::join ( 'emi_details', 'emi_details.imei_1', 'basic_infos.imei_1' )
                    ->whereRaw ( 'DATE(emi_details.down_payment_date) BETWEEN ? AND ?', [ $request->startdate, $request->enddate ] )
                    ->where ( 'lock_status', '!=', 'Unlock' )->count ();
            }
        }
        else if ( $request->type == 'Retail' )
        {
            if ( $request->startdate != null && $request->enddate != null )
            {
                $total_locked = BasicInfo::join ( 'emi_details', 'basic_infos.imei_1', 'emi_details.imei_1' )
                    ->Where ( 'basic_infos.plaza_id', $request->data )
                    ->whereRaw ( 'DATE(emi_details.down_payment_date) BETWEEN ? AND ?', [ $request->startdate, $request->enddate ] )
                    ->where ( 'lock_status', '!=', 'Unlock' )->count ();
            }
            else
            {
                $total_locked = BasicInfo::join ( 'emi_details', 'basic_infos.imei_1', 'emi_details.imei_1' )
                    ->Where ( 'basic_infos.plaza_id', $request->data )
                    ->where ( 'lock_status', '!=', 'Unlock' )->count ();
            }
        }

        if ( $request->ajax () )
        {
            return response ()->json ( [
                'total_locked' => $total_locked,
            ] );
        }
    }

    public function inactive_total ( Request $request )
    {
        if ( $request->type == 'Model' )
        {
            if ( $request->startdate != null && $request->enddate != null )
            {
                $total_inactive = BasicInfo::join ( 'emi_details', 'emi_details.imei_1', 'basic_infos.imei_1' )
                    ->Where ( 'model', $request->data )
                    ->whereRaw ( 'DATE(emi_details.down_payment_date) BETWEEN ? AND ?', [ $request->startdate, $request->enddate ] )
                    ->where ( [ [ 'acknowledgment', 0 ], [ 'emi_status', 1 ] ] )
                    ->count ();
            }
            else
            {
                $total_inactive = BasicInfo::join ( 'emi_details', 'emi_details.imei_1', 'basic_infos.imei_1' )
                    ->Where ( 'model', $request->data )
                    ->where ( [ [ 'acknowledgment', 0 ], [ 'emi_status', 1 ] ] )
                    ->count ();
            }
        }
        else if ( $request->type == 'Date' )
        {
            if ( $request->startdate != null && $request->enddate != null )
            {
                $total_inactive = BasicInfo::join ( 'emi_details', 'emi_details.imei_1', 'basic_infos.imei_1' )
                    ->whereRaw ( 'DATE(emi_details.down_payment_date) BETWEEN ? AND ?', [ $request->startdate, $request->enddate ] )
                    ->where ( [ [ 'acknowledgment', 0 ], [ 'emi_status', 1 ] ] )
                    ->count ();
            }
        }
        else if ( $request->type == 'Retail' )
        {
            if ( $request->startdate != null && $request->enddate != null )
            {
                $total_inactive = BasicInfo::join ( 'emi_details', 'basic_infos.imei_1', 'emi_details.imei_1' )
                    ->Where ( 'basic_infos.plaza_id', $request->data )
                    ->whereRaw ( 'DATE(emi_details.down_payment_date) BETWEEN ? AND ?', [ $request->startdate, $request->enddate ] )
                    ->where ( [ [ 'acknowledgment', 0 ], [ 'emi_status', 1 ] ] )
                    ->count ();
            }
            else
            {
                $total_inactive = BasicInfo::join ( 'emi_details', 'basic_infos.imei_1', 'emi_details.imei_1' )
                    ->Where ( 'basic_infos.plaza_id', $request->data )
                    ->where ( [ [ 'acknowledgment', 0 ], [ 'emi_status', 1 ] ] )
                    ->count ();
            }
        }

        if ( $request->ajax () )
        {
            return response ()->json ( [
                'total_inactive' => $total_inactive,
            ] );
        }
    }

    public function completed_emi ()
    {
        return view ( 'report/completed_emi_sale' );
    }

    public function completed_emi_data ( Request $request )
    {
        $draw   = $request->input ( 'draw' );
        $start  = $request->input ( 'start' );
        $length = $request->input ( 'length' );
        $order  = $request->input ( 'order' );
        $search = $request->input ( 'search' );

        if ( $request->type == 'Model' )
        {
            if ( $request->startdate != null && $request->enddate != null )
            {
                $query           = BasicInfo::join ( 'emi_details', 'emi_details.imei_1', 'basic_infos.imei_1' )
                    ->Select ( 'basic_infos.*', 'basic_infos.created_at as date', 'emi_details.*' )
                    ->Where ( 'model', $request->data )->where ( 'emi_details.emi_status', 0 )
                    ->whereRaw ( 'DATE(emi_details.down_payment_date) BETWEEN ? AND ?', [ $request->startdate, $request->enddate ] )
                    ->skip ( $start )->take ( $length );
                $total_completed = BasicInfo::join ( 'emi_details', 'emi_details.imei_1', 'basic_infos.imei_1' )
                    ->Where ( 'model', $request->data )->where ( 'emi_status', 0 )
                    ->whereRaw ( 'DATE(emi_details.down_payment_date) BETWEEN ? AND ?', [ $request->startdate, $request->enddate ] )->count ();
            }
            else
            {
                $query           = BasicInfo::join ( 'emi_details', 'emi_details.imei_1', 'basic_infos.imei_1' )
                    ->Select ( 'basic_infos.*', 'basic_infos.created_at as date', 'emi_details.*' )
                    ->Where ( 'model', $request->data )->where ( 'emi_details.emi_status', 0 )->skip ( $start )->take ( $length );
                $total_completed = BasicInfo::join ( 'emi_details', 'emi_details.imei_1', 'basic_infos.imei_1' )
                    ->Where ( 'model', $request->data )->where ( 'emi_status', 0 )->count ();
            }
        }
        else if ( $request->type == 'Date' )
        {
            if ( $request->startdate != null && $request->enddate != null )
            {
                $query           = BasicInfo::join ( 'emi_details', 'emi_details.imei_1', 'basic_infos.imei_1' )
                    ->Select ( 'basic_infos.*', 'basic_infos.created_at as date', 'emi_details.*' )
                    ->where ( 'emi_details.emi_status', 0 )->whereRaw ( 'DATE(emi_details.down_payment_date) BETWEEN ? AND ?', [ $request->startdate, $request->enddate ] )
                    ->skip ( $start )->take ( $length );
                $total_completed = BasicInfo::join ( 'emi_details', 'emi_details.imei_1', 'basic_infos.imei_1' )
                    ->where ( 'emi_status', 0 )->whereRaw ( 'DATE(emi_details.down_payment_date) BETWEEN ? AND ?', [ $request->startdate, $request->enddate ] )->count ();
            }
        }
        else if ( $request->type == 'Retail' )
        {
            if ( $request->startdate != null && $request->enddate != null )
            {
                $query           = BasicInfo::join ( 'emi_details', 'emi_details.imei_1', 'basic_infos.imei_1' )
                    ->Select ( 'basic_infos.*', 'basic_infos.created_at as date', 'emi_details.*' )
                    ->Where ( 'basic_infos.plaza_id', $request->data )->where ( 'emi_details.emi_status', 0 )
                    ->whereRaw ( 'DATE(emi_details.down_payment_date) BETWEEN ? AND ?', [ $request->startdate, $request->enddate ] )
                    ->skip ( $start )->take ( $length );
                $total_completed = BasicInfo::join ( 'emi_details', 'emi_details.imei_1', 'basic_infos.imei_1' )
                    ->Where ( 'basic_infos.plaza_id', $request->data )->where ( 'emi_status', 0 )
                    ->whereRaw ( 'DATE(emi_details.down_payment_date) BETWEEN ? AND ?', [ $request->startdate, $request->enddate ] )->count ();
            }
            else
            {
                $query           = BasicInfo::join ( 'emi_details', 'emi_details.imei_1', 'basic_infos.imei_1' )
                    ->Select ( 'basic_infos.*', 'basic_infos.created_at as date', 'emi_details.*' )
                    ->Where ( 'basic_infos.plaza_id', $request->data )->where ( 'emi_details.emi_status', 0 )->skip ( $start )->take ( $length );
                $total_completed = BasicInfo::join ( 'emi_details', 'emi_details.imei_1', 'basic_infos.imei_1' )
                    ->Where ( 'basic_infos.plaza_id', $request->data )->where ( 'emi_status', 0 )->count ();
            }
        }

        $orderByColumnIndex = $order[ 0 ][ 'column' ];
        if ( $request->input ( "columns[$orderByColumnIndex][data]" ) !== null )
        {
            $orderByColumnName = $request->input ( "columns[$orderByColumnIndex][data]" );
        }
        else
        {
            $orderByColumnName = 'basic_infos.customer_id';
        }

        $orderByDirection = $order[ 0 ][ 'dir' ];
        $query->orderBy ( $orderByColumnName, $orderByDirection );
        $searchValue = $search[ 'value' ];

        $query->where ( function ($query) use ($searchValue)
        {
            $query->where ( 'basic_infos.customer_id', 'LIKE', "%$searchValue%" )
                ->orWhere ( 'basic_infos.customer_name', 'LIKE', "%$searchValue%" )
                ->orWhere ( 'basic_infos.customer_nid', 'LIKE', "%$searchValue%" )
                ->orWhere ( 'basic_infos.imei_1', 'LIKE', "%$searchValue%" )
                ->orWhere ( 'basic_infos.imei_2', 'LIKE', "%$searchValue%" )
                ->orWhere ( 'basic_infos.model', 'LIKE', "%$searchValue%" )
                ->orWhere ( 'basic_infos.plaza_id', 'LIKE', "%$searchValue%" )
                ->orWhere ( 'basic_infos.plaza_name', 'LIKE', "%$searchValue%" );
        } );

        if ( $search[ 'value' ] != NULL )
        {
            $total_completed = BasicInfo::join ( 'emi_details', 'emi_details.imei_1', 'basic_infos.imei_1' )
                ->where ( [ [ 'emi_details.emi_status', 0 ], [ 'basic_infos.customer_id', 'LIKE', "%$searchValue%" ] ] )
                ->orWhere ( [ [ 'emi_details.emi_status', 0 ], [ 'basic_infos.customer_name', 'LIKE', "%$searchValue%" ] ] )
                ->orWhere ( [ [ 'emi_details.emi_status', 0 ], [ 'basic_infos.customer_nid', 'LIKE', "%$searchValue%" ] ] )
                ->orWhere ( [ [ 'emi_details.emi_status', 0 ], [ 'basic_infos.imei_1', 'LIKE', "%$searchValue%" ] ] )
                ->orWhere ( [ [ 'emi_details.emi_status', 0 ], [ 'basic_infos.imei_2', 'LIKE', "%$searchValue%" ] ] )
                ->orWhere ( [ [ 'emi_details.emi_status', 0 ], [ 'basic_infos.model', 'LIKE', "%$searchValue%" ] ] )
                ->orWhere ( [ [ 'emi_details.emi_status', 0 ], [ 'basic_infos.plaza_id', 'LIKE', "%$searchValue%" ] ] )
                ->orWhere ( [ [ 'emi_details.emi_status', 0 ], [ 'basic_infos.plaza_name', 'LIKE', "%$searchValue%" ] ] )
                ->count ();
        }

        // Get the results
        $completed = $query->get ();
        if ( $request->ajax () )
        {
            return response ()->json ( [
                'completed'       => $completed,
                'total_completed' => $total_completed,
                "draw"            => $draw,
                "recordsTotal"    => $total_completed,
                "recordsFiltered" => $total_completed,
            ] );
        }
    }

    public function completed_emi_total ( Request $request )
    {
        if ( $request->type == 'Model' )
        {
            if ( $request->startdate != null && $request->enddate != null )
            {
                $total_completed = BasicInfo::join ( 'emi_details', 'emi_details.imei_1', 'basic_infos.imei_1' )
                    ->Where ( 'model', $request->data )->where ( 'emi_status', 0 )
                    ->whereRaw ( 'DATE(emi_details.down_payment_date) BETWEEN ? AND ?', [ $request->startdate, $request->enddate ] )->count ();
            }
            else
            {
                $total_completed = BasicInfo::join ( 'emi_details', 'emi_details.imei_1', 'basic_infos.imei_1' )
                    ->Where ( 'model', $request->data )->where ( 'emi_status', 0 )->count ();
            }
        }
        else if ( $request->type == 'Date' )
        {
            if ( $request->startdate != null && $request->enddate != null )
            {
                $total_completed = BasicInfo::join ( 'emi_details', 'emi_details.imei_1', 'basic_infos.imei_1' )
                    ->where ( 'emi_status', 0 )->whereRaw ( 'DATE(emi_details.down_payment_date) BETWEEN ? AND ?', [ $request->startdate, $request->enddate ] )->count ();
            }
        }
        else if ( $request->type == 'Retail' )
        {
            if ( $request->startdate != null && $request->enddate != null )
            {
                $total_completed = BasicInfo::join ( 'emi_details', 'emi_details.imei_1', 'basic_infos.imei_1' )
                    ->Where ( 'basic_infos.plaza_id', $request->data )->where ( 'emi_status', 0 )
                    ->whereRaw ( 'DATE(emi_details.down_payment_date) BETWEEN ? AND ?', [ $request->startdate, $request->enddate ] )->count ();
            }
            else
            {
                $total_completed = BasicInfo::join ( 'emi_details', 'emi_details.imei_1', 'basic_infos.imei_1' )
                    ->Where ( 'basic_infos.plaza_id', $request->data )->where ( 'emi_status', 0 )->count ();
            }
        }

        if ( $request->ajax () )
        {
            return response ()->json ( [
                'total_completed' => $total_completed,
            ] );
        }
    }

    public function replaced_devices ()
    {
        return view ( 'report/replaced-devices' );
    }

    public function replaced_devices_data ( Request $request )
    {
        $draw   = $request->input ( 'draw' );
        $start  = $request->input ( 'start' );
        $length = $request->input ( 'length' );

        $search      = $request->input ( 'search' );
        $searchValue = $search[ 'value' ];
        $order       = $request->input ( 'order' );


        if ( $request->type == 'Customer Id' )
        {
            $query = BasicInfo::join ( 'hire_sale_replace', function ($join)
            {
                $join->on ( 'hire_sale_replace.new_imei', '=', 'basic_infos.imei_1' );
                $join->orOn ( 'hire_sale_replace.new_imei', '=', 'basic_infos.imei_2' );
            } )
                ->Where ( 'basic_infos.customer_id', $request->data )
                ->skip ( $start )
                ->take ( $length );

            $datas        = $query->get ();
            $totalRecords = BasicInfo::join ( 'hire_sale_replace', function ($join)
            {
                $join->on ( 'hire_sale_replace.new_imei', '=', 'basic_infos.imei_1' );
                $join->orOn ( 'hire_sale_replace.new_imei', '=', 'basic_infos.imei_2' );
            } )
                ->Where ( 'basic_infos.customer_id', $request->data )->count ();
        }
        else if ( $request->type == 'IMEI' )
        {
            $query = BasicInfo::join ( 'hire_sale_replace', function ($join)
            {
                $join->on ( 'hire_sale_replace.new_imei', '=', 'basic_infos.imei_1' );
                $join->orOn ( 'hire_sale_replace.new_imei', '=', 'basic_infos.imei_2' );
            } )
                ->Where ( 'basic_infos.imei_1', $request->data )
                ->orWhere ( 'basic_infos.imei_2', $request->data )
                ->skip ( $start )
                ->take ( $length );

            $datas        = $query->get ();
            $totalRecords = BasicInfo::join ( 'hire_sale_replace', function ($join)
            {
                $join->on ( 'hire_sale_replace.new_imei', '=', 'basic_infos.imei_1' );
                $join->orOn ( 'hire_sale_replace.new_imei', '=', 'basic_infos.imei_2' );
            } )->Where ( 'basic_infos.imei_1', $request->data )
                ->orWhere ( 'basic_infos.imei_2', $request->data )->count ();
        }
        else if ( $request->type == 'Date' )
        {
            if ( $request->startdate != null && $request->enddate != null )
            {
                $query = BasicInfo::join ( 'hire_sale_replace', function ($join)
                {
                    $join->on ( 'hire_sale_replace.new_imei', '=', 'basic_infos.imei_1' );
                    $join->orOn ( 'hire_sale_replace.new_imei', '=', 'basic_infos.imei_2' );
                } )
                    ->whereBetween ( 'hire_sale_replace.date_of_approval', [ $request->startdate, $request->enddate ] )
                    ->skip ( $start )
                    ->take ( $length );

                $datas        = $query->get ();
                $totalRecords = BasicInfo::join ( 'hire_sale_replace', function ($join)
                {
                    $join->on ( 'hire_sale_replace.new_imei', '=', 'basic_infos.imei_1' );
                    $join->orOn ( 'hire_sale_replace.new_imei', '=', 'basic_infos.imei_2' );
                } )
                    ->whereBetween ( 'hire_sale_replace.date_of_approval', [ $request->startdate, $request->enddate ] )
                    ->count ();
            }
        }
        else if ( $request->type == 'Retail' )
        {
            $query = BasicInfo::join ( 'hire_sale_replace', function ($join)
            {
                $join->on ( 'hire_sale_replace.new_imei', '=', 'basic_infos.imei_1' );
                $join->orOn ( 'hire_sale_replace.new_imei', '=', 'basic_infos.imei_2' );
            } )
                ->Where ( 'basic_infos.plaza_id', $request->data )
                ->skip ( $start )
                ->take ( $length );

            $datas        = $query->get ();
            $totalRecords = BasicInfo::join ( 'hire_sale_replace', function ($join)
            {
                $join->on ( 'hire_sale_replace.new_imei', '=', 'basic_infos.imei_1' );
                $join->orOn ( 'hire_sale_replace.new_imei', '=', 'basic_infos.imei_2' );
            } )
                ->Where ( 'basic_infos.plaza_id', $request->data )->count ();
        }

        $orderByColumnIndex = $order[ 0 ][ 'column' ];
        if ( $request->input ( "columns[$orderByColumnIndex][data]" ) !== null )
        {
            $orderByColumnName = $request->input ( "columns[$orderByColumnIndex][data]" );
        }
        else
        {
            // Handle the case when the column name is not found
            // You may want to set a default column name here
            $orderByColumnName = 'basic_infos.imei_1';
        }

        $orderByDirection = $order[ 0 ][ 'dir' ];
        $query->orderBy ( $orderByColumnName, $orderByDirection );

        if ( ! empty ( $searchValue ) )
        {
            $query->where ( function ($query) use ($searchValue)
            {
                $query->Where ( 'basic_infos.imei_1', 'LIKE', "%$searchValue%" )
                    ->orWhere ( 'basic_infos.imei_2', 'LIKE', "%$searchValue%" )
                    ->orWhere ( 'basic_infos.customer_id', 'LIKE', "%$searchValue%" )
                    ->orWhere ( 'basic_infos.customer_name', 'LIKE', "%$searchValue%" )
                    ->orWhere ( 'basic_infos.plaza_id', 'LIKE', "%$searchValue%" )
                    ->orWhere ( 'basic_infos.plaza_name', 'LIKE', "%$searchValue%" );
            } );

            $datas        = $query->get ();
            $totalRecords = BasicInfo::join ( 'hire_sale_replace', function ($join)
            {
                $join->on ( 'hire_sale_replace.new_imei', '=', 'basic_infos.imei_1' );
                $join->orOn ( 'hire_sale_replace.new_imei', '=', 'basic_infos.imei_2' );
            } )->Where ( 'basic_infos.imei_1', 'LIKE', "%$searchValue%" )
                ->orWhere ( 'basic_infos.imei_2', 'LIKE', "%$searchValue%" )
                ->orWhere ( 'basic_infos.customer_id', 'LIKE', "%$searchValue%" )
                ->orWhere ( 'basic_infos.customer_name', 'LIKE', "%$searchValue%" )
                ->orWhere ( 'basic_infos.plaza_id', 'LIKE', "%$searchValue%" )
                ->orWhere ( 'basic_infos.plaza_name', 'LIKE', "%$searchValue%" )
                ->count ();
        }

        if ( $request->ajax () )
        {
            return response ()->json ( [
                "draw"            => $draw,
                "recordsTotal"    => $totalRecords,
                "recordsFiltered" => $totalRecords,
                'emi'             => $datas,
            ] );
        }
    }

    public function replaced_devices_total ( Request $request )
    {
        if ( $request->type == 'Customer Id' )
        {
            $total_replaced = BasicInfo::join ( 'hire_sale_replace', function ($join)
            {
                $join->on ( 'hire_sale_replace.new_imei', '=', 'basic_infos.imei_1' );
                $join->orOn ( 'hire_sale_replace.new_imei', '=', 'basic_infos.imei_2' );
            } )
                ->Where ( 'basic_infos.customer_id', $request->data )->count ();
        }
        else if ( $request->type == 'IMEI' )
        {
            $total_replaced = BasicInfo::join ( 'hire_sale_replace', function ($join)
            {
                $join->on ( 'hire_sale_replace.new_imei', '=', 'basic_infos.imei_1' );
                $join->orOn ( 'hire_sale_replace.new_imei', '=', 'basic_infos.imei_2' );
            } )->Where ( 'basic_infos.imei_1', $request->data )
                ->orWhere ( 'basic_infos.imei_2', $request->data )->count ();
        }
        else if ( $request->type == 'Date' )
        {
            if ( $request->startdate != null && $request->enddate != null )
            {
                $total_replaced = BasicInfo::join ( 'hire_sale_replace', function ($join)
                {
                    $join->on ( 'hire_sale_replace.new_imei', '=', 'basic_infos.imei_1' );
                    $join->orOn ( 'hire_sale_replace.new_imei', '=', 'basic_infos.imei_2' );
                } )->whereBetween ( 'hire_sale_replace.date_of_approval', [ $request->startdate, $request->enddate ] )->count ();
            }
        }
        else if ( $request->type == 'Retail' )
        {
            $total_replaced = BasicInfo::join ( 'hire_sale_replace', function ($join)
            {
                $join->on ( 'hire_sale_replace.new_imei', '=', 'basic_infos.imei_1' );
                $join->orOn ( 'hire_sale_replace.new_imei', '=', 'basic_infos.imei_2' );
            } )->Where ( 'basic_infos.plaza_id', $request->data )->count ();
        }

        if ( $request->ajax () )
        {
            return response ()->json ( [
                'total_replaced' => $total_replaced,
            ] );
        }
    }
}
