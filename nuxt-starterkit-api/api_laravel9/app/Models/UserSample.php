<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSample extends Model
{
    use HasFactory;
    protected $table = 'user_samples';

    protected $hidden = [
        'password',
    ];

    protected $fillable = [
        'first_name',
        'last_name',
        'company',
        'address',
        'city',
        'country',
        'postcode',
        'gender',
        'phone',
        'email',
        'web',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function postcode()
    {
        return $this->belongsTo(Postcode::class, 'postcode_id');
    }
}
