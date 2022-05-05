<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Positiva;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ConPefinRemessa
 *
 * @property int $ID
 * @property Carbon $dData
 * @property int|null $nNumero
 * @property int|null $nSeqInicial
 * @property int|null $nSeqFinal
 * @property string|null $aNomeArquivo
 * @property Carbon|null $dDataDownload
 * @property string|null $aJsonPefin
 * @property int|null $nStatusRetorno
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
class ConPefinRemessa extends Model
{
    protected $connection = 'mysql_2';
	protected $table = 'ConPefinRemessa';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'nNumero' => 'int',
		'nSeqInicial' => 'int',
		'nSeqFinal' => 'int',
		'nStatusRetorno' => 'int',
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
		'dData',
		'nNumero',
		'nSeqInicial',
		'nSeqFinal',
		'aNomeArquivo',
		'dDataDownload',
		'aJsonPefin',
		'nStatusRetorno',
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
