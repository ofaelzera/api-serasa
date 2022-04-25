<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Positiva;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class FinDocFinanceiro
 *
 * @property int $ID
 * @property string $aNome
 * @property int|null $nTipoCadastro
 * @property string|null $aOperaSaldo
 * @property int|null $nObrigadoHistorico
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
class FinDocFinanceiro extends Model
{
	protected $table = 'FinDocFinanceiro';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'nTipoCadastro' => 'int',
		'nObrigadoHistorico' => 'int',
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
		'aNome',
		'nTipoCadastro',
		'aOperaSaldo',
		'nObrigadoHistorico',
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
