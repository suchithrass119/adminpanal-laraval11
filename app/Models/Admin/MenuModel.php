<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class MenuModel extends Model
{
    protected $table = "admin_menus";
    protected $primaryKey = "menu_id";
    protected $fillable = ['module_id', 'controller_id', 'parent_menu_id', 'menu_name',
        'default_action_name', 'order_of_menu', 'route_path', 'created_at',
        'updated_at', 'created_by', 'updated_by','iconclass'];
    public function parent()
    {
        return $this->hasOne('App\Models\Admin\MenuModel', 'menu_id', 'parent_menu_id');
    }

    public function children()
    {
        return $this->hasMany('App\Models\Admin\MenuModel', 'parent_menu_id', 'menu_id')
            ->where('validity_flg', '1')
            ->where('default_action_name','!=','no-view-menu')
            ->orderBy('order_of_menu');
    }

    public static function tree($module_id)
    {
        return static::with(implode('.', array_fill(0, 4, 'children')))
            ->where('parent_menu_id', '=', null)
            ->where('module_id', '=', $module_id)
            ->where('validity_flg', '1')
            // ->where('default_action_name','!=','no-view-menu')
            ->orderBy('order_of_menu')
            ->get();
    }

   

}
