<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Positiva;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ConVendedor
 *
 * @property int $ID
 * @property string $aNome
 * @property string $aCPF
 * @property string $aEndereco
 * @property string $aBairro
 * @property int $nCEP
 * @property int|null $nIdCidade
 * @property int $nDDD
 * @property string $aFone
 * @property int|null $nIdBacen
 * @property int|null $nAgencia
 * @property int|null $nContaCorrente
 * @property string|null $aEmail
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
class ConVendedor extends Model
{
	protected $table = 'ConVendedor';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'nCEP' => 'int',
		'nIdCidade' => 'int',
		'nDDD' => 'int',
		'nIdBacen' => 'int',
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
		'aNome',
		'aCPF',
		'aEndereco',
		'aBairro',
		'nCEP',
		'nIdCidade',
		'nDDD',
		'aFone',
		'nIdBacen',
		'nAgencia',
		'nContaCorrente',
		'aEmail',
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
