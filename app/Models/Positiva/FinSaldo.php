<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Positiva;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class FinSaldo
 *
 * @property int $ID
 * @property int|null $nAno
 * @property int|null $nMes
 * @property int|null $nTipoCadastro
 * @property int|null $nIdCadastro
 * @property float|null $dSaldoInicial
 * @property float|null $dTotalDebito
 * @property float|null $dTotalCredito
 * @property float|null $dSaldoFinal
 * @property string|null $aArrayDebCredJson
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
class FinSaldo extends Model
{
	protected $table = 'FinSaldos';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'nAno' => 'int',
		'nMes' => 'int',
		'nTipoCadastro' => 'int',
		'nIdCadastro' => 'int',
		'dSaldoInicial' => 'float',
		'dTotalDebito' => 'float',
		'dTotalCredito' => 'float',
		'dSaldoFinal' => 'float',
		'nStatus' => 'int',
		'nIdLoginIncluiu' => 'int',
		'nIdLoginAlterou' => 'int',
		'nIdLoginExcluiu' => 'int'
	];

	protected $dates = [
		'dDataIncluiu',
		'dDataAlterou',
		'dDataExcluiu'
	];

	protected $fillable = [
		'nAno',
		'nMes',
		'nTipoCadastro',
		'nIdCadastro',
		'dSaldoInicial',
		'dTotalDebito',
		'dTotalCredito',
		'dSaldoFinal',
		'aArrayDebCredJson',
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
