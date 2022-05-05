<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Positiva;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class FinNotaFiscal
 *
 * @property int $ID
 * @property int $nIdEmpresa
 * @property Carbon $dData
 * @property int|null $nNumeroLote
 * @property int|null $nRpsInicial
 * @property int|null $nRpsFinal
 * @property string|null $aNomeArquivo
 * @property Carbon|null $dDataDownload
 * @property float|null $dValorServico
 * @property float|null $dValorIssqn
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
class FinNotaFiscal extends Model
{
    protected $connection = 'mysql_2';
	protected $table = 'FinNotaFiscal';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'nIdEmpresa' => 'int',
		'nNumeroLote' => 'int',
		'nRpsInicial' => 'int',
		'nRpsFinal' => 'int',
		'dValorServico' => 'float',
		'dValorIssqn' => 'float',
		'nStatus' => 'int',
		'nIdLoginIncluiu' => 'int',
		'nIdLoginAlterou' => 'int',
		'nIdLoginExcluiu' => 'int'
	];

	protected $dates = [
		'dData',
		'dDataDownload',
		'dDataIncluiu',
		'dDataAlterou',
		'dDataExcluiu'
	];

	protected $fillable = [
		'nIdEmpresa',
		'dData',
		'nNumeroLote',
		'nRpsInicial',
		'nRpsFinal',
		'aNomeArquivo',
		'dDataDownload',
		'dValorServico',
		'dValorIssqn',
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
