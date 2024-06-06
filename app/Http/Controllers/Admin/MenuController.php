<?php

namespace App\Http\Controllers\Admin;

use Response;
use Illuminate\Http\Request;
use App\Models\Admin\MenuModel;
use App\Helpers\CommonFunctions;
use Elegant\Sanitizer\Sanitizer;
use App\Models\Admin\ModuleModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Admin\ControllerModel;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $module = ModuleModel::pluck('module_name', 'module_id')->all();
        $controller = ControllerModel::pluck('controller_name', 'controller_id')->all();
        $menus="";

        if ($request->ajax()) {
            return $this->getmenuGrid();

        }

        $current_path = Route::getFacadeRoot()->current()->uri();
        $prep_class = new CommonFunctions();
        $view_priv = $prep_class->buttonPrivilageFun($request, $current_path, "view");
        if ($view_priv == 1) {
        return view('admin.pages.add_menu', compact('module', 'controller', 'menus'))->with('page_title', 'Add Menu');
        } else {
            return view('admin.pages.privilage',)->with('page_title', 'No Privilage');
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

        $created_by = Session::get('userid');

        ////echo $created_by;
        $data = [
            'module_id' => $request->module_id,
            'iconclass' => $request->iconclass,
            'default_action_name' => $request->action_name,
            'parent_menu_id' => $request->parent_menu_id,
            'order_of_menu' => $request->menu_order,
            'menu_name' => $request->menu_name,
            'route_path' => $request->route_path,
            'controller_id' => $request->controller_id,
            'created_by' => $created_by,
            'updated_by' => $created_by,
        ];

        $filters = [
            'module_id' => 'trim|escape',
            'default_action_name' => 'trim|escape|lowercase',
            'parent_menu_id' => 'trim|escape',
            'order_of_menu' => 'trim|escape',
            'menu_name' => 'trim|escape',
            'route_path' => 'trim|escape',
            'controller_id' => 'trim|escape',
        ];
        $sanitizer = new Sanitizer($data, $filters);
        /////var_dump($sanitizer->sanitize());
        $data = $sanitizer->sanitize();
        /////print_r($data);
        //echo $data['menu_order'];

        $rules = array(
            'module_id' => 'required|numeric|not_in:0',
            'default_action_name' => 'required|min:2|regex:/^[A-Za-z]+[A-Za-z -_.]+$/i',
            'parent_menu_id' => 'required|numeric',
            'order_of_menu' => 'required|numeric',
            'menu_name' => 'required|min:2|regex:/^[A-Za-z]+[A-Za-z -_.]+$/i',
            /////'route_path'          => 'sometimes|nullable|regex:/^\/[a-z0-9]+[a-zA-Z+]$/i',
            'route_path' => 'sometimes|nullable|regex:#d*\/[A-Za-z]+[a-zA-Z0-9 _/\"]+[a-zA-Z+]*$#',
            'controller_id' => 'required|numeric',
        );
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            $error_message = $validator->errors()->toArray();
            echo json_encode($error_message);
            ////  dd('input required');

        } else {
            /////echo $data['created_at'];

            if ($data['parent_menu_id'] == 0) {
                $data['parent_menu_id'] = null;
            }

            if ($data['controller_id'] == 0) {
                $data['controller_id'] = null;
            }

            if ($data['route_path'] == '') {
                $data['route_path'] = null;
            }

            DB::enableQueryLog();
            ////print_r($data);
            $if_exist = MenuModel::where('menu_name', '=', $data['menu_name'])
                ->where('module_id', '=', $data['module_id'])
                ->where('parent_menu_id', '=', $data['parent_menu_id'])
                ->first();

            if (is_null($if_exist)) {
                $if_saved = MenuModel::create($data);
                $query = DB::getQueryLog();
                $lastQuery = end($query);
                /////print_r($query );
            } else {
                Log::error('Duplicate Entry: ' . $if_exist);
                $if_saved = null;
            }
            if ($if_saved) {
                Log::info('Records Saved Successfully: ' . $if_saved);
                $status = 1;
            } else {
                Log::error('Error in Saving Records: ' . $if_saved);
                $status = 0;
            }
            echo json_encode($status);
        }
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
    public function edit(Request $request, $id)
    {
        $menu_load = MenuModel::find($id);
        if ($request->ajax()) {
            echo json_encode($menu_load);
        }
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

        $created_by = Session::get('userid');

        ////echo $created_by;
        $data = [
            'module_id' => $request->module_id,
            'default_action_name' => $request->action_name,
            'parent_menu_id' => $request->parent_menu_id,
            'order_of_menu' => $request->menu_order,
            'menu_name' => $request->menu_name,
            'route_path' => $request->route_path,
            'controller_id' => $request->controller_id,
            'created_by' => $created_by,
            'updated_by' => $created_by,
            'iconclass' => $request->iconclass,
        ];

        $filters = [
            'module_id' => 'trim|escape',
            'default_action_name' => 'trim|escape|lowercase',
            'parent_menu_id' => 'trim|escape',
            'order_of_menu' => 'trim|escape',
            'menu_name' => 'trim|escape',
            'route_path' => 'trim|escape',
            'controller_id' => 'trim|escape',
        ];
        $sanitizer = new Sanitizer($data, $filters);
        /////var_dump($sanitizer->sanitize());
        $data = $sanitizer->sanitize();
        ////print_r($data);
        //echo $data['menu_order'];

        $rules = array(
            'module_id' => 'required|numeric|not_in:0',
            'default_action_name' => 'required|min:2|regex:/^[A-Za-z]+[A-Za-z -_.]+$/i',
            'parent_menu_id' => 'required|numeric',
            'order_of_menu' => 'required|numeric',
            'menu_name' => 'required|min:2|regex:/^[A-Za-z]+[A-Za-z -_.]+$/i',
            /////'route_path'          => 'sometimes|nullable|regex:/^\/[a-z0-9]+[a-zA-Z+]$/i',
            'route_path' => 'sometimes|nullable|regex:#d*\/[A-Za-z]+[a-zA-Z0-9 _/\"]+[a-zA-Z+]*$#',
            'controller_id' => 'required|numeric',
        );
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            $error_message = $validator->errors()->toArray();
            echo json_encode($error_message);
            ////  dd('input required');

        } else {

            $menu_update = MenuModel::find($id);
            ///////echo $data['controller_id'];
            if ($data['parent_menu_id'] == 0) {
                $data['parent_menu_id'] = null;
            }

            if ($data['controller_id'] == 0) {
                $data['controller_id'] = null;
            }

            if ($data['route_path'] == '') {
                $data['route_path'] = null;
            }

            /////  DB::enableQueryLog();
            //////print_r($data);
            $if_update = $menu_update->update($data);
            ///// $query =  DB::getQueryLog();
            ////$lastQuery = end($query);
            //////print_r($id);

            if ($if_update) {
                $update_status = 1;
                Log::info('Records Updated Successfully: ' . $if_update);
            } else {
                $update_status = 0;
                Log::error('Error in Updating Records: ' . $if_update);
            }
            echo json_encode($update_status);

        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $menu_delete = MenuModel::find($id);
        $if_deleted = $menu_delete->delete();
        if ($if_deleted) {
            $del_status = 1;
            Log::info('Record Deleted Successfully: ' . $id);
        } else {
            $del_status = 0;
            Log::error('Error in Updating Records: ' . $id);
        }
        echo json_encode($del_status);

        //
    }
    public function getmenuGrid()
    {
        $menu_details = MenuModel::join('admin_modules', 'admin_menus.module_id', '=', 'admin_modules.module_id')
            ->leftJoin('admin_controllers', 'admin_controllers.controller_id', '=', 'admin_menus.controller_id')
            ->select(['menu_id', 'admin_modules.module_name', 'menu_name', 'admin_controllers.controller_name', 'default_action_name', 'order_of_menu'])
            ->where('admin_menus.validity_flg', '1');
        ////->get();
        return DataTables::of($menu_details)
            ->addColumn('edit_button', function ($menu_details) {
                return '<a id="' . $menu_details->menu_id . '" href="javascript:void(0)" class="edit_btn icon_edit" title="Edit"></a>
            <a id="' . $menu_details->menu_id . '" href="javascript:void(0)" class="del_btn btn icon_delete" title="Delete"></a>';
            })
            ->filterColumn('controller_name', function ($menu_details, $keyword) {
                $menu_details->havingRaw('controller_name ILIKE ?', ["%{$keyword}%"]);
            })
            ->filterColumn('menu_name', function ($menu_details, $keyword) {
                $menu_details->havingRaw('menu_name ILIKE ?', ["%{$keyword}%"]);
            })
            ->make();

    }
    public function menuajax($module_id)
    {
        $menu = MenuModel::tree($module_id)->toArray();
        // dd($menu);
        return Response::json($menu);
    }

}
