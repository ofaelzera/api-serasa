<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Positiva;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ConRetorno
 *
 * @property int $ID
 * @property string|null $aCICParaConsulta
 * @property string|null $aTipoPessoa
 * @property string|null $aLogon
 * @property string|null $aArrayFeature
 * @property string|null $aStringRetorno
 * @property string|null $aArrayRetorno
 * @property string|null $aCNPJConsultante
 * @property int|null $nStatus
 * @property int|null $nIdLoginIncluiu
 * @property Carbon|null $dDataIncluiu
 *
 * @package App\Models
 */
class ConRetorno extends Model
{
    protected $connection= 'mysql_2';
	protected $table = 'ConRetorno';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'nStatus' => 'int',
		'nIdLoginIncluiu' => 'int'
	];

	protected $dates = [
		'dDataIncluiu'
	];

	protected $fillable = [
		'aCICParaConsulta',
		'aTipoPessoa',
		'aLogon',
		'aArrayFeature',
		'aStringRetorno',
		'aArrayRetorno',
		'aCNPJConsultante',
		'nStatus',
		'nIdLoginIncluiu',
		'dDataIncluiu'
	];
}
