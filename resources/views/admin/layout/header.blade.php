
<?php
$base_url = asset('/');
$load_url = $base_url . '/img/loader.gif';
?>
<div id="loading" align="center" style=" 
    width: 100%;
    height: 100%;
    top: 0px;
    left: 0px;
    position: fixed;
    display: none;
    opacity: 0.7;
    background-color: #fff;
    z-index: 100;
    text-align: center;">
    <p align="center" style="font-size: large; top:500px; left:30px;">
        <img align="" src="{{$load_url}}" width="10%" height="10%" style="position: absolute;top:350px;margin-left: auto;margin-right: auto;">
    </p>
</div>
<!-- <header class="main-header"> -->
<nav class="main-header navbar navbar-expand navbar-light bg-purple ">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ URL::to('/') }}" class="nav-link font-weight-light text-light">Motor Welfare</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            
            <?php 
            $userid =  Session::get('userid');
            if(in_array($userid, [1])){

                echo "<select class='form-control' onchange='switch_office()' id='switch_office' >";
                $office_details = App\Models\Admin\OfficedetailModel::where('validity_flg',1)->select('office_name','office_id')->orderBy('office_id','asc')->get();
                foreach($office_details as $office){
                    $office_id =  Session::get('office_id');
                    if($office->office_id == $office_id) $selstr = "selected";
                    else $selstr = "";
                    echo "<option value='".$office->office_id."' $selstr> $office->office_name</option>";
                }
                echo "</select>";
            }
            ?>
            
        </li>
    </ul>
    <ul class="navbar-nav ml-auto">
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link font-weight-light text-light" data-toggle="dropdown" href="#" aria-expanded="false">
                        Modules
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
                        @php $modules = Session::get('modules');
                        @endphp
                        @if(isset($modules)&&count($modules))
                        @foreach ($modules as $module)

                        <a href="javascript:void(0)" data-id='{{$module['module_id']}}' class="dropdown-item menuSelect">
                            <i class="{{$module['module_icon']}}"></i>&nbsp &nbsp
                            {{$module['module_name']}}
                        </a>
                        <div class="dropdown-divider"></div>
                        @endforeach
                        @endif
                    </div>
                </li>

                <li class="nav-item dropdown show">
                    <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="true">
                        <i class="far fa-user"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px; width: max-content">
                        <a href="#" class="dropdown-item">
                            <div class="">
                                <div class="text-center">
                                    <i class="fa fa-user fa-4x"></i>
                                </div>
                                <div class="text-center m-4">
                                    <h3 class="dropdown-item-title">
                                        {{ ucfirst(Session::get('user_name'))}}
                                    </h3>
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-divider"></div>
                        <div class="row justify-content-center">
                            <div class="col-md-6 dropdown-footer">
                                <a href="javascript:void(0);" data-toggle="modal" data-target="#profileModal" id="view_profile" class="btn btn-primary btn-sm">View Profile </a>
                            </div>
                            <div class="col-md-6 dropdown-footer">
                                <a href="{{URL::to('admin/logout')}}" class="btn btn-danger btn-sm">Sign out</a>
                            </div>
                        </div>
                    </div>
                </li>

            </ul>
        </div>
    </ul>
</nav>
<!-- </header> -->