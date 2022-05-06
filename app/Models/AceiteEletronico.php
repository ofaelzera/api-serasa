<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AceiteEletronico
 *
 * @property int $id
 * @property string|null $nome
 * @property string|null $cpf
 * @property string|null $email
 * @property string|null $telefone
 * @property string|null $ip
 * @property string|null $dispositivo
 * @property Carbon|null $data_envio
 * @property Carbon|null $data_aceite
 * @property Carbon|null $data_final
 * @property string|null $hash_original
 * @property string|null $titulo
 * @property string|null $contrato
 * @property string|null $assinatura
 * @property string|null $token
 * @property string|null $senha
 * @property string|null $url
 * @property string|null $pdf
 * @property string $tabela_preco
 * @property int|null $id_users
 * @property int|null $id_contrato
 * @property int|null $status
 *
 * @package App\Models
 */
class AceiteEletronico extends Model
{
	protected $table = 'aceite_eletronico';
	public $timestamps = false;

	protected $casts = [
		'id_users' => 'int',
		'id_contrato' => 'int',
		'status' => 'int'
	];

	protected $dates = [
		'data_envio',
		'data_aceite',
		'data_final'
	];

	protected $hidden = [
		'token'
	];

	protected $fillable = [
		'nome',
		'cpf',
		'email',
		'telefone',
		'ip',
		'dispositivo',
		'data_envio',
		'data_aceite',
		'data_final',
		'hash_original',
		'titulo',
		'contrato',
		'assinatura',
		'token',
		'senha',
		'url',
		'pdf',
		'tabela_preco',
		'id_users',
		'id_contrato',
		'status'
	];
}
