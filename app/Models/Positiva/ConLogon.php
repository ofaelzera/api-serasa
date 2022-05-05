<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Positiva;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ConLogon
 *
 * @property int $ID
 * @property int $nIdCliente
 * @property int $nIdContrato
 * @property int|null $nProduto
 * @property string|null $aLogon
 * @property string|null $aSenha
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
class ConLogon extends Model
{
    protected $connection = 'mysql_2';
	protected $table = 'ConLogon';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'nIdCliente' => 'int',
		'nIdContrato' => 'int',
		'nProduto' => 'int',
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
		'nIdCliente',
		'nIdContrato',
		'nProduto',
		'aLogon',
		'aSenha',
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
