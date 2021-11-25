<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Meproteja
 *
 * @property int $id
 * @property string $cliente
 * @property string $distribuidor
 * @property string $json
 * @property int $status
 * @property Carbon|null $data_inclusao
 * @property Carbon|null $data_envio
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Meproteja extends Model
{
	protected $table = 'meproteja';
	public $timestamps = true;

	protected $casts = [
		'status' => 'int'
	];

	protected $dates = [
		'data_inclusao',
		'data_envio'
	];

	protected $fillable = [
		'cliente',
		'distribuidor',
		'json',
		'status',
		'data_inclusao',
		'data_envio'
	];
}
