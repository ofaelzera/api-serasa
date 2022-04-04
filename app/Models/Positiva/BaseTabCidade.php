<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Positiva;

use Illuminate\Database\Eloquent\Model;

/**
 * Class BaseTabCidade
 *
 * @property int $ID
 * @property string $aMunicipio
 * @property string $aUF
 * @property int|null $nDDD
 * @property int|null $nDIMOB
 * @property int|null $nCEPInicial
 * @property int|null $nCEPFinal
 * @property int|null $nIBGE
 * @property string|null $aNomeReduzido
 * @property string|null $aSiglaEmbratel
 *
 * @package App\Models
 */
class BaseTabCidade extends Model
{
    protected $connection= 'mysql_2';
	protected $table = 'BaseTabCidade';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'nDDD' => 'int',
		'nDIMOB' => 'int',
		'nCEPInicial' => 'int',
		'nCEPFinal' => 'int',
		'nIBGE' => 'int'
	];

	protected $fillable = [
		'aMunicipio',
		'aUF',
		'nDDD',
		'nDIMOB',
		'nCEPInicial',
		'nCEPFinal',
		'nIBGE',
		'aNomeReduzido',
		'aSiglaEmbratel'
	];
}
