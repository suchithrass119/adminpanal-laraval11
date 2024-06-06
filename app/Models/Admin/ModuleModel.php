<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class ModuleModel extends Model
{
  protected $table = 'admin_modules';
  protected $primaryKey = 'module_id';
  protected $fillable = [
      'module_name', 'module_description', 'module_order','module_icon','module_dashboard'
  ];
}
