<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Positiva;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ProdProduto
 *
 * @property int $ID
 * @property int|null $nIdProdutoFeature
 * @property string $aDescricao
 * @property string|null $aReferenciaPlanilha
 * @property string|null $aObs
 * @property int|null $nTipoPessoaDestin
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
class ProdProduto extends Model
{
    protected $connection = 'mysql_2';
	protected $table = 'ProdProduto';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'nIdProdutoFeature' => 'int',
		'nTipoPessoaDestin' => 'int',
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
		'nIdProdutoFeature',
		'aDescricao',
		'aReferenciaPlanilha',
		'aObs',
		'nTipoPessoaDestin',
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
