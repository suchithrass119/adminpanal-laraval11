<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    protected $table = 'admin_users';
    protected $primaryKey = 'user_id';
    protected $fillable = ['name',
        'username',
        'password',
        'email_address',
        'mob_number',
        'board_id',
        'office_id',
        'designation_id',
        'usertype',
        'created_by',
        'updated_by',
        'district_id',
        'talukid',
        'blockid', 'delete_flag', 'delete_date', 'delete_user', 'delete_ip','validity_flg','pass_change_date'
    ];

    public function checkAdminUser($email, $pass, $cpass="")
    {
        //$user = UserModel::where('email_address',$email)->orWhere('username',$email)->where('password', $pass)->first(['user_id', 'email_address','usertype','user_status','name']);
        $user = UserModel::where(function ($query) use ($email) {
            $query->where('email_address', '=', $email)
                ->orWhere('username', '=', $email);
        })->where(function ($query) use ($pass, $cpass) {
            if($pass !=$cpass){
                $query->where('password', '=', $pass);
            }
        })->Where('validity_flg', '=', 1)->first(['user_id', 'email_address', 'usertype','office_id', 'user_status', 'name']);

        if ($user) {
            $user = $user->toArray();
        }

        return $user;
    }
    public function adminroles()
    {
        return $this->belongsToMany('App\Models\Admin\RoleModel', 'admin_userroles', 'user_id', 'role_id');
    }
    public function getRoleIdsAttribute()
    {
        return $this->adminroles()->pluck('admin_userroles.role_id')->toArray();
    }

}
