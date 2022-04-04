<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Positiva;

use Illuminate\Database\Eloquent\Model;

/**
 * Class BaseOpcaoMenu
 *
 * @property int $ID
 * @property int|null $nIdOpcaoMenu
 * @property int|null $nSequencia
 * @property string|null $aDescricao
 * @property string|null $aHelp
 * @property string|null $aModulo
 * @property string|null $aAcao
 * @property string|null $aIcone
 * @property int|null $nTipo
 * @property int|null $nbSistema
 * @property int|null $nSituacao
 *
 * @package App\Models
 */
class BaseOpcaoMenu extends Model
{
    protected $connection= 'mysql_2';
	protected $table = 'BaseOpcaoMenu';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'nIdOpcaoMenu' => 'int',
		'nSequencia' => 'int',
		'nTipo' => 'int',
		'nbSistema' => 'int',
		'nSituacao' => 'int'
	];

	protected $fillable = [
		'nIdOpcaoMenu',
		'nSequencia',
		'aDescricao',
		'aHelp',
		'aModulo',
		'aAcao',
		'aIcone',
		'nTipo',
		'nbSistema',
		'nSituacao'
	];
}
