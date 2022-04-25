<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Positiva;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ConMeProtejaSocio
 *
 * @property int $ID
 * @property int $nIdConMeProteja
 * @property string $aTipoPessoa
 * @property string|null $aNome
 * @property string $aDocumentoSocio
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
class ConMeProtejaSocio extends Model
{
	protected $table = 'ConMeProtejaSocio';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'nIdConMeProteja' => 'int',
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
		'nIdConMeProteja',
		'aTipoPessoa',
		'aNome',
		'aDocumentoSocio',
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
