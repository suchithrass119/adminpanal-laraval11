<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class ControllersOtherActionModel extends Model
{
    protected $table="admin_controllers_otheractions";
    protected $primaryKey = 'controller_action_id';
    public $timestamps=false;
    protected $fillable = [
        'controller_id','action_name','created_by','created_at'];
}
