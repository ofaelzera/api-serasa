<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Positiva;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ConPefin
 *
 * @property int $ID
 * @property int $nIdContrato
 * @property Carbon $dData
 * @property int|null $nSequencia
 * @property string|null $aNomeArquivo
 * @property string|null $aArrayResumoUso
 * @property Carbon|null $dDataUpload
 * @property float|null $dValorCusto
 * @property float|null $dValorFaturar
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
class ConPefin extends Model
{
    protected $connection = 'mysql_2';
	protected $table = 'ConPefin';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'nIdContrato' => 'int',
		'nSequencia' => 'int',
		'dValorCusto' => 'float',
		'dValorFaturar' => 'float',
		'nStatus' => 'int',
		'nIdLoginIncluiu' => 'int',
		'nIdLoginAlterou' => 'int',
		'nIdLoginExcluiu' => 'int'
	];

	protected $dates = [
		'dData',
		'dDataUpload',
		'dDataIncluiu',
		'dDataAlterou',
		'dDataExcluiu'
	];

	protected $fillable = [
		'nIdContrato',
		'dData',
		'nSequencia',
		'aNomeArquivo',
		'aArrayResumoUso',
		'dDataUpload',
		'dValorCusto',
		'dValorFaturar',
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
