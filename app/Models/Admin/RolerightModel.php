<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class RolerightModel extends Model
{
    protected $table="admin_rolerights";
    protected $fillable = [
        'role_id', 'controller_id'
    ];

}
