<?php

namespace App\Http\Controllers\Admin;

use Validator;
use Illuminate\Http\Request;
use Elegant\Sanitizer\Sanitizer;
use App\Models\Admin\ModuleModel;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Yajra\DataTables\Facades\DataTables;
use App\Helpers\CommonFunctions;

class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (request()->ajax()) {
            $module_details = ModuleModel::select(['module_id', 'module_name', 'module_description', 'module_order', 'module_icon']);
            return DataTables::of($module_details)
                ->addColumn('edit_button', function ($module_details) {
                    return '<a id="' . $module_details->module_id . '" href="javascript:void(0)" class="edit_btn icon_edit" title="Edit"></a>
                    <a id="' . $module_details->module_id . '" href="javascript:void(0)" class="del_btn icon_delete" title="Delete"></a>';
                })
                ->make();
        }
        $current_path = Route::getFacadeRoot()->current()->uri();
        $prep_class = new CommonFunctions();
        $view_priv = $prep_class->buttonPrivilageFun($request, $current_path, "view");
        if ($view_priv == 1) {
        return view('admin.pages.add_modules')->with('page_title', 'Add Modules');
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

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data = [
            'module_name' => $request->module_name,
            'module_description' => $request->module_description,
            'module_order' => $request->module_order,
            'module_icon' => $request->module_icon,
            'module_dashboard' => $request->dashboard,
        ];

        $filters = [
            'module_name' => 'trim|escape|capitalize',
            'module_description' => 'trim|escape|capitalize',
            'module_order' => 'trim|escape',
            'module_icon' => 'trim|escape',
            'module_dashboard' => 'trim|escape',
        ];
        $sanitizer = new Sanitizer($data, $filters);
        /////var_dump($sanitizer->sanitize());
        $data = $sanitizer->sanitize();

        //==================================================

        $rules = array(
            'module_name' => 'required|min:2|regex:#d*[A-Za-z/\][a-zA-Z]+[a-zA-Z+]*$#',
            'module_description' => 'required|min:2|regex:#d*[A-Za-z/\][a-zA-Z]+[a-zA-Z+]*$#',
            'module_order' => 'required|numeric',
            'module_icon' => 'required|min:2|regex:#d*[A-Za-z/\][a-zA-Z]+[a-zA-Z+]*$#',
            'module_dashboard' => 'sometimes|nullable|regex:#d*[A-Za-z/\][a-zA-Z]+[a-zA-Z+]*$#',
        );
        //print_r($rules);exit;
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) { //echo "hi";
            $error_message = $validator->errors()->toArray();
            echo json_encode($error_message);
            //   return redirect('admin/add_module')
            //     ->withErrors($validator);
        } else { //echo "hihihihihi";
            /*$mod_name=$request->module_name;
            $mod_description=$request->module_description;
            $mod_order=$request->module_order;
            $mod_icon=$request->module_icon;
            //======================
            $moduledetails=array('module_name'=>$mod_name,'module_description'=>$mod_description,
            'module_order'=>$mod_order,'module_icon'=>$mod_icon);*/
            $if_exist = ModuleModel::where('module_name', '=', $data['module_name'])
                ->where('module_order', '=', $data['module_order'])
                ->first();
            if (is_null($if_exist)) {
                $if_saved = ModuleModel::create($data);
            } else {
                Log::error('Duplicate Entry: ' . $if_saved);
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
            /////////Session::flash('message', 'Successfully created office!');
            ///////echo json_encode(array($data));
            ///////return redirect('homeresource');
            /////}
            //////     echo json_encode(array($data));
        }
        //====================================
        //$modules_data=$request->all();
        // ModuleModel::create($modules_data);
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
        $module_edit = ModuleModel::find($id);

        if ($request->ajax()) {
            echo json_encode($module_edit);
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

        $data = [
            'module_name' => $request->module_name,
            'module_description' => $request->module_description,
            'module_order' => $request->module_order,
            'module_icon' => $request->module_icon,
            'module_dashboard' => $request->dashboard,
        ];

        $filters = [
            'module_name' => 'trim|escape|capitalize',
            'module_description' => 'trim|escape|capitalize',
            'module_order' => 'trim|escape',
            'module_icon' => 'trim|escape',
            'module_dashboard' => 'trim|escape',
        ];
        $sanitizer = new Sanitizer($data, $filters);
        /////var_dump($sanitizer->sanitize());
        $data = $sanitizer->sanitize();
        $rules = array(
            'module_name' => 'required|min:2|regex:#d*[A-Za-z/\][a-zA-Z]+[a-zA-Z+]*$#',
            'module_description' => 'required|min:2|regex:#d*[A-Za-z/\][a-zA-Z]+[a-zA-Z+]*$#',
            'module_order' => 'required|numeric',
            'module_icon' => 'required|min:2|regex:#d*[A-Za-z/\][a-zA-Z]+[a-zA-Z+]*$#',
            'module_dashboard' => 'sometimes|nullable|regex:#d*[A-Za-z/\][a-zA-Z]+[a-zA-Z+]*$#',
        );
        //print_r($rules);exit;
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            $error_message = $validator->errors()->toArray();
            echo json_encode($error_message);
            ///////////  dd('input required');
            ////return redirect('admin/add_office')
            /////->withErrors($validator);

        } else {
            $module_update = ModuleModel::find($id);
            $if_update = $module_update->update($data);
//==================================================
            /*  $module_update=ModuleModel::find($id);
            $mod_name=$request->module_name;
            $mod_description=$request->module_description;
            $mod_order=$request->module_order;
            $mod_icon=$request->module_icon;
            $moduledetails=array('module_name'=>$mod_name,'module_description'=>$mod_description,
            'module_order'=>$mod_order,'module_icon'=>$mod_icon);
            $if_update=$module_update->update($moduledetails);*/

            if ($if_update) {
                Log::info('Records Updated Successfully: ' . $if_update);
                $update_status = 1;
            } else {
                Log::error('Error in Updating Records: ' . $if_update);
                $update_status = 0;
            }
            echo json_encode($update_status);

            //=============================================
            /*  $module_update=ModuleModel::find($id);
        $module_data=$request->all();
        $module_update->update($module_data);
        echo json_encode("success");*/
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
        $module_data = ModuleModel::find($id);
        $if_deleted = $module_data->delete();
        if ($if_deleted) {
            $del_status = 1;
            Log::info('Record Deleted Successfully: ' . $id);
        } else {
            $del_status = 0;
            Log::error('Error in Deleting Records: ' . $id);
        }
    }
}
