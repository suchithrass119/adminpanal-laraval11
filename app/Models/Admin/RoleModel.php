<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class RoleModel extends Model
{
    protected $table="admin_roles";
    protected $primaryKey="role_id";
    protected $fillable = [
        'role_name', 'board_id', 'office_id','created_by','updated_by'
    ];

}
