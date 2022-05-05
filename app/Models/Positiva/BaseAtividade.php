<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Positiva;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BaseAtividade
 *
 * @property int $ID
 * @property Carbon $dtDataHora
 * @property int $nIdUsuario
 * @property int $nIdBancoDeDados
 * @property int $nIdCadastro
 * @property int $nServico
 * @property string $bDadosAntes
 * @property string|null $bDadosAtual
 *
 * @package App\Models
 */
class BaseAtividade extends Model
{
    protected $connection = 'mysql_2';
	protected $table = 'BaseAtividades';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'nIdUsuario' => 'int',
		'nIdBancoDeDados' => 'int',
		'nIdCadastro' => 'int',
		'nServico' => 'int'
	];

	protected $dates = [
		'dtDataHora'
	];

	protected $fillable = [
		'dtDataHora',
		'nIdUsuario',
		'nIdBancoDeDados',
		'nIdCadastro',
		'nServico',
		'bDadosAntes',
		'bDadosAtual'
	];
}
