<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class ControllerModel extends Model
{
    protected $table="admin_controllers";
    protected $primaryKey = 'controller_id';
    protected $fillable = [
        'route_path', 'route_name','controller_name','created_by','updated_by'];
}
