<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Positiva;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ProdPrecoProdutoFeature
 *
 * @property int $ID
 * @property int|null $nIdTabPreco
 * @property string $aDescricao
 * @property string|null $aObs
 * @property int|null $nTipoLigacao
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
class ProdPrecoProdutoFeature extends Model
{
    protected $connection = 'mysql_2';
	protected $table = 'ProdPrecoProdutoFeature';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'nIdTabPreco' => 'int',
		'nTipoLigacao' => 'int',
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
		'nIdTabPreco',
		'aDescricao',
		'aObs',
		'nTipoLigacao',
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
