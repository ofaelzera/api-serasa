<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Positiva;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class FinConsumo
 *
 * @property int $ID
 * @property int $nIdContrato
 * @property Carbon $dDataInicio
 * @property Carbon $dDataFinal
 * @property Carbon $dDataUsado
 * @property int|null $nSituacao
 * @property int|null $nStatus
 * @property int|null $nIdLoginIncluiu
 * @property Carbon|null $dDataIncluiu
 * @property int|null $nIdLoginAlterou
 * @property Carbon|null $dDataAlterou
 * @property int|null $nIdLoginExcluiu
 * @property Carbon|null $dDataExcluiu
 * @property string|null $aMotivoExcluiu
 *
 * @package App\Models
 */
class FinConsumo extends Model
{
    protected $connection= 'mysql_2';
	protected $table = 'FinConsumo';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'nIdContrato' => 'int',
		'nSituacao' => 'int',
		'nStatus' => 'int',
		'nIdLoginIncluiu' => 'int',
		'nIdLoginAlterou' => 'int',
		'nIdLoginExcluiu' => 'int'
	];

	protected $dates = [
		'dDataInicio',
		'dDataFinal',
		'dDataUsado',
		'dDataIncluiu',
		'dDataAlterou',
		'dDataExcluiu'
	];

	protected $fillable = [
		'nIdContrato',
		'dDataInicio',
		'dDataFinal',
		'dDataUsado',
		'nSituacao',
		'nStatus',
		'nIdLoginIncluiu',
		'dDataIncluiu',
		'nIdLoginAlterou',
		'dDataAlterou',
		'nIdLoginExcluiu',
		'dDataExcluiu',
		'aMotivoExcluiu'
	];
}
