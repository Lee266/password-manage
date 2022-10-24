<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageSample extends Model
{
    protected $table = 'images_sample';

	protected $fillable = [
		'sample_id',
		'filename',
	];

	public function sample()
	{
		return $this->belongsTo(Sample::class, 'sample_id');
	}
}
