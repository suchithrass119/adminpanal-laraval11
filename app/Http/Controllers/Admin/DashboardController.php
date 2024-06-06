<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\SchemesHelper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Session;
class DashboardController extends Controller
{

    public function index()
    {
        $modules = session()->get("modules");
        $userType = session()->get("user_type"); // 1 for Directorate, 2 for DIctrict DIC User, 3 for ADIO (Taluk officer), 4 for IEO (block user)
        $userid = Session::get('userid');
        $districtid = DB::table('public.admin_users')->where('user_id', $userid)->value('district_id');
        $blockid = DB::table('public.admin_users')->where('user_id', $userid)->value('blockid');
        $talukid = DB::table('public.admin_users')->where('user_id', $userid)->value('talukid');
        $survey_user = DB::table('public.survey_users')->where('blockid', $blockid)->pluck('sname', 'id')->all();

        if (count($modules) >= 1) {

            // $assigned_index = DB::table('public.survey_unit_assign')->where('assign_status', 1)->select('unit_index')->get();
            // $assigned_index = json_decode(json_encode($assigned_index), true);
            // foreach ($assigned_index as $assigned_indexid) {
            //     $assigned_index_arr[] = $assigned_indexid['unit_index'];

            // }

            // $total_units=DB::table('ssi_survey.perm_regn')
            //                 ->where('final_status',1);
            //                 if($userType==4)
            //                 {
            //                   $total_units = $total_units->where('block_id', $blockid);
            //                 }
            //                 if($userType==3)
            //                 {
            //                   $total_units = $total_units->where('tehsil_code',$talukid);
            //                 }
            //                 if($userType==2)
            //                 {
            //                   $total_units = $total_units->where('dist_code', $districtid);
            //                 }

            //                 $total_units=$total_units->count();

            // $assigned_cnt = DB::table('ssi_survey.perm_regn')->where('final_status', 1)
            //                 ->whereIn('index', $assigned_index_arr);
            //                 if($userType==4)
            //                 {
            //                   $assigned_cnt = $assigned_cnt->where('block_id', $blockid);
            //                 }
            //                 if($userType==3)
            //                 {
            //                   $assigned_cnt = $assigned_cnt->where('tehsil_code',$talukid);
            //                 }
            //                 if($userType==2)
            //                 {
            //                   $assigned_cnt = $assigned_cnt->where('dist_code', $districtid);
            //                 }

            // $assigned_cnt = $assigned_cnt->count();

            // $pending_cnt = DB::table('ssi_survey.perm_regn')->where('final_status', 1)
            //                 ->whereNotIn('index', $assigned_index_arr);
            //                 if($userType==4)
            //                 {
            //                   $pending_cnt = $pending_cnt->where('block_id', $blockid);
            //                 }
            //                 if($userType==3)
            //                 {
            //                   $pending_cnt = $pending_cnt->where('tehsil_code',$talukid);
            //                 }
            //                 if($userType==2)
            //                 {
            //                   $pending_cnt = $pending_cnt->where('dist_code', $districtid);
            //                 }
            // $pending_cnt = $pending_cnt->count();

            // $submitted = DB::table('jalakam2.survey_units')
            //                 ->where('final_status', 1);
            //                 if($userType==4)
            //                 {
            //                   $submitted = $submitted->where('survey_units.blockid', $blockid);
            //                 }
            //                 if($userType==3)
            //                 {
            //                   $submitted = $submitted->where('survey_units.talukid',$talukid);
            //                 }
            //                 if($userType==2)
            //                 {
            //                   $submitted = $submitted->where('survey_units.districtid', $districtid);
            //                 }
            //                 $submitted = $submitted->count();


            // $approved = DB::table('jalakam2.survey_units')
            //                 ->where('final_status', 2);
            //                 if($userType==4)
            //                 {
            //                   $approved = $approved->where('survey_units.blockid', $blockid);
            //                 }
            //                 if($userType==3)
            //                 {
            //                   $approved = $approved->where('survey_units.talukid',$talukid);
            //                 }
            //                 if($userType==2)
            //                 {
            //                   $approved = $approved->where('survey_units.districtid', $districtid);
            //                 }
            //                 $approved = $approved->count();


            // $returned = DB::table('jalakam2.survey_units')
            //                 ->where('final_status', 3);
            //                 if($userType==4)
            //                 {
            //                   $returned = $returned->where('survey_units.blockid', $blockid);
            //                 }
            //                 if($userType==3)
            //                 {
            //                   $returned = $returned->where('survey_units.talukid',$talukid);
            //                 }
            //                 if($userType==2)
            //                 {
            //                   $returned = $returned->where('survey_units.districtid', $districtid);
            //                 }
            //                 $returned = $returned->count();

            // $rejected = DB::table('jalakam2.survey_units')
            //                 ->where('final_status', 4);
            //                 if($userType==4)
            //                 {
            //                   $rejected = $rejected->where('survey_units.blockid', $blockid);
            //                 }
            //                 if($userType==3)
            //                 {
            //                   $rejected = $rejected->where('survey_units.talukid',$talukid);
            //                 }
            //                 if($userType==2)
            //                 {
            //                   $rejected = $rejected->where('survey_units.districtid', $districtid);
            //                 }
            //                 $rejected = $rejected->count();

            // $held = DB::table('jalakam2.survey_units')
            //                 ->where('final_status', 5);
            //                 if($userType==4)
            //                 {
            //                   $held = $held->where('survey_units.blockid', $blockid);
            //                 }
            //                 if($userType==3)
            //                 {
            //                   $held = $held->where('survey_units.talukid',$talukid);
            //                 }
            //                 if($userType==2)
            //                 {
            //                   $held = $held->where('survey_units.districtid', $districtid);
            //                 }
            //                 $held = $held->count();

            // $panchayath_assign_pending=DB::table('ssi_survey.perm_regn')
            //                             ->where('final_status',1)
            //                             ->where('panch_code', 0);
            //                 if($userType==4)
            //                 {
            //                   $panchayath_assign_pending = $panchayath_assign_pending->where('block_id', $blockid);
            //                 }
            //                 if($userType==3)
            //                 {
            //                   $panchayath_assign_pending = $panchayath_assign_pending->where('tehsil_code',$talukid);
            //                 }
            //                 if($userType==2)
            //                 {
            //                   $panchayath_assign_pending = $panchayath_assign_pending->where('dist_code', $districtid);
            //                 }
            //                 $panchayath_assign_pending = $panchayath_assign_pending->count();

            
            $total_units=0;
            $assigned_cnt=0;
            $pending_cnt=0;
            $submitted=0;
            $approved=0;
            $returned=0;
            $rejected=0;
            $held=0;
            $panchayath_assign_pending=0;

       return view('admin.pages.dashboard',compact('userType','total_units','assigned_cnt','pending_cnt','submitted','approved','returned','rejected','held','panchayath_assign_pending'))->with('page_title', 'Dashboard');
        } else {
            $module_id = session()->get("default_module");
            $module_dashboard = DB::table('admin_modules')->where('module_id', $module_id)->value('module_dashboard');
            return redirect($module_dashboard);
        }

    }

}
