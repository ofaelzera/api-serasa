<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Positiva;

use Illuminate\Database\Eloquent\Model;

/**
 * Class BaseLoginLiberacao
 *
 * @property int $ID
 * @property int|null $nIdLogin
 * @property int|null $nIdOpcaoMenu
 * @property int|null $nAcao
 *
 * @package App\Models
 */
class BaseLoginLiberacao extends Model
{
    protected $connection= 'mysql_2';
	protected $table = 'BaseLoginLiberacao';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'nIdLogin' => 'int',
		'nIdOpcaoMenu' => 'int',
		'nAcao' => 'int'
	];

	protected $fillable = [
		'nIdLogin',
		'nIdOpcaoMenu',
		'nAcao'
	];
}
