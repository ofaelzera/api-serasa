<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Positiva;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ConMeProtejaRelatorio
 *
 * @property int $ID
 * @property string $aCliente
 * @property string $aDistribuidor
 * @property string $aJson
 * @property int $nStatus
 * @property Carbon|null $dDataInclusao
 * @property Carbon|null $dDataEnvio
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class ConMeProtejaRelatorio extends Model
{
    protected $connection = 'mysql_2';
	protected $table = 'ConMeProtejaRelatorio';
	protected $primaryKey = 'ID';

	protected $casts = [
		'nStatus' => 'int'
	];

	protected $dates = [
		'dDataInclusao',
		'dDataEnvio'
	];

	protected $fillable = [
		'aCliente',
		'aDistribuidor',
		'aJson',
		'nStatus',
		'dDataInclusao',
		'dDataEnvio'
	];
}
