<?php

namespace App\Http\Controllers\Admin;

use Config;
use Validator;
use Illuminate\Http\Request;
use App\Models\Admin\UserModel;
use App\Helpers\CommonFunctions;
use Elegant\Sanitizer\Sanitizer;
use App\Helpers\WelfareDataTable;
use Illuminate\Support\Facades\DB;
use App\Models\Admin\UserTypeModel;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Admin\OfficeTypeModel;
use App\Models\Admin\DesignationModel;
use App\Models\Admin\OfficedetailModel;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;
class UserController extends Controller
{

    public function index(Request $request)
    {
        $prep_class = new CommonFunctions();
        
        if (request()->ajax()) {
            return $this->userGrid();
        }
        $view_priv = $prep_class->buttonPrivilageFun($request, "admin/user", "view");
        $btn_save = "";

        $usertype = UserTypeModel::pluck('user_type_name', 'user_type_id')->all();
        $designation = DesignationModel::pluck('designation_name', 'designation_id')->all();
        $office = OfficedetailModel::where('approve_flag',1)->where('validity_flg',0)->pluck('office_name', 'office_id')->all();
        $district=DB::table('public.district')->orderBy('districtid','asc')->pluck('distdesc','districtid')->all();
        // $taluk=DB::table('public.taluk')->pluck('talukdesc','talukid')->all();
        // $block=DB::table('public.block')->pluck('blockdesc','blockid')->all();

        if ($view_priv == 1) {
            $save_priv = $prep_class->buttonPrivilageFun($request, "admin/user", "insert");
            if ($save_priv == 1) {
                $btn_save = "<input type='button' class='btn btn-primary btn  btn-out-dashed' value='Create' id='userregbtn' name='userregbtn' onclick='user_save();'>";
            }
            return view('admin.pages.add_user', compact('usertype', 'designation', 'office', 'district', 'btn_save'))->with('page_title', 'Add User ');
        } else {
            return view('admin.pages.privilage',)->with('page_title', 'No Privilage');
        }
        

        
    }

    public function store(Request $request)
    {
        $created_by = Session::get('userid');
        $taluk_id = 0;
        $block_id = 0;
        if($request->district_id) $distid=$request->district_id;
        else {
          $distid=0;
        }
        
        $data = [
            'name' => $request->name,
            'username' => $request->username,
            'password' => $request->password,
            'cpassword' => $request->cpassword,
            'email_address' => $request->email_address,
            'mob_number' => $request->mob_number,
            'office_id' => $request->office_id,
            'designation_id' => $request->designation_id,
            'usertype' => $request->usertype,
            'created_by' => $created_by,
            'updated_by' => $created_by,
            'district_id'=>$distid,
            // 'talukid'=>$taluk_id,
            // 'blockid'=>$block_id
        ];
        $filters = [
            'name' => 'trim|escape|capitalize',
            'username' => 'trim|escape',
            'password' => 'trim|escape',
            'cpassword' => 'trim|escape',
            'office_id' => 'trim|escape',
            'usertype' => 'trim|escape',
            'designation_id' => 'trim|escape',
            'email_address' => 'trim|escape',
            'mob_number' => 'trim|escape',
        ];
        $sanitizer = new Sanitizer($data, $filters);
        $data = $sanitizer->sanitize();
        $rules = array(
            'name' => 'required|min:2|regex:/^[A-Za-z\s.]+$/',
            'username' => 'required|min:2|unique:admin_users|regex:#d*[a-zA-Z_][a-zA-Z0-9]+[a-zA-Z+]*$#',
            'password' => 'required|min:6|regex:/^[A-Za-z@$!%*#?&0-9.]+$/i',
            'cpassword' => 'required|min:6|same:password',
            'email_address' => 'required|email|unique:admin_users|regex:/^[A-Za-z@0-9.-_]/i',
            // 'email_address'  => 'required|email|unique:admin_users|regex:/^(\w[-._\w]*\w@\w[-._\w]*\w\.\w*[^(?!\bweb\b)].{2,3})*$/',
            'mob_number' => 'required|numeric|unique:admin_users|regex:/[0-9]+[1-9]/',
            'usertype' => 'required|numeric',
            'designation_id' => 'numeric',
            'office_id' => 'numeric',
        );
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            $error_message = $validator->errors()->toArray();
            echo json_encode($error_message);
        } else {
            $key = "_motor";
            $data['password'] = md5($data['password'] . $key);
            $usersave = UserModel::create($data);
            if ($usersave->user_id) {
                Log::info('New User Saved: ' . Session::get('userid'));
                $msg = 1;
            } else {
                $msg = 0;
                Log::error('Error in Saving New User: ' . $msg);
            }

            echo json_encode($msg);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {

        $new_password = $request->password;
        $con_password = $request->con_password;
        $old_pass = $request->old_pss;
        $data = array('password' => $new_password, 'Confirmation Password' => $con_password);
        $rules = array('password' => 'required|min:6|regex:/^[A-Za-z@$!%*#?&0-9.]+$/i', 
        'Confirmation Password' => 'required|min:6|same:password');
        $v = Validator::make($data, $rules);

        if ($v->fails()) {
            $errors = $v->errors()->toArray();

            echo json_encode($errors);exit;
        } else {
            $key = "_motor";
            $pass = md5($old_pass . $key);

            $userdata = UserModel::where(array('user_id' => $id, 'password' => $pass))->value('user_id');

            if ($userdata != '') {
                $newpass = md5($new_password . $key);
                $data1 = array('password' => $newpass);
                $user_up = UserModel::where('user_id', $id)->limit(1)->update($data1);
                if ($user_up) {
                    $msg = 1;
                    $data = array('status' => $msg, 'message' => 'valid', 'success' => 'password updated Successfully');
                } else {
                    $msg = 0;
                    $data = array('status' => $msg, 'message' => 'invalid', 'success' => 'password updation Failed');
                }

            } else {

                $data = array('status' => 2, 'message' => 'invalid', 'error' => 'Invalid Old Password');
            }
            echo json_encode($data);exit;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $prep_class = new CommonFunctions();
        $buttons = "";
        $supdate_priv = $prep_class->buttonPrivilageFun($request, "admin/user", "update");
        if ($supdate_priv == 1) {
            $buttons .= "    <input type='button' class='btn btn-warning btn  btn-out-dashed' value='Update' onclick='user_update();' id='userregbtn' name='userregbtn'>";
        }
        $user_edit = UserModel::find($id);
        $user_edit['buttons']= $buttons;
        if ($request->ajax()) {
            echo json_encode($user_edit);
        }

        //return 1;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) //87
    {
        $created_by = Session::get('userid');
        if($request->district_id) 
        {
            $distid=$request->district_id;
        }
        else 
        {
            $distid=0;
        }

        $user_name=$request->username;
        $val_exist = UserModel::where('username', '=',$user_name)
                               ->where('user_id','!=',$id)
                               ->exists(); 

        if($val_exist)
        {
            // dd("innnn veere idyil e name undu");
            $msg = 3;
            echo json_encode($msg);
        }
        else
        {
            // dd(" outttt veere idyil e name illa");
            $data = [
                    'name' => $request->name,
                    'username' => $user_name,
                    //'password'       => $request->password,
                    //'cpassword'      => $request->password,
                    'email_address' => $request->email_address,
                    'mob_number' => $request->mob_number,
                    'usertype' => $request->usertype,
                    'board_id' => $request->board_id,
                    'office_id' => $request->office_id,
                    'designation_id' => $request->designation_id,
                    'created_by' => $created_by,
                    'updated_by' => $created_by,
                    'district_id'=>$distid,
                ];

           $filters = [
                           'name' => 'trim|escape|capitalize',
                           'username' => 'trim|escape',
                           //'password'       =>  'trim|escape',
                           'email_address' => 'trim|escape',
                           'mob_number' => 'trim|escape',
                           'usertype' => 'trim|escape',
                           'office_id' => 'trim|escape',
                           'designation_id' => 'trim|escape',
                       ];
           $sanitizer = new Sanitizer($data, $filters);
           /////var_dump($sanitizer->sanitize());
           $data = $sanitizer->sanitize();
           $rules = array(
                           'name' => 'required|min:2|regex:/^[A-Za-z\s.]+$/',
                           // 'username'       => 'required|min:2',
                           'email_address' => 'required|email',
                           'mob_number' => 'required|numeric',
                           'usertype' => 'required|numeric',
                           'office_id' => 'numeric',
                           'designation_id' => 'numeric',
                        );
           $validator = Validator::make($data, $rules);
           if ($validator->fails()) 
           {
               $error_message = $validator->errors()->toArray();
               echo json_encode($error_message);
           } 
           else 
           {
               $user_update = UserModel::find($id);

               if ($user_update->update($data)) 
               {
                   $msg = 1;
               } 
               else 
               {
                   $msg = 0;
               }
            echo json_encode($msg);
           }
        }
    }

    public function updateoffice(Request $request) //87
    {
        $user_id = Session::get('userid'); 
        $office_id =$request->office_id; 

        $data = [
            'office_id' => $office_id
        ];
        $user_update = UserModel::find($user_id);
        if ($user_update->update($data)) 
        {
            $rtn = array('sts'=>1,'msg'=>'Office updated');
            // Session::set('office_id', $office_id);
            session()->put('office_id', $office_id);
        }
        else {
            $rtn = array('sts'=>0,'msg'=>'Updation failed');
        }
        echo json_encode($rtn);         
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $prep_class = new CommonFunctions();
        $ip_address = $prep_class->get_client_ip();
        $created_by = Session::get('userid');
        $data = [
            'delete_flag' => 1,
            'validity_flg' => 1,
            'delete_date' => now(),
            'delete_user' => $created_by,
            'delete_ip' => $ip_address,

        ];
        // dd($data);
        $office_data = UserModel::find($id);
        $if_deleted = $office_data->update($data);
        
        if ($if_deleted) {
            $msg = 1;
            Log::info('Record Deleted Successfully: ' . $id);
        } else {
            $msg = 0;
            Log::error('Error in Deleting Records: ' . $id);
        }

        echo json_encode($msg);
        
    }

    public function loadvalues(Request $request)
    {

        $district_id = $request->district_id;
        $talukid=$request->talukid;
        if($request->btn_id=='taluk')
        {
          $taluk=DB::table('public.taluk')->where('districtid',$district_id)->get();
          $taluk = json_decode(json_encode($taluk),True);
          return $taluk;
        }
        if($request->btn_id=='block')
        {
          $block=DB::table('public.block')
                    ->where('thalukid',$talukid)
                    ->get();
          $block =json_decode(json_encode($block),True);
          return $block;

        }
    }

    public function userGrid()
    {
        
        

        $adminusers = UserModel::join('admin_user_type', 'admin_users.usertype', '=', 'admin_user_type.user_type_id')
            ->join('admin_designation', 'admin_designation.designation_id', '=', 'admin_users.designation_id')->select(['admin_users.user_id', 'admin_users.name', 'admin_users.username', 'admin_users.mob_number', 'admin_users.email_address', 'admin_user_type.user_type_name', 'admin_designation.designation_name']);
            // ->where('admin_users.delete_flag', '=',null)
            
           
        
        // dd($adminusers->update_priv);
        return DataTables::of($adminusers)
            ->addColumn('edit_button', function ($adminusers) {
                
                $btn= '<a id="' . $adminusers->user_id . '" href="javascript:void(0)" class="edit_btn icon_edit" title="Edit"></a>';
                
                
                $btn.= '<a id="' . $adminusers->user_id . '" href="javascript:void(0)" class="del_btn icon_delete" title="Delete"></a>';
            
                $btn.='<a id="' . $adminusers->user_id . '" href="javascript:void(0)" data-toggle="modal"    data-target="#myModal' . $adminusers->user_id . '" class="reset_btn  icon_reset_pswd" title="Reset Password"></a>';
               

            $btn.='<div class="modal" id="myModal' . $adminusers->user_id . '" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Reset Password</h5>
                        <button type="button" class="close" data-dismiss="modal" style="color:red";>
                            <i class="fa fa-times" area-hidden="true"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="pass_form" class="justify-content-center" action="" >
                            <div class="col mt-2">
                                <label>Enter Old Password</label></div>
                            <div class="col">
                                <input type="password" class="oldpass col" name="' . $adminusers->user_id . '" id="old_password' . $adminusers->user_id . '" onchange="checkField(this,"password")" maxlength="20">
                                <div id="old_password' . $adminusers->user_id . '_msg" style="color:red;"></div>
                            </div>

                            <div class="col mt-4">
                                <label>Enter New Password</label></div>
                            <div class="col">
                                <input type="password" class="new_pass col" name="' . $adminusers->user_id . '" id="password' . $adminusers->user_id . '" onchange="checkField(this,"password")" maxlength="20">
                                <div id="password' . $adminusers->user_id . '_msg" style="color:red;"></div>
                            </div>

                            <div class="col mt-4">
                                <label>Confirm Password</label>
                            </div>
                            <div class="col">
                                <input type="password" class="con_pass col" name="' . $adminusers->user_id . '" id="con_password' . $adminusers->user_id . '" onchange="checkField(this,"password")" maxlength="20">
                                <div id="con_password' . $adminusers->user_id . '_msg" style="color:red;"></div>
                            </div>

                            <div class="col mt-4 row justify-content-center">
                                <input type="button" value="Reset" id ="' . $adminusers->user_id . '" class="reset_pass btn btn-md btn-success col-md-6 btn-block">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>';

        return $btn;
        })
        ->make();

    }

}
