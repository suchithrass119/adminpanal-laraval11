<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Admin\RoleModel;
use App\Models\Admin\UserModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Helpers\CommonFunctions;

class UserroleController extends Controller
{

    public function index(Request $request)
    {
        $users = UserModel::pluck('username', 'user_id')->all();
        $roles = RoleModel::select('role_name', 'role_id')->get();
        $current_path = Route::getFacadeRoot()->current()->uri();
        $prep_class = new CommonFunctions();
        $view_priv = $prep_class->buttonPrivilageFun($request, $current_path, "view");
        if ($view_priv == 1) {
            return view('admin.pages.add_userroles', compact('users', 'roles'))->with('page_title', 'User Roles');
        } else {
            return view('admin.pages.privilage',)->with('page_title', 'No Privilage');
        }
    }

    public function store(Request $request)
    {

        $userlogin = $request->session()->get('userid');
        $data = [
            'user_id' => $request->userid,
        ];

        $rules = [
            'user_id' => 'required|numeric|not_in:0',
        ];

        $validator = validator($data, $rules);

        if ($validator->fails()) {

            $error_message = $validator->errors()->toArray();
            return json_encode($error_message);

        } else {

            $roleid = $request->roleid;
            $roleexist = DB::table('admin_userroles')->where('user_id', '=', $data['user_id'])->pluck('role_id');

            if ($roleexist) {
                DB::table('admin_userroles')->where('user_id', '=', $data['user_id'])->delete();
            }

            if ($roleid) {

                foreach ($roleid as $key => $rid) {
                    $rolearr = [
                        'user_id' => $data['user_id'],
                        'role_id' => $rid,
                        'created_by' => $userlogin,
                        'created_at' => 'NOW()',
                    ];

                    $msg = DB::table('admin_userroles')->insert($rolearr);
                }

                if ($msg) {
                    $success = 1;
                    Log::info('User Roles Assigned Successfully: ' . $msg);
                } else {
                    $success = 0;
                    Log::error('Error in Assigning User Roles: ' . $msg);
                }

            } else {

                $success = 2;
                Log::info('Assigned Roles are Removed: ');

            }
            return json_encode($success);
        }
    }

    public function edit($id)
    {
        $uid = $id;
        $roledata = DB::table('admin_userroles')->where('user_id', '=', $uid)->pluck('role_id');
        return json_encode($roledata);
    }

}
