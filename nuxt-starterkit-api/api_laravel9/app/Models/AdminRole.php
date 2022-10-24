<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminRole extends Model
{
    protected $table = 'admin_roles';

    const ADMIN_ID = 2;
    const SUPER_ADMIN_ID = 1;

    protected $fillable = [
        'name',
        'label',
    ];

    public function admins()
    {
        return $this->hasMany(Admin::class, 'admin_role_id');
    }
}
