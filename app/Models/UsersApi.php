<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
/**
 * Class UsersApi
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string|null $access_token
 * @property int $id_empresa
 * @property int $id_contrato
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class UsersApi extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

	protected $table = 'users_api';

	protected $casts = [
		'id_empresa' => 'int',
		'id_contrato' => 'int'
	];

	protected $hidden = [
		'password',
		'access_token'
	];

	protected $fillable = [
		'name',
		'email',
		'password',
		'access_token',
		'id_empresa',
		'id_contrato'
	];
}
