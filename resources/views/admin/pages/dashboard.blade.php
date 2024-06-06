<?php

use App\Helpers\CommonFunctions;
use App\Models\Admin\UserModel;
?>
@extends('admin.layout.master')
@section('content')
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<div class='container-fluid'>
    <h4>DASHBOARD</h4>
    <br>
    <br>
    <br>
  <div class="row" align='center'>
  <div class="col-md-12" align='center'>
   
    <b><font color='red'>
  <?php
    $prep_class=NEW CommonFunctions;

   $user_id = session()->get('userid');
   $user = UserModel::where('user_id', $user_id)
   ->selectRAW("date(created_at) as created_at,pass_change_date")
   ->first();
   $pass_change_date=$user->pass_change_date;
   $created_at=$user->created_at;
   if(!$pass_change_date)
   {
    $pass_change_date=$created_at;
    $pass_change_date=$prep_class->dbto($pass_change_date);
   }
   
   $date = strtotime("+60 day", strtotime($pass_change_date));
   $next90day=date("Y-m-d", $date);
   $curdate=date('Y-m-d');
   if($curdate>$next90day)
   {
      echo "Please change your password. 90 days exceeded.";
   }
   else{
    $next90days=date("d/m/Y", $date);
    echo "Please change your password on or before $next90days";
   }


  ?>
  </font></b>

   </div>
   </div>

</div>
</div>
</div>
@push('pagescripts')
<script type="text/javascript">
</script>
@endpush
@endsection
