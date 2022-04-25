<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Positiva;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AceiteEletronico
 *
 * @property int $ID
 * @property int|null $nIdConContrato
 * @property int|null $nIdAceiteContrato
 * @property Carbon|null $dData
 * @property Carbon|null $dDataEnvio
 * @property Carbon|null $dDataRetorno
 * @property string|null $aToken
 * @property string|null $aNome
 * @property string|null $aEmail
 * @property string|null $aUrlPDF
 * @property string|null $aContrato
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
class AceiteEletronico extends Model
{
	protected $table = 'AceiteEletronico';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'nIdConContrato' => 'int',
		'nIdAceiteContrato' => 'int',
		'nStatus' => 'int',
		'nIdLoginIncluiu' => 'int',
		'nIdLoginAlterou' => 'int',
		'nIdLoginExcluiu' => 'int'
	];

	protected $dates = [
		'dData',
		'dDataEnvio',
		'dDataRetorno',
		'dDataIncluiu',
		'dDataAlterou',
		'dDataExcluiu'
	];

	protected $fillable = [
		'nIdConContrato',
		'nIdAceiteContrato',
		'dData',
		'dDataEnvio',
		'dDataRetorno',
		'aToken',
		'aNome',
		'aEmail',
		'aUrlPDF',
		'aContrato',
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
