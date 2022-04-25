<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Positiva;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ConCliente
 *
 * @property int $ID
 * @property string $aRazao
 * @property string $aFantasia
 * @property string $aCNPJ
 * @property string $aEndereco
 * @property string $aBairro
 * @property int $nCEP
 * @property int|null $nIdCidade
 * @property int $nDDD
 * @property string $aFone
 * @property string $aRamal
 * @property string|null $aContato
 * @property int|null $nAgencia
 * @property int|null $nContaCorrente
 * @property string|null $aEmail
 * @property string|null $aLogon
 * @property string|null $aSenha
 * @property string|null $aArrayPedidoAcesso
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
class ConCliente extends Model
{
	protected $table = 'ConCliente';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'nCEP' => 'int',
		'nIdCidade' => 'int',
		'nDDD' => 'int',
		'nAgencia' => 'int',
		'nContaCorrente' => 'int',
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
		'aFantasia',
		'aCNPJ',
		'aEndereco',
		'aBairro',
		'nCEP',
		'nIdCidade',
		'nDDD',
		'aFone',
		'aRamal',
		'aContato',
		'nAgencia',
		'nContaCorrente',
		'aEmail',
		'aLogon',
		'aSenha',
		'aArrayPedidoAcesso',
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
