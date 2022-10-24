<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogActivity extends Model
{
    public $timestamps = false;

    protected $table = 'log_activities';

    protected $fillable = [
        'admin_id',
        'activity',
        'detail',
        'ip',
        'access_time',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
}
