<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Positiva;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class FinBanco
 *
 * @property int $ID
 * @property int|null $nBancoCentral
 * @property int|null $nAgencia
 * @property string $aDgAgencia
 * @property string $aConta
 * @property string $aDgConta
 * @property string $aNome
 * @property string|null $aEndereco
 * @property string|null $aNumero
 * @property string|null $aComplemento
 * @property string|null $aBairro
 * @property int|null $nCEP
 * @property string|null $aCidade
 * @property string|null $aUF
 * @property string|null $aTelefone1
 * @property string|null $aTelefone2
 * @property string|null $aEmail
 * @property int|null $nCarteira
 * @property int|null $nConvenio
 * @property int|null $nCodigoBeneficiario
 * @property string $aEspecieTitulo
 * @property int|null $nProtesto
 * @property int|null $nPrazoProtesto
 * @property float|null $dPercJuroMes
 * @property float|null $dPercMultaMes
 * @property int|null $nIndicarBaixa
 * @property int|null $nPrazoBaixar
 * @property int|null $nEmpresa
 * @property int|null $nHomolocacaoProd
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
class FinBanco extends Model
{
	protected $table = 'FinBanco';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'nBancoCentral' => 'int',
		'nAgencia' => 'int',
		'nCEP' => 'int',
		'nCarteira' => 'int',
		'nConvenio' => 'int',
		'nCodigoBeneficiario' => 'int',
		'nProtesto' => 'int',
		'nPrazoProtesto' => 'int',
		'dPercJuroMes' => 'float',
		'dPercMultaMes' => 'float',
		'nIndicarBaixa' => 'int',
		'nPrazoBaixar' => 'int',
		'nEmpresa' => 'int',
		'nHomolocacaoProd' => 'int',
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
		'nBancoCentral',
		'nAgencia',
		'aDgAgencia',
		'aConta',
		'aDgConta',
		'aNome',
		'aEndereco',
		'aNumero',
		'aComplemento',
		'aBairro',
		'nCEP',
		'aCidade',
		'aUF',
		'aTelefone1',
		'aTelefone2',
		'aEmail',
		'nCarteira',
		'nConvenio',
		'nCodigoBeneficiario',
		'aEspecieTitulo',
		'nProtesto',
		'nPrazoProtesto',
		'dPercJuroMes',
		'dPercMultaMes',
		'nIndicarBaixa',
		'nPrazoBaixar',
		'nEmpresa',
		'nHomolocacaoProd',
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
