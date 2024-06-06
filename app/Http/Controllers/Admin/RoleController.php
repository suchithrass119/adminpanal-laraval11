<?php

namespace App\Http\Controllers\Admin;

use DB;
use Session;
use Validator;
use Illuminate\Http\Request;
use App\Models\Admin\RoleModel;
use Elegant\Sanitizer\Sanitizer;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Models\Admin\OfficedetailModel;
use Yajra\DataTables\Facades\DataTables;
use App\Helpers\CommonFunctions;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //Load office name from office table
          $office=DB::table('public.admin_officedetails')->pluck('office_name','office_id')->all();

        if ($request->ajax()) {
            $roles = RoleModel::leftjoin('admin_officedetails', 'admin_roles.office_id', '=', 'admin_officedetails.office_id')
                ->select(['role_id', 'role_name', 'admin_officedetails.office_name', 'admin_roles.updated_at']);
            return DataTables::of($roles)
                ->addColumn('edit_button', function ($role) {
                    return '<a id="' . $role->role_id . '" href="javascript:void(0)" class="edit_but icon_edit" title="Edit">
                      </a>
                       <a id="' . $role->role_id . '" href="javascript:void(0)" class="delete_but icon_delete" title="Delete">
                       </a>';
                })
            //  ->editColumn('created_at', function($data){ return $data->created_at->format('d/m/Y'); })
                // ->editColumn('updated_at', function ($data) {return $data->updated_at->format('d/m/Y H:i:s');})
                ->make();
        }
        $current_path = Route::getFacadeRoot()->current()->uri();
        $prep_class = new CommonFunctions();
        $view_priv = $prep_class->buttonPrivilageFun($request, $current_path, "view");
        if ($view_priv == 1) {

          return view('admin.pages.create_role',compact('office'))->with('page_title', 'Roles');
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
        $userlogin = $request->session()->get('userid');
        $data = [
            'office_id' => $request->officeid,
            'role_name' => $request->rolename,
            'created_by' => $userlogin,
            'updated_by' => $userlogin,
        ];
        $filters = [
            'office_id' => 'trim|escape',
            'role_name' => 'trim|escape|capitalize',
        ];
        $sanitizer = new Sanitizer($data, $filters);
        /////var_dump($sanitizer->sanitize());
        $data = $sanitizer->sanitize();

        $rules = array(
            'office_id' => 'required|numeric|not_in:0',
            'role_name' => 'required|min:2|regex:/^[A-Za-z\s.]+$/|unique:admin_roles,role_name,NULL,id,office_id,' . $data['office_id'],
        );

        $messages = [
            'office_id.numeric' => "Select an Office",
            'role_name.regex' => "Please Enter Only Characters",
        ];
        $validator = Validator::make($data, $rules, $messages);

        if ($validator->fails()) {
            $error_message = $validator->errors()->toArray();
            echo json_encode($error_message);

        } else {

            //...Role save...

            $rolesave = RoleModel::create($data);
            if ($rolesave) {
                $success = 1;
                Log::info('Records Saved Successfully: ' . $rolesave);
            } else {
                $success = 0;
                Log::error('Error in Saving Records: ' . $rolesave);
            }
            echo json_encode($success);
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
        $role_data = \DB::table('admin_roles')
                        ->join('admin_officedetails', 'admin_officedetails.office_id', 'admin_roles.office_id')
                        ->where('role_id', $id)
                        ->get();

                        // dd($role_data);
        if ($request->ajax()) {
            echo json_encode($role_data);
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

        $userlogin = $request->session()->get('userid');

        $role_data = [
            'role_name' => $request->rolename,
            'updated_by' => $userlogin,
        ];

        $filters = [
            'role_name' => 'trim|escape|capitalize',
        ];
        $sanitizer = new Sanitizer($role_data, $filters);
        /////var_dump($sanitizer->sanitize());
        $role_data = $sanitizer->sanitize();

        $rules = array(
            'role_name' => 'required|min:2|regex:/^[A-Za-z\s.]+$/',
        );
        $messages = [
            'role_name.regex' => "Please Enter Only Characters",
        ];

        $validator = Validator::make($role_data, $rules, $messages);
        if ($validator->fails()) {
            $error_message = $validator->errors()->toArray();
            echo json_encode($error_message);

        } else {

            //
            $role_update = RoleModel::find($id);
            $if_exist = RoleModel::where('office_id', '=', $request->officeid)
                ->where('role_name', '=', $role_data['role_name'])
                ->where('role_id', '<>', $id)
                ->first();
            if (is_null($if_exist)) {
                $if_update = $role_update->update($role_data);
            } else {
                $if_update = null;
            }

            if ($if_update) {
                $success = 1;
                Log::info('Records Updated Successfully: ' . $success);
            } else {
                $success = 0;
                Log::error('Error in Updating Records: ' . $success);
            }
            echo json_encode($success);
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
        //

        $roles_data = RoleModel::find($id);
        if ($roles_data->delete()) {
            $success = 1;
            Log::info('Record Deleted Successfully: ' . $id);
        } else {
            $success = 0;
            Log::error('Error in Deleting Records: ' . $id);
        }
        echo $success;
        // echo json_encode($success);
    }
}
