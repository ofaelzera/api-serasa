<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Positiva;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class FinBancoRemessa
 *
 * @property int $ID
 * @property int $nIdBanco
 * @property Carbon $dData
 * @property int|null $nNumero
 * @property int|null $nSeqInicial
 * @property int|null $nSeqFinal
 * @property string|null $aNomeArquivo
 * @property Carbon|null $dDataDownload
 * @property float|null $dValor
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
class FinBancoRemessa extends Model
{
    protected $connection= 'mysql_2';
	protected $table = 'FinBancoRemessa';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'nIdBanco' => 'int',
		'nNumero' => 'int',
		'nSeqInicial' => 'int',
		'nSeqFinal' => 'int',
		'dValor' => 'float',
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
		'nIdBanco',
		'dData',
		'nNumero',
		'nSeqInicial',
		'nSeqFinal',
		'aNomeArquivo',
		'dDataDownload',
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
