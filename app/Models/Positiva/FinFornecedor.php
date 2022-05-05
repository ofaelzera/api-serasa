<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Positiva;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class FinFornecedor
 *
 * @property int $ID
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
 * @property int|null $nEmpresa
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
class FinFornecedor extends Model
{
    protected $connection = 'mysql_2';
	protected $table = 'FinFornecedor';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'nCEP' => 'int',
		'nEmpresa' => 'int',
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
		'nEmpresa',
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
