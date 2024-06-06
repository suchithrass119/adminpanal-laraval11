<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class UserTypeModel extends Model
{
    //
    protected $table = 'admin_user_type';
    protected $primaryKey = 'user_type_id';
    public $timestamps = false;
    protected $fillable = [
        'user_type_name'
    ];
}
