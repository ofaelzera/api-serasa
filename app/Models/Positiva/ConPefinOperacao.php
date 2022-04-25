<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Positiva;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ConPefinOperacao
 *
 * @property int $ID
 * @property int $nIdContrato
 * @property Carbon $dData
 * @property string|null $aOperacao
 * @property Carbon $dDataOcorrencia
 * @property Carbon $dDataFinalContrato
 * @property string|null $aNatureza
 * @property string|null $aPrincTipoPessoa
 * @property string|null $aPrincTipoDocumento
 * @property string|null $aPrincCpfCnpj
 * @property string|null $aSecundTipoDocumento
 * @property string|null $aSecundRG
 * @property string|null $aSecundUfRG
 * @property string|null $aCoobrTipoPessoa
 * @property string|null $aCoobrTipoDocumento
 * @property string|null $aCoobrCpfCnpj
 * @property string|null $aCoobSecTipoDocumento
 * @property string|null $aCoobSecRG
 * @property string|null $aCoobSecUfRG
 * @property string|null $aNomeDevedor
 * @property string|null $aNomePai
 * @property string|null $aNomeMae
 * @property string|null $aEndereco
 * @property string|null $aNumero
 * @property string|null $aComplemento
 * @property string|null $aBairro
 * @property string|null $aMunicipio
 * @property string|null $aCEP
 * @property string|null $aEstado
 * @property string|null $aDDD
 * @property string|null $aTelefone
 * @property float|null $dValorDivida
 * @property string|null $aNumeroContrato
 * @property string|null $aNossoNumero
 * @property string|null $aTipoComunicDevedor
 * @property int|null $nBanco
 * @property int|null $nCheque
 * @property int|null $nAlinea
 * @property int|null $nAgencia
 * @property int|null $nConta
 * @property int|null $nEnviado
 * @property int|null $nStatus
 * @property int|null $nRetorno
 * @property string|null $aLogs
 * @property int $nIdConPefin
 * @property string $aMotivoBaixa
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
class ConPefinOperacao extends Model
{
	protected $table = 'ConPefinOperacao';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'nIdContrato' => 'int',
		'dValorDivida' => 'float',
		'nBanco' => 'int',
		'nCheque' => 'int',
		'nAlinea' => 'int',
		'nAgencia' => 'int',
		'nConta' => 'int',
		'nEnviado' => 'int',
		'nStatus' => 'int',
		'nRetorno' => 'int',
		'nIdConPefin' => 'int',
		'nIdLoginIncluiu' => 'int',
		'nIdLoginAlterou' => 'int',
		'nIdLoginExcluiu' => 'int'
	];

	protected $dates = [
		'dData',
		'dDataOcorrencia',
		'dDataFinalContrato',
		'dDataIncluiu',
		'dDataAlterou',
		'dDataExcluiu'
	];

	protected $fillable = [
		'nIdContrato',
		'dData',
		'aOperacao',
		'dDataOcorrencia',
		'dDataFinalContrato',
		'aNatureza',
		'aPrincTipoPessoa',
		'aPrincTipoDocumento',
		'aPrincCpfCnpj',
		'aSecundTipoDocumento',
		'aSecundRG',
		'aSecundUfRG',
		'aCoobrTipoPessoa',
		'aCoobrTipoDocumento',
		'aCoobrCpfCnpj',
		'aCoobSecTipoDocumento',
		'aCoobSecRG',
		'aCoobSecUfRG',
		'aNomeDevedor',
		'aNomePai',
		'aNomeMae',
		'aEndereco',
		'aNumero',
		'aComplemento',
		'aBairro',
		'aMunicipio',
		'aCEP',
		'aEstado',
		'aDDD',
		'aTelefone',
		'dValorDivida',
		'aNumeroContrato',
		'aNossoNumero',
		'aTipoComunicDevedor',
		'nBanco',
		'nCheque',
		'nAlinea',
		'nAgencia',
		'nConta',
		'nEnviado',
		'nStatus',
		'nRetorno',
		'aLogs',
		'nIdConPefin',
		'aMotivoBaixa',
		'nIdLoginIncluiu',
		'dDataIncluiu',
		'nIdLoginAlterou',
		'dDataAlterou',
		'nIdLoginExcluiu',
		'dDataExcluiu',
		'aMotivoExcluiu'
	];
}
