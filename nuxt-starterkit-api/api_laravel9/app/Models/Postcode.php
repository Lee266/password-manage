<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Postcode
 * 
 * @property int $id
 * @property string $postcode
 * @property string $prefecture_kana
 * @property string $city_kana
 * @property string|null $local_kana
 * @property string $prefecture
 * @property string $city
 * @property string|null $local
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property Collection|Sample[] $samples
 *
 * @package App\Models
 */
class Postcode extends Model
{
	use SoftDeletes;
	protected $table = 'postcodes';

	protected $fillable = [
		'postcode',
		'prefecture_kana',
		'city_kana',
		'local_kana',
		'prefecture',
		'city',
		'local'
	];

	public function samples()
	{
		return $this->hasMany(Sample::class, 'prefecture_id');
	}
}
