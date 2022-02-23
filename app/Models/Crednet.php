<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Crednet
 * 
 * @property int $id
 * @property int|null $id_contrato
 * @property Carbon|null $data_consulta
 * @property string|null $cnpj_consulta
 * @property string|null $logon
 * @property string|null $tipo_pessoa
 * @property string|null $p002
 * @property string|null $n003
 * @property string|null $string_envio
 * @property string|null $string_retorno
 *
 * @package App\Models
 */
class Crednet extends Model
{
	protected $table = 'crednet';
	public $timestamps = false;

	protected $casts = [
		'id_contrato' => 'int'
	];

	protected $dates = [
		'data_consulta'
	];

	protected $fillable = [
		'id_contrato',
		'data_consulta',
		'cnpj_consulta',
		'logon',
		'tipo_pessoa',
		'p002',
		'n003',
		'string_envio',
		'string_retorno'
	];
}
