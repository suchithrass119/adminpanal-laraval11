<?php

namespace App\Http\Controllers\Admin;

use DB;
use Illuminate\Http\Request;
use App\Models\Admin\RoleModel;
use App\Models\Admin\ModuleModel;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Admin\RolerightModel;
use Illuminate\Support\Facades\Route;
use App\Models\Admin\ControllersOtherActionModel;
use App\Helpers\CommonFunctions;

class RolerightController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $roles = RoleModel::pluck('role_name', 'role_id')->all();
        $modules = ModuleModel::pluck('module_name', 'module_id')->all();

        //  $controllersotheractions = ControllersOtherActionModel::pluck('controller_name','controller_id')->all();
        if (request()->ajax()) {
            $role_id = $request->role_id;
            $module_id = $request->module_id;

            DB::enableQueryLog();
            if ($module_id == 0) {

                $controllers = DB::table('admin_menus')->whereNotNull('controller_id')
                    ->select('admin_menus.controller_id')
                    ->distinct()->get();
                $controllers = json_decode(json_encode($controllers), true);
                //$controller_arr=[];
                foreach ($controllers as $controllerid) {
                    $controller_arr[] = $controllerid['controller_id'];

                }
                //
                $menus = DB::table('admin_controllers')
                    ->select('admin_controllers.controller_id', 'admin_controllers.controller_name')
                    ->where('admin_controllers.validity_flg', '=', 1)
                    ->whereNotIn('controller_id', $controller_arr)
                    ->get();
                $menus = json_decode(json_encode($menus), true);
                for ($h = 0; $h < count($menus); $h++) {
                    $menus[$h]['menu_id'] = 'C_' . $menus[$h]['controller_id'];
                    $menus[$h]['menu_name'] = '-NA-';
                }

            } else {
                /*$menus = MenuModel::select('menu_name','menu_id','controller_id')
                ->where('module_id','=',$module_id)
                ->where('controller_id','<>',null)
                ->where('validity_flg','=',1)
                ->get();*/
                $menus = DB::table('admin_menus')
                    ->join('admin_controllers', 'admin_menus.controller_id', '=', 'admin_controllers.controller_id')
                    ->select('admin_menus.menu_name', 'admin_menus.menu_id', 'admin_controllers.controller_id', 'admin_controllers.controller_name')
                    ->where('admin_menus.validity_flg', '=', 1)
                    ->where('admin_menus.module_id', '=', $module_id)
                    ->orderbyRaw('parent_menu_id desc')
                    ->get();
                /*$query =  DB::getQueryLog();
                print_r($query);
                exit;*/
                //$i=$menus->count();
                $menus = json_decode(json_encode($menus), true);

            }
            foreach ($menus as $index => $value) {
                //  echo $menus[$k]['controller_id'];
                $checked = $this->get_rights_given_controller($value['controller_id'], $role_id);
                $otheractions = ControllersOtherActionModel::select('action_name', 'controller_action_id')
                    ->where('controller_id', '=', $value['controller_id'])
                    ->get();
                //    $menus[$index]['otheractions']=json_decode(json_encode($otheractions),True);
                $menus[$index]['otheractions'] = json_decode(json_encode($otheractions), true);
                if ($checked != '') {

                    if (in_array('insert', $checked)) {
                        $menus[$index]['default']['insert'] = 1;
                    } else {
                        $menus[$index]['default']['insert'] = 0;
                    }

                    if (in_array('update', $checked)) {
                        $menus[$index]['default']['update'] = 1;
                    } else {
                        $menus[$index]['default']['update'] = 0;
                    }
                    if (in_array('delete', $checked)) {
                        $menus[$index]['default']['delete'] = 1;
                    } else {
                        $menus[$index]['default']['delete'] = 0;
                    }
                    if (in_array('view', $checked)) {
                        $menus[$index]['default']['view'] = 1;
                    } else {
                        $menus[$index]['default']['view'] = 0;
                    }
                    if (in_array('index', $checked)) {
                        $menus[$index]['default']['index'] = 1;
                    } else {
                        $menus[$index]['default']['index'] = 0;
                    }
                    if (in_array('verify', $checked)) {
                        $menus[$index]['default']['verify'] = 1;
                    } else {
                        $menus[$index]['default']['verify'] = 0;
                    }
                    if (in_array('approve', $checked)) {
                        $menus[$index]['default']['approve'] = 1;
                    } else {
                        $menus[$index]['default']['approve'] = 0;
                    }

//print_r($checked);
                    //print_r($menus[$index]['otheractions']);
                    foreach ($menus[$index]['otheractions'] as $i => $value) {

                        if (in_array($value['action_name'], $checked)) {
                            $menus[$index]['otheractions'][$i]['status'] = 1;
                        } else {
                            $menus[$index]['otheractions'][$i]['status'] = 0;

                        }

                    }

                } else {
                    $menus[$index]['default']['insert'] = 0;
                    $menus[$index]['default']['update'] = 0;
                    $menus[$index]['default']['delete'] = 0;
                    $menus[$index]['default']['view'] = 0;
                    $menus[$index]['default']['index'] = 0;
                    $menus[$index]['default']['verify'] = 0;
                    $menus[$index]['default']['approve'] = 0;
                    foreach ($menus[$index]['otheractions'] as $i => $value) {
                        $menus[$index]['otheractions'][$i]['status'] = 0;
                    }
                }
            }

//print_r($menus);exit;
            return $menus;

        }

        $current_path = Route::getFacadeRoot()->current()->uri();
        $prep_class = new CommonFunctions();
        $view_priv = $prep_class->buttonPrivilageFun($request, $current_path, "view");
        if ($view_priv == 1) {
            return view('admin.pages.add_roleright', compact('roles', 'modules'))->with('page_title', 'Role Rights');
        } else {
            return view('admin.pages.privilage')->with('page_title', 'No Privilage');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $role_id = $request->rolerightdata['role_id'];
        $menu_id = $request->rolerightdata['menu_id'];
        $controller_id = $request->rolerightdata['controller_id'];
        $defaultid = $request->rolerightdata['defaultid'];
        $checked_otherid = $request->rolerightdata['checked_otherid'];

        $Isroleright_defexist = DB::table('admin_rolerights')
            ->where('role_id', '=', $role_id)
            ->where('controller_id', '=', $controller_id)
            ->pluck('role_id', 'controller_id')->all();

        $Isroleright_othexist = DB::table('admin_rolerights_other_actions')
            ->pluck('role_id')->all();
        $createdby = $request->session()->get('userid');

        if ($Isroleright_othexist) {
            DB::enableQueryLog();
            $controller_act_id = DB::table('admin_controllers_otheractions')
                ->where('controller_id', '=', $controller_id)
                ->pluck('controller_action_id');
            $controller_act_id = json_decode(json_encode($controller_act_id), true);
            foreach ($controller_act_id as $value) {
                $deleted = DB::table('admin_rolerights_other_actions')
                    ->where('role_id', '=', $role_id)
                    ->where('controller_action_id', '=', $value)
                    ->delete();
                /*  $query =  DB::getQueryLog();
            print_r($query);*/
            }
            if ($checked_otherid != '') {
                foreach ($checked_otherid as $controller_action_id) {
                    $roleright_oarray = array('role_id' => $role_id, 'controller_action_id' => $controller_action_id, 'created_by' => $createdby, 'created_at' => 'NOW()');
                    $othaction = DB::table('admin_rolerights_other_actions')->insert($roleright_oarray);
                    if ($othaction) {
                        $msg = 1;
                        Log::info('Other actions Saved Successfully: ' . $msg);
                    } else {
                        $msg = 0;
                        Log::error('Error in Saving Other actions: ' . $msg);
                    }

                }
            }

        }

        if ($Isroleright_defexist) {
            if ($defaultid[0] == 0 && $defaultid[1] == 0 && $defaultid[2] == 0 && $defaultid[3] == 0 && $defaultid[4] == 0 && $defaultid[5] == 0 && $defaultid[6] == 0) {
                $defaction = DB::table('admin_rolerights')
                    ->where('role_id', '=', $role_id)
                    ->where('controller_id', '=', $controller_id)->delete();
            } else {
                $roleright_darray = array('insert_flg' => $defaultid[0], 'update_flg' => $defaultid[1], 'delete_flg' => $defaultid[2], 'view_flg' => $defaultid[3], 'index_flg' => $defaultid[4], 'verify_flg' => $defaultid[5], 'approve_flg' => $defaultid[6]);
                $defaction = DB::table('admin_rolerights')
                    ->where('role_id', '=', $role_id)
                    ->where('controller_id', '=', $controller_id)
                    ->update($roleright_darray);
            }

        } else {
            if ($defaultid[0] == 0 && $defaultid[1] == 0 && $defaultid[2] == 0 && $defaultid[3] == 0 && $defaultid[4] == 0 && $defaultid[5] == 0 && $defaultid[6] == 0) {
                $defaction = DB::table('admin_rolerights')
                    ->where('role_id', '=', $role_id)
                    ->where('controller_id', '=', $controller_id)->delete();
            } else {
                $roleright_darray = array('role_id' => $role_id, 'controller_id' => $controller_id, 'insert_flg' => $defaultid[0], 'update_flg' => $defaultid[1], 'delete_flg' => $defaultid[2], 'view_flg' => $defaultid[3], 'index_flg' => $defaultid[4], 'verify_flg' => $defaultid[5], 'approve_flg' => $defaultid[6]);
                $defaction = DB::table('admin_rolerights')->insert($roleright_darray);
            }
        }
        if ($defaction) {
            if ($msg = 1) {
                $success = 1;
                Log::info('Default actions Saved Successfully: ' . $success);
            } else {
                $success = 0;
                Log::error('Error in Saving Default actions: ' . $success);
            }

        } else {
            $success = 0;
            Log::error('Error in Saving Default actions: ' . $success);
        }
        echo json_encode($success);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function get_rights_given_controller($controller_id, $role_id)
    {
        $actions = array();
        if ($controller_id != '') {
            $userRights = RolerightModel::where(array('controller_id' => $controller_id, 'role_id' => $role_id))->first();

            if(isset($userRights))
            {

                if ($userRights['insert_flg'] == 1) {
                    array_push($actions, 'insert');
                }

                if ($userRights['update_flg'] == 1) {
                    array_push($actions, 'update');
                }

                if ($userRights['delete_flg'] == 1) {
                    array_push($actions, 'delete');
                }

                if ($userRights['view_flg'] == 1) {
                    array_push($actions, 'view');
                }

                if ($userRights['index_flg'] == 1) {
                    array_push($actions, 'index');
                }

                if ($userRights['verify_flg'] == 1) {
                    array_push($actions, 'verify');
                }

                if ($userRights['approve_flg'] == 1) {
                    array_push($actions, 'approve');
                }
            }

            $action_name = DB::table('admin_controllers_otheractions as ACO')
                ->join('admin_rolerights_other_actions as AROA', 'AROA.controller_action_id', '=', 'ACO.controller_action_id')
                ->where('ACO.controller_id', '=', $controller_id)
                ->where('AROA.role_id', '=', $role_id)
                ->select('ACO.action_name')->get();
            $action_name = json_decode(json_encode($action_name), true);
            foreach ($action_name as $k => $v) {
                if (!in_array($v['action_name'], $actions)) {
                    array_push($actions, $v['action_name']);
                }

            }
            if (count($actions) > 0) {
                return $actions;
            }

                //print_r($actions);

        }

    }

}
