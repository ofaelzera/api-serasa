<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Positiva;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ProdPreco
 *
 * @property int $ID
 * @property int|null $nTipoValor
 * @property int $nIdTipoPreco
 * @property int $nIdProdutoFeature
 * @property int|null $nIdArtigo
 * @property Carbon $dData
 * @property float $dValor
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
class ProdPreco extends Model
{
	protected $table = 'ProdPreco';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'nTipoValor' => 'int',
		'nIdTipoPreco' => 'int',
		'nIdProdutoFeature' => 'int',
		'nIdArtigo' => 'int',
		'dValor' => 'float',
		'nStatus' => 'int',
		'nIdLoginIncluiu' => 'int',
		'nIdLoginAlterou' => 'int',
		'nIdLoginExcluiu' => 'int'
	];

	protected $dates = [
		'dData',
		'dDataIncluiu',
		'dDataAlterou',
		'dDataExcluiu'
	];

	protected $fillable = [
		'nTipoValor',
		'nIdTipoPreco',
		'nIdProdutoFeature',
		'nIdArtigo',
		'dData',
		'dValor',
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
