<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Positiva;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ConMeProteja
 *
 * @property int $ID
 * @property int $nIdContrato
 * @property Carbon $dData
 * @property Carbon|null $dDataVencimento
 * @property string $aPlano
 * @property string $aModalidade
 * @property string|null $aEmail
 * @property string|null $aArrayRetorno
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
class ConMeProteja extends Model
{
    protected $connection = 'mysql_2';
	protected $table = 'ConMeProteja';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'nIdContrato' => 'int',
		'nStatus' => 'int',
		'nIdLoginIncluiu' => 'int',
		'nIdLoginAlterou' => 'int',
		'nIdLoginExcluiu' => 'int'
	];

	protected $dates = [
		'dData',
		'dDataVencimento',
		'dDataIncluiu',
		'dDataAlterou',
		'dDataExcluiu'
	];

	protected $fillable = [
		'nIdContrato',
		'dData',
		'dDataVencimento',
		'aPlano',
		'aModalidade',
		'aEmail',
		'aArrayRetorno',
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
