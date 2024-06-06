<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class DesignationModel extends Model
{
    //
    protected $table = 'admin_designation';
    protected $primaryKey = 'designation_id';
    protected $fillable = [
        'designation_name'
    ];
}
