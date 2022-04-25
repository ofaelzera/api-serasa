<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Positiva;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ConGerencie
 *
 * @property int $ID
 * @property int|null $nIdCliente
 * @property string|null $aNome
 * @property string|null $aCpfCnpj
 * @property string|null $aEmail
 * @property string|null $aHistorico
 * @property Carbon|null $dData
 * @property string|null $dDataVencimento
 * @property int|null $nEnviado
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
class ConGerencie extends Model
{
	protected $table = 'ConGerencie';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'nIdCliente' => 'int',
		'nEnviado' => 'int',
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
		'nIdCliente',
		'aNome',
		'aCpfCnpj',
		'aEmail',
		'aHistorico',
		'dData',
		'dDataVencimento',
		'nEnviado',
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
