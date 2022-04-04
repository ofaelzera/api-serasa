<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Positiva;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ProdTipoPreco
 *
 * @property int $ID
 * @property int $nIdTabProdutoFeature
 * @property string|null $aDescricao
 * @property string|null $aReduzido
 * @property int|null $nOrigemValor
 * @property int|null $nIdTipoPrecoBase
 * @property float|null $dPercSobreBase
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
class ProdTipoPreco extends Model
{
    protected $connection= 'mysql_2';
	protected $table = 'ProdTipoPreco';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'nIdTabProdutoFeature' => 'int',
		'nOrigemValor' => 'int',
		'nIdTipoPrecoBase' => 'int',
		'dPercSobreBase' => 'float',
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
		'nIdTabProdutoFeature',
		'aDescricao',
		'aReduzido',
		'nOrigemValor',
		'nIdTipoPrecoBase',
		'dPercSobreBase',
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
