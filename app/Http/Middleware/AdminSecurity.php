<?php

namespace App\Http\Middleware;

use App\Helpers\SecurityHelper;
use App\Models\Admin\MenuModel;
use Closure;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Request;
use URL;

class AdminSecurity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permissions = null)
    {
        $host_aaddr = $_SERVER['SERVER_NAME'];
        $host = new SecurityHelper();
        $function_reslt = $host->hostheader_validate($host_aaddr);

        if ($function_reslt == 0) {
            abort(505);
        }

        $req_count = count($request->all());
        $input = $request->all();
        if ($req_count > 1) {
            array_walk_recursive($input, function (&$input) {
                $xss_replace = new SecurityHelper();
                $input = $xss_replace->xss_strip($input);
            });
            $request->merge($input);
        }

        $data = $request->session()->all();
        if ( (($request->session()->get('user_type') == '2') || ($request->session()->get('user_type') == '1') || ($request->session()->get('user_type') == '3') || ($request->session()->get('user_type') == '4')) &&
              ($request->session()->exists('userid')) && ($data['admin_portal_active'] == 1)  ) {
            // if (mt_rand(1, 100) == 50) {
            //     $request->session()->regenerate();
            // }

            $root = Request::root();
            $current_path = Route::getFacadeRoot()->current()->uri();
            $current_action = Route::getFacadeRoot()->current()->getAction();
            $current_action = json_decode(json_encode($current_action), true);
            // dd($current_action);

            if (isset($current_action['as'])  ) {
                $resource = explode('.', $current_action['as']);
                $resourcename = $resource[0];
                $resourceaction = $resource[1];
            

                if (substr($current_action['prefix'], -1) != '/') {
                    $current_action['prefix'] = $current_action['prefix'] . '/';
                }

                $current = $current_action['prefix'] . $resourcename;
                // DB::enableQueryLog();
                $controller_id = MenuModel::where('route_path', '/' . $current)->value('controller_id');
                //$query = DB::getQueryLog();
                //   $lastQuery = end($query);
                //   print_r($query);exit;

                if ($controller_id != '') {
                    $result = app('App\Http\Controllers\Admin\SecurityController')->get_rights_given_controller($controller_id);
                    $result = json_decode($result, true);
                    if ($result['status'] == 'true' || $result['status'] == 'false') {
                        $right_arr = $result['actions'];
                        switch ($resourceaction) {
                            case 'create':$permission_access = app('App\Http\Controllers\Admin\SecurityController')->get_controller_right($controller_id, 'insert');
                                break;
                            case 'store':$permission_access = app('App\Http\Controllers\Admin\SecurityController')->get_controller_right($controller_id, 'insert');
                                break;
                            case 'edit':$permission_access = app('App\Http\Controllers\Admin\SecurityController')->get_controller_right($controller_id, 'view');
                                break;
                            case 'show':$permission_access = app('App\Http\Controllers\Admin\SecurityController')->get_controller_right($controller_id, 'view');
                                break;
                            case 'destroy':$permission_access = app('App\Http\Controllers\Admin\SecurityController')->get_controller_right($controller_id, 'delete');
                                break;
                            default:$permission_access = app('App\Http\Controllers\Admin\SecurityController')->get_controller_right($controller_id, $resourceaction);
                                break;
                        }
                        if ($permission_access == 1) {
                            return $next($request);
                        } else {
                            if (request()->ajax()) {
                                echo json_encode(array('message' => 'Permission Denied'));exit;
                            } else {
                                return redirect('/admin/adminerror')->with('warning', 'Permission Denied');
                            }
                        }
                    } else {
                        return redirect('/admin/adminerror')->with('warning', $result['message']);
                    }
                } else {
                    //links other than menus
                    $link_arr = array();
                    if ($root == URL::to('')) {
                        array_push($link_arr, $current_path);
                    }
                    if (in_array($current_path, $link_arr)) {
                        return $next($request);
                    }
                }
            } else {
                //custom defined functions
                $link_arr = array();
                if ($root == URL::to('')) {
                    array_push($link_arr, $current_path);
                }
                if (in_array($current_path, $link_arr)) {
                    return $next($request);
                }
            }
        } else {
            // dd("Ads");
            return redirect('/admin/logout');
            //$request->session()->regenerate();
        }
    }
}
