<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    use HasFactory;
	protected $table = 'meetings';

    protected $fillable = [
        'title',
        'user_id',
        'location',
        'meeting_date',
        'location_image_url',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
