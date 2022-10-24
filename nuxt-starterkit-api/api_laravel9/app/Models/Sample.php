<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Sample
 * 
 * @property int $id
 * @property string $name
 * @property string|null $avatar
 * @property Carbon|null $birthday
 * @property int|null $hobby
 * @property bool|null $gender
 * @property string $postcode
 * @property int|null $prefecture_id
 * @property string|null $address
 * @property Carbon|null $active_hour
 * @property string $email
 * @property string $password
 * @property int $price
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 *
 * @package App\Models
 */
class Sample extends Model
{
	protected $table = 'samples';

	protected $casts = [
		'hobby' => 'int',
		'gender' => 'bool',
		'prefecture_id' => 'int',
		'price' => 'int'
	];

	protected $dates = [
		'birthday',
		'active_hour'
	];

	protected $hidden = [
		'password'
	];

	protected $fillable = [
		'name',
		'avatar',
		'birthday',
		'hobby',
		'gender',
		'postcode',
		'prefecture_id',
		'address',
		'active_hour',
		'email',
		'password',
		'price'
	];

	public function postcode()
	{
		return $this->belongsTo(Postcode::class, 'prefecture_id');
	}
}
