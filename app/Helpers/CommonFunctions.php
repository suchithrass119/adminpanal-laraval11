<?php

namespace App\Helpers;

use App\Helpers\AccountingHelperFuns;
use Illuminate\Http\File;
use DateTime;
//
use App\Http\Controllers\Admin\HelperController;
use Illuminate\Http\Request;
use App\Models\Admin\MenuModel;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Validator;

use Carbon\Carbon;

class CommonFunctions
{
    function get_client_ip()
    {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if (isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }
    function dbto($val)
    {
        $val = explode("-", $val);
        $val = $val[2] . "/" . $val[1] . "/" . $val[0];
        return ($val);
    }
    function todb($val)
    {
        $val = explode("/", $val);
        $val = $val[2] . "-" . $val[1] . "-" . $val[0];
        return ($val);
    }



    function finyear_new($date, $split_string, $format)
    {
        if ($format == 2) { // yyyy/m/d format
            $yy = explode($split_string, $date);
            $m = $yy[1];
            $d = $yy[2];
            $yr = $yy[0];
            $yr2 = $yr - 1;
            $yr1 = $yr + 1;
            if (($m == '01') || ($m == '02') || ($m == '03')) {
                $finyr = $yr2 . '-' . $yr;
            } else {
                $finyr = $yr . '-' . $yr1;
            }
        }
        if ($format == 1) { // d/m/yyyy format
            $yy = explode($split_string, $date);
            $m = $yy[1];
            $d = $yy[0];
            $yr = $yy[2];
            $yr2 = $yr - 1;
            $yr1 = $yr + 1;
            if (($m == '01') || ($m == '02') || ($m == '03')) {
                $finyr = $yr2 . '-' . $yr;
            } else {
                $finyr = $yr . '-' . $yr1;
            }
        }
        // $yy = explode('/', $date);
        // $m = $yy[1];
        // $d = $yy[0];
        // $yr = $yy[2];
        // $yr2 = $yr - 1;
        // $yr1 = $yr + 1;
        // if (($m == '01') || ($m == '02') || ($m == '03')) {
        //     $finyr = $yr2 . '-' . $yr;
        // } else {
        //     $finyr = $yr . '-' . $yr1;
        // }

        return $finyr;
    }


   
   

    function buttonPrivilageFun($request, $url, $action)
    {
        $access = 0;
        $user_type = Session::get('user_type');
        $userid = Session::get('userid');
        $admin_portal_active = Session::get('admin_portal_active');


        // if ((($request->session()->get('user_type') == '2') || ($request->session()->get('user_type') == '1') || ($request->session()->get('user_type') == '3') || ($request->session()->get('user_type') == '4')) &&
        //     ($request->session()->exists('userid')) && ($data['admin_portal_active'] == 1)
        // )

        if ($user_type == 2 || $user_type == 1 || $user_type == 3 || $user_type == 4  || $userid > 0  && $admin_portal_active == 1) {


            $current = $url;
            $resourceaction = $action;


            // DB::enableQueryLog();
            $controller_id = MenuModel::where('route_path', '/' . $current)->value('controller_id');
            // dd($controller_id);
            //$query = DB::getQueryLog();
            //   $lastQuery = end($query);
            //   print_r($query);exit;

            if ($controller_id != '') {
                $result = app('App\Http\Controllers\Admin\SecurityController')->get_rights_given_controller($controller_id);
                $result = json_decode($result, true);
                if ($result['status'] == 'true' || $result['status'] == 'false') {
                    $right_arr = $result['actions'];
                    switch ($resourceaction) {
                        case 'create':
                            $permission_access = app('App\Http\Controllers\Admin\SecurityController')->get_controller_right($controller_id, 'insert');
                            break;
                        case 'store':
                            $permission_access = app('App\Http\Controllers\Admin\SecurityController')->get_controller_right($controller_id, 'insert');
                            break;
                        case 'edit':
                            $permission_access = app('App\Http\Controllers\Admin\SecurityController')->get_controller_right($controller_id, 'view');
                            break;
                        case 'show':
                            $permission_access = app('App\Http\Controllers\Admin\SecurityController')->get_controller_right($controller_id, 'view');
                            break;
                        case 'destroy':
                            $permission_access = app('App\Http\Controllers\Admin\SecurityController')->get_controller_right($controller_id, 'delete');
                            break;
                        default:
                            $permission_access = app('App\Http\Controllers\Admin\SecurityController')->get_controller_right($controller_id, $resourceaction);
                            break;
                    }
                    if ($permission_access == 1) {
                        $access = 1;
                    } else {
                    }
                } else {
                }
            } else {
            }
        }

        return $access;
    }

  
    function get_currentpath()
    {
        $prefix = Route::getFacadeRoot()->current()->getPrefix();
        $pathname =  Route::getFacadeRoot()->current()->getName();
        $path = explode(".", $pathname);
        $currnt_path = $prefix . $path[0];
        return $currnt_path;
    }

    function getSelectValue($tablename, $filedname, $id, $savedvalue, $wherecond)
    {

        $values = DB::table($tablename)->select($filedname, $id);
        if (count($wherecond) > 0) {
            $values = $values->where($wherecond['feildname'], $wherecond['feildvalue']);
        }

        $values = $values->get();

        $str = "<option value=''>-select-</option>";
        foreach ($values as $value) {
            $valueid = $value->$id;
            $valuename = $value->$filedname;
             if($tablename=='parameters.table_memberofficecode')
            {
            $valuename=$valueid.' '.$valuename ;
            }
            if ($value->$id == $savedvalue) {
                $str .= "<option value='$valueid' selected>$valuename</option>";
            } else {
                $str .= "<option value='$valueid'>$valuename</option>";
            }
        }
        return $str;
    }
    function getSelectValueOffice($tablename, $filedname, $office_code, $id, $wherecond)
    {
       

        $values = DB::table($tablename)->select($filedname, $office_code,'id')->whereNull('delete_flag')->get();
        $str = "<option value=''>-select-</option>";
        foreach ($values as $value) {
            $valueid = $value->$office_code;
            $valuename = $value->$filedname;
            $valuename=$valueid.' '.$valuename ;
            if ($value->id == $id) {
                $str .= "<option value='$valueid' selected>$valuename</option>";
            } else if($id==null){
                 $str .= "<option value='' selected></option>";
                $str .= "<option value='$valueid'>$valuename</option>";
            }
        }
        return $str;
    }
  

   
   

   

  



    public function getBetweenDates($startDate, $endDate)
    {

        $rangArray = [];
        $startDate = strtotime($startDate);
        $endDate = strtotime($endDate);

        for (
            $currentDate = $startDate;
            $currentDate <= $endDate;

            $currentDate += (86400)
        ) {
            $date = date('Y-m-d', $currentDate);

            $rangArray[] = $date;
        }

        return $rangArray;
    }


    
 


  
   
   
    
}
