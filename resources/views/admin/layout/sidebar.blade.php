<aside class="main-sidebar elevation-4 sidebar-light-purple">
    <a href="{{URL::to('/')}}" class="brand-link bg-purple">
        <span class="brand-text font-weight-light" style='color:white'>Motor Welfare</span>
    </a>
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{asset('img/user.png')}}" class="img" alt="User Image">
            </div>
            <div class="info">
                <h5 href="#" class="d-block text-dark">{{ ucfirst(Session::get('user_name'))}}</h5>
                <h6 href="#" class="d-block text-dark">{{ ucfirst(Session::get('office_type_name'))}}</h6>
            </div>
        </div>
        <nav class="mt-2 menuDiv">
            <?php
                $module_id = Session::get("default_module");
                Session::put('default_module', $module_id);
                $menus = App\Models\Admin\MenuModel::tree($module_id)->toArray();
                //print_r($menus );
                $module_name = DB::table('admin_modules')->where('module_id', $module_id)->value('module_name');
                $module_dashboard = DB::table('admin_modules')->where('module_id', $module_id)->value('module_dashboard');

                $html = '';
                if ($module_name != '') {
                    $html = '<ul class="nav nav-pills nav-sidebar flex-column text-sm" data-widget="treeview" role="menu" data-accordion="false">';
                    $html .= ' <li class="nav-header"><p class=" ml-2 h4">' . $module_name . '</p></li>';
                }
                $SecurityController = new App\Http\Controllers\Admin\SecurityController();
                $currnt_url=$_SERVER['REQUEST_URI'];
                $expld=explode('index.php',$currnt_url);
                $currnt_path=$expld[1];
                $expldsss=explode('?',$currnt_path);
                if(count($expldsss)>0){$currnt_path=$expldsss[0];}

                foreach ($menus as $key => $menu) {
                    

                    if (count($menu['children']) > 0) {

                        $menu_id_foract=$menu['menu_id'];
                       
                        
                        $route_pathnew = App\Models\Admin\MenuModel::select(['route_path']) 
                        ->where('route_path', $currnt_path)
                        ->whereIn('parent_menu_id',
                            App\Models\Admin\MenuModel::select(['menu_id'])
                            ->where('route_path', '=', null)
                            ->where('parent_menu_id', $menu_id_foract)
                        )
                        ->value('route_path');

                        $route_path = App\Models\Admin\MenuModel::select(['route_path'])
                        ->where('route_path', $currnt_path)
                        ->where('parent_menu_id', $menu_id_foract)
                        ->value('route_path');

                        // echo "$route_pathnew == $currnt_path";
                        
                        
                        
                        $actv_main="";$menu_open="";
                        if((isset($route_path) &&  ($route_path==$currnt_path)) || (isset($route_pathnew) &&  ($route_pathnew== $currnt_path)) )
                        {
                            $actv_main="active";$menu_open="menu-open";
                        }

                        $iconclass=$menu['iconclass'];
                        
                       
                        // dd( $menu['children']);
                        $rightflag=0;

                        foreach ($menu['children'] as $child) {

                            if (count($child['children']) > 0) {
                        
                                $menu_id_foract = $child['menu_id'];
                        
                              
                                foreach ($child['children'] as $childsec) {
                                    // print_r($child['children']);
                                    $actv = "";
                                   
                                    if ($SecurityController->has_right($childsec) || Session::get('user_type') == 2) {
                                        $rightflag=1;
                                        break;
                                    }
                                }
                                
                        
                            }
                            else{
                        
                                // print_r($child);
                              
                                if ($SecurityController->has_right($child) || Session::get('user_type') == 2) {
                                    $rightflag=1;
                                    break;
                                }
                            }
                        
                        }

                        if($rightflag==1)
                        {
                            $html .= '<li id="menu_'.$menu['menu_id'].'" class="nav-item has-treeview '.$menu_open.'">';
                            $html .= '<a href="#" class="nav-link '.$actv_main.' font-weight-bold"><i class="nav-icon '.$iconclass.'"></i><p>' . $menu['menu_name'] . '</p> <i class="right fas fa-angle-left"></i></a>';
                            $html .= '<ul  class="nav nav-treeview" id="myTab">';
                            foreach ($menu['children'] as $child) {

                                if (count($child['children']) > 0) {

                                    $menu_id_foract = $child['menu_id'];

                                    $route_path2 = App\Models\Admin\MenuModel::select(['route_path'])
                                    ->where('route_path', $currnt_path)
                                    ->where('parent_menu_id', $menu_id_foract)
                                    ->value('route_path');
                                    $actv_main = "";
                                    $menu_open = "";
                                    if (isset($route_path2) && $route_path2 == $currnt_path) {
                                        $actv_main = "active";
                                        $menu_open = "menu-open";
                                    }
                                    $iconclass=$child['iconclass'];

                                    // echo $child['menu_name'];
                                    $html .= '<li id="menu_'.$child['menu_id'].'" class="nav-item has-treeview ' . $menu_open . '">';
                                    $html .= '<a href="#" class="nav-link ' . $actv_main . ' font-weight-bold"><i class="nav-icon '.$iconclass.'"></i><p>' . $child['menu_name'] . '</p> <i class="right fas fa-angle-left"></i></a>';
                                    $html .= '<ul  class="nav nav-treeview" id="myTab">';
                                    foreach ($child['children'] as $childsec) {
                                    // print_r($child['children']);
                                        $actv = "";
                                        if ($currnt_path == $childsec['route_path']) {
                                            $actv = "active";
                                            Session::put('current_menuid', $childsec['menu_id']);
                                        }
                                        if ($SecurityController->has_right($childsec) || Session::get('user_type') == 2) {
                                            if (isset($childsec['children']) && count($childsec['children']) > 0) {
                                                $html .= $SecurityController->render_menu1($childsec);
                                            } else {
                                                
                                                $html .= '<li id="menu_'.$childsec['menu_id'].'" class="nav-item">';
                                                $html .= '<a href="' . URL::to($childsec['route_path']) . '" class="nav-link ' . $actv . '">';
                                                $html .= '<i class="far fa-circle nav-icon"></i>';
                                                $html .= '<p>' . $childsec['menu_name'] . '</p> </a>';
                                                $html .= '</li>';
                                            }
                                        }
                                    }
                                    $html .= "</li>";
                                    $html .= '</ul>';

                                }
                                else{

                                    // print_r($child);
                                    $actv="";
                                    if($currnt_path==$child['route_path'])
                                    {
                                        $actv="active";
                                        Session::put('current_menuid', $child['menu_id']);
                                    }
                                    if ($SecurityController->has_right($child) || Session::get('user_type') == 2) {
                                        if (isset($child['children']) && count($child['children']) > 0) {
                                            $html .= $SecurityController->render_menu1($child);
                                        } else {
                                            
                                            $html .= '<li id="menu_'.$child['menu_id'].'"  class="nav-item">';
                                            $html .= '<a href="' . URL::to($child['route_path']) . '" class="nav-link '.$actv.'">';
                                            $html .= '<i class="far fa-circle nav-icon"></i>';
                                            $html .= '<p>' . $child['menu_name'] . '</p> </a>';
                                            $html .= '</li>';
                                        }
                                    }
                                }




                            }
                        }
                        
                        $html .= "</li>";
                        $html .= '</ul>';
                    } else {

                      if($SecurityController->has_right($menu)){
                        $test=$SecurityController->has_right($menu);
                        if($test==true)
                        {
                            $iconclass = $menu['iconclass'];
                            $html .= '<li  id="menu_'.$menu['menu_id'].'"  class="nav-item has-treeview">';
                            $html .= '<a href="' . URL::to($menu['route_path']) . ' " class="nav-link font-weight-bold"><i class="nav-icon '.$iconclass.'"></i><p>' . $menu['menu_name'] . '</p> </a>';
                       }
                      }

                    }
                }
                echo($html);
                ?>
        </nav>
    </div>
</aside>