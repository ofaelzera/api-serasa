<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Positiva;

use Illuminate\Database\Eloquent\Model;

/**
 * Class BasePracaEmbratel
 *
 * @property int $ID
 * @property string|null $aAbreviatura
 * @property string|null $aUF
 * @property string|null $aNomeCidade
 * @property int|null $nIdBaseCidade
 *
 * @package App\Models
 */
class BasePracaEmbratel extends Model
{
	protected $table = 'BasePracaEmbratel';
	protected $primaryKey = 'ID';
	public $timestamps = false;

	protected $casts = [
		'nIdBaseCidade' => 'int'
	];

	protected $fillable = [
		'aAbreviatura',
		'aUF',
		'aNomeCidade',
		'nIdBaseCidade'
	];
}
