<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordManage extends Model
{
    use HasFactory;
    protected $fillable = [
        'website',
        'username',
        'password',
        'site_name',
        'email',
        'note',
        'created_at',
        'updated_at'
    ];
}
