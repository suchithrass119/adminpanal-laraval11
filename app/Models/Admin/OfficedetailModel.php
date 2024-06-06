<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class OfficedetailModel extends Model
{
    //

    protected $table = 'admin_officedetails';
    protected $primaryKey = 'office_id';
    protected $fillable = [
        'office_name', 'office_type', 'district_id', 'address', 'mob_number', 'email_address', 'office_id','board_id', 'office_short_code','postoffice','place',
        'pincode', 'delete_flag', 'delete_date', 'delete_user',
        'delete_ip', 'approve_flag', 'approve_date', 'approve_user', 'approve_ip','last_fdint_posted_date','fdtosbint_approve_flg',
        'lastsbintdate','branch_code','office_fullname','validity_flg'
    ];
    public function officetype()
    {
        return $this->belongsTo('App\AdminOfficeType', 'office_type', 'office_type_id');
    }

}
