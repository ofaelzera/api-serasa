<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Positiva;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ConContrato
 *
 * @property int $ID
 * @property int|null $nIdCliente
 * @property int|null $nIdVendedor
 * @property Carbon|null $dData
 * @property int|null $nPrazoReajuste
 * @property Carbon|null $dDataProxReajuste
 * @property int|null $nDuracaoContrato
 * @property Carbon|null $dDataVctoContrato
 * @property int|null $nCalcProporcional
 * @property int|null $nDiaBase
 * @property int|null $nDiaVencto
 * @property Carbon|null $dDataPrimVencto
 * @property float|null $dValorVCM
 * @property string|null $aArrayTabPreco
 * @property string|null $aProdutosPrecosJson
 * @property string|null $aProdutosPrecosJsonOld
 * @property int|null $nIndiceReajuste
 * @property string|null $bAssinatura
 * @property string|null $aClausulasEspeciais
 * @property string|null $aArrayLogonSenha
 * @property int|null $nTipoContrato
 * @property int|null $nConsulmoDetalhado
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
class ConContrato extends Model
{
	protected $table = 'ConContrato';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'nIdCliente' => 'int',
		'nIdVendedor' => 'int',
		'nPrazoReajuste' => 'int',
		'nDuracaoContrato' => 'int',
		'nCalcProporcional' => 'int',
		'nDiaBase' => 'int',
		'nDiaVencto' => 'int',
		'dValorVCM' => 'float',
		'nIndiceReajuste' => 'int',
		'nTipoContrato' => 'int',
		'nConsulmoDetalhado' => 'int',
		'nStatus' => 'int',
		'nIdLoginIncluiu' => 'int',
		'nIdLoginAlterou' => 'int',
		'nIdLoginExcluiu' => 'int'
	];

	protected $dates = [
		'dData',
		'dDataProxReajuste',
		'dDataVctoContrato',
		'dDataPrimVencto',
		'dDataIncluiu',
		'dDataAlterou',
		'dDataExcluiu'
	];

	protected $fillable = [
		'nIdCliente',
		'nIdVendedor',
		'dData',
		'nPrazoReajuste',
		'dDataProxReajuste',
		'nDuracaoContrato',
		'dDataVctoContrato',
		'nCalcProporcional',
		'nDiaBase',
		'nDiaVencto',
		'dDataPrimVencto',
		'dValorVCM',
		'aArrayTabPreco',
		'aProdutosPrecosJson',
		'aProdutosPrecosJsonOld',
		'nIndiceReajuste',
		'bAssinatura',
		'aClausulasEspeciais',
		'aArrayLogonSenha',
		'nTipoContrato',
		'nConsulmoDetalhado',
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
