<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Positiva;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ConFaturaLogonMaster
 *
 * @property int $ID
 * @property Carbon $dData
 * @property Carbon $dDataInicial
 * @property Carbon $dDataFinal
 * @property string|null $aNomeArqRetorno
 * @property int|null $nTipoFatura
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
class ConFaturaLogonMaster extends Model
{
    protected $connection= 'mysql_2';
	protected $table = 'ConFaturaLogonMaster';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'nTipoFatura' => 'int',
		'nStatus' => 'int',
		'nIdLoginIncluiu' => 'int',
		'nIdLoginAlterou' => 'int',
		'nIdLoginExcluiu' => 'int'
	];

	protected $dates = [
		'dData',
		'dDataInicial',
		'dDataFinal',
		'dDataIncluiu',
		'dDataAlterou',
		'dDataExcluiu'
	];

	protected $fillable = [
		'dData',
		'dDataInicial',
		'dDataFinal',
		'aNomeArqRetorno',
		'nTipoFatura',
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
