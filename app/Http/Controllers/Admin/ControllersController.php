<?php

namespace App\Http\Controllers\Admin;

use DB;
use Session;
use Validator;
use Illuminate\Http\Request;
use App\Helpers\CommonFunctions;
use Elegant\Sanitizer\Sanitizer;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Admin\ControllerModel;
use Illuminate\Support\Facades\Route;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Admin\ControllersOtherActionModel;

class ControllersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     var $obj,$obj1;
    public function __construct()
    {
      $this->obj=new ControllerModel;
      $this->obj1=new ControllersOtherActionModel;
    }
    public function getGrid()
    {
      $rows = $this->obj->select(['controller_id','controller_name','route_path','route_name']);
        return DataTables::of($rows)
        ->addColumn('action', function($row){
            return '<a id="'.$row['controller_id'].'" href="javascript:void(0)" class="edit_btn icon_edit" title="Edit"></a>
                    <a id="'.$row['controller_id'].'" href="javascript:void(0)" class="del_btn icon_delete" title="Delete"></a>';
                  })
        ->make();
    }
    public function index(Request $request)
    {
		if ($request->ajax()){
			return $this->getGrid();
		}
		$current_path = Route::getFacadeRoot()->current()->uri();
      	$prep_class = new CommonFunctions();
		$view_priv = $prep_class->buttonPrivilageFun($request, $current_path, "view");
		if ($view_priv == 1) {
      		return view('admin.pages.manage_controllers')->with('page_title','Controllers');
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
        //
        $created_by=$request->session()->get('userid');
        $updated_by=$request->session()->get('userid');
        $controller_data=array(
          'controller_name'=>$request->controller_name,
          'route_path'=>$request->route_path,
          'route_name'=>$request->route_name,
          'created_by'=>$created_by,
          'updated_by'=>$updated_by
        );
        $filters = [
          'controller_name' =>  'trim|escape',
          'route_path'      =>  'trim|escape',
          'route_name'      =>  'trim|escape'
        ];
        $sanitizer  = new Sanitizer($controller_data, $filters);
        $controller_data=$sanitizer->sanitize();
        $rules = array(
          'controller_name'       => 'required|min:2|unique:admin_controllers',
          'route_path'      => 'min:2|regex:#d*[A-Za-z/\][a-zA-Z]+[a-zA-Z+]*$#',
          'route_name'      => 'min:2|regex:/^[A-Za-z\][a-zA-Z]+[a-zA-Z+]*$/'
        );
        $validator = Validator::make($controller_data,$rules);
        if ($validator->fails()) {
        $error_message = $validator->errors()->toArray();
        return json_encode($error_message);
        }
        else {
        $status = 0;
        $new_entry=$this->obj->create($controller_data);
        if($new_entry && $request['action1']=='')
          $status=1;

        if($request['action1']!=''){
            $controller_id=$new_entry->controller_id;
            for($i=1;$i<=$request->count;$i++){
            $other_action_data=array(
              'controller_id'=>$controller_id,
              'action_name'=>$request['action'.$i],
              'created_by'=>$created_by,
              'created_at'=>'NOW()'
            );
            $filters = [
              'action_name' =>  'trim|escape'
            ];
            $sanitizer  = new Sanitizer($other_action_data, $filters);
            $other_action_data=$sanitizer->sanitize();
            $rules = array(
              'action_name'      => 'min:2|regex:/^[A-Za-z\s-_.][a-zA-Z]+[a-zA-Z+]*$/'
            );
            $validator = Validator::make($other_action_data,$rules);
            if ($validator->fails()) {
            $error_message = $validator->errors()->toArray();
            return json_encode($error_message);
            }
            else{
            $is_save=$this->obj1->create($other_action_data);
            if($is_save)
              $status=1;
            }
          }
        }
          if($status==1){
            Log::info('Records Saved Successfully to Controllermodel: '.$status);
          }
          else {
          Log::error('Error in Saving Records to Controllermodel: '.$status);
          }
          return json_encode($status);
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
        //DB::enableQueryLog();
        $actions=array();
        $action_name = $this->obj1->select('action_name')
                       ->where('controller_id',$id)->get();
                $action_name = json_decode(json_encode($action_name),True);
                foreach ($action_name as $k => $v){
                  if(!in_array($v['action_name'],$actions))
                     array_push($actions, $v['action_name']);
                }
        //$query = DB::getQueryLog();
        //$lastQuery = end($query);
        //print_r($query);
        echo json_encode($actions);
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
        $controller=$this->obj->select('controller_id','controller_name','route_path','route_name')->where('controller_id',$id)->get();
        $actions=$this->obj1->select('action_name')->where('controller_id',$id)->get();
        $actions = json_decode(json_encode($actions),True);
        $actions1=array();
        foreach($actions as $index=>$value){
          array_push($actions1,$value['action_name']);
        }
        $data=array(
          'controller'=>$controller,
          'actions'=>$actions1
        );
        if (request()->ajax()){
          echo json_encode($data);
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
        //

        $data=$this->obj->find($id);
        $updated_by=$request->session()->get('userid');
        $new_data=array(
          'controller_name'=>$request->controller_name,
          'route_path'=>$request->route_path,
          'route_name'=>$request->route_name,
          'updated_by'=>$updated_by
        );
        $filters = [
          'controller_name' =>  'trim|escape',
          'route_path'      =>  'trim|escape',
          'route_name'      =>  'trim|escape'
        ];
        $sanitizer  = new Sanitizer($new_data, $filters);
        $new_data=$sanitizer->sanitize();
        $rules = array(
          'controller_name'       => 'required|min:2',
          'route_path'      => 'min:2|regex:#d*[A-Za-z/\][a-zA-Z]+[a-zA-Z+]*$#',
          'route_name'      => 'min:2|regex:/^[A-Za-z\][a-zA-Z]+[a-zA-Z+]*$/'
        );
        $validator = Validator::make($new_data,$rules);
        if ($validator->fails()) {
        $error_message = $validator->errors()->toArray();
        return json_encode($error_message);
        }
        else {
        $status=0;
        $is_update=$data->update($new_data);
        if($is_update && $request['action1']=='')
          $status=1;
        if($request['action1']!=''){
          for($i=1;$i<=$request->count;$i++){
            $other_actions=$this->obj1->where('controller_id',$id)->where('action_name',$request['action'.$i]);
            $other_action_data=array(
              'controller_id'=>$id,
              'action_name'=>$request['action'.$i]
            );
            $filters = [
              'action_name' =>  'trim|escape'
            ];
            $sanitizer  = new Sanitizer($other_action_data, $filters);
            $other_action_data=$sanitizer->sanitize();
            $rules = array(
              'controller_id' => 'required|numeric',
              'action_name' => 'required|min:2|regex:/^[A-Za-z\s-_.][a-zA-Z]+[a-zA-Z+]*$/'
            );
            $validator = Validator::make($other_action_data,$rules);
            if ($validator->fails()) {
            $error_message = $validator->errors()->toArray();
            return json_encode($error_message);
            }
            else {
            $is_save=$other_actions->update($other_action_data);
            }
          }
          if($is_save)
            $status=1;
        }

          if($status==1)
          {
              Log::info('Records Updated Successfully to Controllermodel : '.$status);
          }
          else{
            Log::error('Error in Updating Records to Controllermodel : '.$status);
          }
        return json_encode($status);
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
        $success=0;
        $other_actions=$this->obj1->where('controller_id',$id);
        $check1=$other_actions->delete();
        $data=$this->obj->find($id);
        $check2=$data->delete();
        if($check1 || $check2)
          $success=1;
        if($success==1)
        {
            Log::info('Records Deleted Successfully from Controllermodel : '.$success);
        }
        else {
          Log::error('Error in Deleting Records from Controllermodel : '.$success);
          }

        echo $success;
    }
}