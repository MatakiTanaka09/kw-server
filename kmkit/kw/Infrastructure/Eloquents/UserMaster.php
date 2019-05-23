<?php

namespace KW\Infrastructure\Eloquents;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Notifications\CustomPasswordReset;

/**
 * KW\Infrastructure\Eloquents\UserMaster
 *
 * @property int $id
 * @property string $email
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\UserMaster newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\UserMaster newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\UserMaster query()
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\UserMaster whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\UserMaster whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\UserMaster whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\UserMaster wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\UserMaster whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\UserMaster whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class UserMaster extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * @var string
     */
    protected $table = "user_masters";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function userParent()
    {
        $this->hasOne(UserParent::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function roles()
    {
        return $this->morphToMany(
            Role::class,
            'role_relations'
        )->withTimestamps();
    }

    /**
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomPasswordReset($token));
    }
}
