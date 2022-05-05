<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Positiva;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BaseLogin
 *
 * @property int $ID
 * @property string $username
 * @property string $password
 * @property string|null $aNome
 * @property string|null $aEndereco
 * @property string|null $aNumero
 * @property string|null $aComplemento
 * @property string|null $aCgcCpf
 * @property string|null $aInscricaoRG
 * @property string|null $aCidade
 * @property int|null $lnCEP
 * @property string $email
 * @property string|null $aFuncao
 * @property string|null $aFoto
 * @property Carbon|null $dtDataSuspensao
 * @property int|null $nTipoSenha
 * @property int|null $nIdAngariador
 * @property int|null $nEmpresa
 * @property string|null $aOrgaosTrabalho
 * @property int|null $nStatus
 * @property int|null $nIdLoginIncluiu
 * @property Carbon|null $dDataIncluiu
 * @property int|null $nIdLoginAlterou
 * @property Carbon|null $dDataAlterou
 * @property int|null $nIdLoginExcluiu
 * @property Carbon|null $dDataExcluiu
 *
 * @package App\Models
 */
class BaseLogin extends Model
{
    protected $connection = 'mysql_2';
	protected $table = 'BaseLogin';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'lnCEP' => 'int',
		'nTipoSenha' => 'int',
		'nIdAngariador' => 'int',
		'nEmpresa' => 'int',
		'nStatus' => 'int',
		'nIdLoginIncluiu' => 'int',
		'nIdLoginAlterou' => 'int',
		'nIdLoginExcluiu' => 'int'
	];

	protected $dates = [
		'dtDataSuspensao',
		'dDataIncluiu',
		'dDataAlterou',
		'dDataExcluiu'
	];

	protected $hidden = [
		'password'
	];

	protected $fillable = [
		'username',
		'password',
		'aNome',
		'aEndereco',
		'aNumero',
		'aComplemento',
		'aCgcCpf',
		'aInscricaoRG',
		'aCidade',
		'lnCEP',
		'email',
		'aFuncao',
		'aFoto',
		'dtDataSuspensao',
		'nTipoSenha',
		'nIdAngariador',
		'nEmpresa',
		'aOrgaosTrabalho',
		'nStatus',
		'nIdLoginIncluiu',
		'dDataIncluiu',
		'nIdLoginAlterou',
		'dDataAlterou',
		'nIdLoginExcluiu',
		'dDataExcluiu'
	];
}
