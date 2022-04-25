<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Positiva;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class FinConsulta
 *
 * @property int $ID
 * @property int $nIdConsumo
 * @property Carbon $dData
 * @property string|null $aCICConsulta
 * @property string|null $aSolicitacao
 * @property string|null $aResultado
 * @property int $nIdProduto
 * @property string|null $aArrayFeatures
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
class FinConsulta extends Model
{
	protected $table = 'FinConsultas';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'nIdConsumo' => 'int',
		'nIdProduto' => 'int',
		'nStatus' => 'int',
		'nIdLoginIncluiu' => 'int',
		'nIdLoginAlterou' => 'int',
		'nIdLoginExcluiu' => 'int'
	];

	protected $dates = [
		'dData',
		'dDataIncluiu',
		'dDataAlterou',
		'dDataExcluiu'
	];

	protected $fillable = [
		'nIdConsumo',
		'dData',
		'aCICConsulta',
		'aSolicitacao',
		'aResultado',
		'nIdProduto',
		'aArrayFeatures',
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
