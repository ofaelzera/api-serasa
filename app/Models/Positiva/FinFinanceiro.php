<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Positiva;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class FinFinanceiro
 *
 * @property int $ID
 * @property int|null $nIdDocumento
 * @property int|null $nIdCliente
 * @property int|null $nIdFornecedor
 * @property Carbon|null $dData
 * @property Carbon|null $dDataVencimento
 * @property float|null $dValor
 * @property float|null $dValorServico
 * @property int|null $nIdHistorico
 * @property Carbon|null $dFatDataInicial
 * @property Carbon|null $dFatDataFinal
 * @property string|null $aArrayComplemento
 * @property int|null $nIdBanco
 * @property string|null $aNroBoleto
 * @property float|null $dValorBoleto
 * @property int|null $nRemessaNro
 * @property Carbon|null $dRemessaData
 * @property Carbon|null $dDataRetornoAceite
 * @property Carbon|null $dNfeData
 * @property int|null $nNfeLote
 * @property int|null $nNfeRPS
 * @property float|null $dNfeAliqISS
 * @property float|null $dNfeValorISS
 * @property string|null $aImagemNFE
 * @property string|null $aXmlNFE
 * @property int|null $nQuitIdDocumento
 * @property int|null $nQuitIdFinPagador
 * @property int|null $nQuitIdPagador
 * @property Carbon|null $dQuitData
 * @property float|null $dQuitValorPago
 * @property int|null $nIdEmpresa
 * @property int|null $nIdContrato
 * @property int|null $nIdFaturaLogon
 * @property string|null $aLog
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
class FinFinanceiro extends Model
{
	protected $table = 'FinFinanceiro';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'nIdDocumento' => 'int',
		'nIdCliente' => 'int',
		'nIdFornecedor' => 'int',
		'dValor' => 'float',
		'dValorServico' => 'float',
		'nIdHistorico' => 'int',
		'nIdBanco' => 'int',
		'dValorBoleto' => 'float',
		'nRemessaNro' => 'int',
		'nNfeLote' => 'int',
		'nNfeRPS' => 'int',
		'dNfeAliqISS' => 'float',
		'dNfeValorISS' => 'float',
		'nQuitIdDocumento' => 'int',
		'nQuitIdFinPagador' => 'int',
		'nQuitIdPagador' => 'int',
		'dQuitValorPago' => 'float',
		'nIdEmpresa' => 'int',
		'nIdContrato' => 'int',
		'nIdFaturaLogon' => 'int',
		'nStatus' => 'int',
		'nIdLoginIncluiu' => 'int',
		'nIdLoginAlterou' => 'int',
		'nIdLoginExcluiu' => 'int'
	];

	protected $dates = [
		'dData',
		'dDataVencimento',
		'dFatDataInicial',
		'dFatDataFinal',
		'dRemessaData',
		'dDataRetornoAceite',
		'dNfeData',
		'dQuitData',
		'dDataIncluiu',
		'dDataAlterou',
		'dDataExcluiu'
	];

	protected $fillable = [
		'nIdDocumento',
		'nIdCliente',
		'nIdFornecedor',
		'dData',
		'dDataVencimento',
		'dValor',
		'dValorServico',
		'nIdHistorico',
		'dFatDataInicial',
		'dFatDataFinal',
		'aArrayComplemento',
		'nIdBanco',
		'aNroBoleto',
		'dValorBoleto',
		'nRemessaNro',
		'dRemessaData',
		'dDataRetornoAceite',
		'dNfeData',
		'nNfeLote',
		'nNfeRPS',
		'dNfeAliqISS',
		'dNfeValorISS',
		'aImagemNFE',
		'aXmlNFE',
		'nQuitIdDocumento',
		'nQuitIdFinPagador',
		'nQuitIdPagador',
		'dQuitData',
		'dQuitValorPago',
		'nIdEmpresa',
		'nIdContrato',
		'nIdFaturaLogon',
		'aLog',
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
