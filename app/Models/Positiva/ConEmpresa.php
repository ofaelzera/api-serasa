<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Positiva;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ConEmpresa
 *
 * @property int $ID
 * @property string $aRazao
 * @property string|null $aNomeFantasia
 * @property string $aCnpj
 * @property string|null $aEndereco
 * @property string|null $aNumero
 * @property string|null $aComplemento
 * @property string|null $aBairro
 * @property int|null $nCEP
 * @property int|null $nIdCidade
 * @property string|null $aUF
 * @property string|null $aTelefone1
 * @property string|null $aTelefone2
 * @property string|null $aEmail
 * @property string|null $aEMailFinanceiro
 * @property string|null $aTextoEmailFinanceiro
 * @property string|null $aIncricaoEstadual
 * @property string|null $aIncricaoMunicipal
 * @property string|null $aResponsavel
 * @property string|null $aNomeParaContato
 * @property string|null $aImagemLogo
 * @property string|null $aLogonHomProrede
 * @property string|null $aSenhaHomProrede
 * @property string|null $aLogonProdProrede
 * @property string|null $aSenhaProdProrede
 * @property int|null $nOptanteSimplesNacional
 * @property int|null $nIcentivoFiscal
 * @property float|null $dAliqISSQN
 * @property int|null $nIssRetido
 * @property int|null $nCodigoCNAE
 * @property int|null $nRegimeEspecialTributacao
 * @property int|null $nItemListaServico
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
class ConEmpresa extends Model
{
	protected $table = 'ConEmpresa';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'nCEP' => 'int',
		'nIdCidade' => 'int',
		'nOptanteSimplesNacional' => 'int',
		'nIcentivoFiscal' => 'int',
		'dAliqISSQN' => 'float',
		'nIssRetido' => 'int',
		'nCodigoCNAE' => 'int',
		'nRegimeEspecialTributacao' => 'int',
		'nItemListaServico' => 'int',
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
		'aRazao',
		'aNomeFantasia',
		'aCnpj',
		'aEndereco',
		'aNumero',
		'aComplemento',
		'aBairro',
		'nCEP',
		'nIdCidade',
		'aUF',
		'aTelefone1',
		'aTelefone2',
		'aEmail',
		'aEMailFinanceiro',
		'aTextoEmailFinanceiro',
		'aIncricaoEstadual',
		'aIncricaoMunicipal',
		'aResponsavel',
		'aNomeParaContato',
		'aImagemLogo',
		'aLogonHomProrede',
		'aSenhaHomProrede',
		'aLogonProdProrede',
		'aSenhaProdProrede',
		'nOptanteSimplesNacional',
		'nIcentivoFiscal',
		'dAliqISSQN',
		'nIssRetido',
		'nCodigoCNAE',
		'nRegimeEspecialTributacao',
		'nItemListaServico',
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
