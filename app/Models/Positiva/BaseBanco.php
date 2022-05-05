<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Positiva;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BaseBanco
 *
 * @property int $ID
 * @property string|null $aNome
 * @property string|null $aCNPJ
 * @property Carbon|null $UpdatedAt
 * @property int|null $IsDeleted
 *
 * @package App\Models
 */
class BaseBanco extends Model
{
    protected $connection = 'mysql_2';
	protected $table = 'BaseBancos';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'IsDeleted' => 'int'
	];

	protected $dates = [
		'UpdatedAt'
	];

	protected $fillable = [
		'aNome',
		'aCNPJ',
		'UpdatedAt',
		'IsDeleted'
	];
}
