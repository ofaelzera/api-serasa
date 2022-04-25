<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Positiva;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BaseNotificaco
 *
 * @property int $ID
 * @property int|null $nIdBaseBancoDeDados
 * @property int|null $nIdDado
 * @property Carbon|null $dDataIncluiu
 * @property int|null $nIdLoginCriou
 * @property int|null $nAcaoCriou
 * @property int|null $nIdLoginResolveu
 * @property Carbon|null $dDataResolveu
 * @property int|null $nAcaoResolveu
 *
 * @package App\Models
 */
class BaseNotificaco extends Model
{
	protected $table = 'BaseNotificacoes';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'nIdBaseBancoDeDados' => 'int',
		'nIdDado' => 'int',
		'nIdLoginCriou' => 'int',
		'nAcaoCriou' => 'int',
		'nIdLoginResolveu' => 'int',
		'nAcaoResolveu' => 'int'
	];

	protected $dates = [
		'dDataIncluiu',
		'dDataResolveu'
	];

	protected $fillable = [
		'nIdBaseBancoDeDados',
		'nIdDado',
		'dDataIncluiu',
		'nIdLoginCriou',
		'nAcaoCriou',
		'nIdLoginResolveu',
		'dDataResolveu',
		'nAcaoResolveu'
	];
}
